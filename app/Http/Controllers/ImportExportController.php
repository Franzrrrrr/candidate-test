<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Services\ImportExportService;

class ImportExportController extends Controller
{
    protected $importExportService;

    public function __construct(ImportExportService $importExportService)
    {
        $this->importExportService = $importExportService;
    }

    public function export(Supplier $supplier)
    {
        return $this->importExportService->exportBySupplier($supplier->id);
    }

    public function import(Request $request, Supplier $supplier)
    {
        $request->validate([
            'import_file' => 'required|file|mimetypes:application/json,text/csv,application/vnd.ms-excel',
            'conflict_resolution' => 'nullable|in:reject,overwrite,skip,duplicate,manual',
            'dry_run' => 'nullable|boolean',
        ]);



        $file = $request->file('import_file');
        $fileContent = file_get_contents($file->getRealPath());

        // Handle both JSON and CSV files
        $data = $this->parseImportFile($file, $fileContent);


        if ($data === false) {
            return redirect()->back()->with('error', 'Invalid file format. Please upload a valid JSON or CSV file.');
        }

        $resolution = $request->input('conflict_resolution', 'skip');
        $isDryRun = $request->boolean('dry_run', false);

        $result = $this->importExportService->importBySupplier($supplier->id, $data, $resolution, $isDryRun);

        if (isset($result['success']) && $result['success']) {
            $message = $isDryRun ? 'Dry run completed successfully.' : 'Import completed successfully.';
            return redirect()->back()->with('success', $message);
        }

        // If conflicts detected, always show the modal for manual resolution
        if (isset($result['conflicts'])) {
            // If user chose automatic resolution, apply it first
            if ($resolution !== 'manual' && $resolution !== 'reject') {
                // Apply automatic resolution and show results
                $autoResult = $this->importExportService->importBySupplier($supplier->id, $data, $resolution, false);
                if (isset($autoResult['success']) && $autoResult['success']) {
                    $message = "Import completed with automatic conflict resolution. {$autoResult['results']['layers_updated']} conflicts resolved.";
                    return redirect()->back()->with('success', $message);
                }
            }

            // For manual resolution or reject, show the conflict modal
            return redirect()->back()->with('manual_conflicts', $result['conflicts']);
        }

        return redirect()->back()->with('error', 'An unknown error occurred during import.');
    }

    private function parseImportFile($file, $fileContent)
    {
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'json') {
            $data = json_decode($fileContent, true);
            return (json_last_error() === JSON_ERROR_NONE) ? $data : false;
        }

        if ($extension === 'csv') {
            // Simple CSV parsing - assuming specific format
            $lines = explode("\n", trim($fileContent));
            $headers = str_getcsv(array_shift($lines));

            $data = ['clt_layups' => []];
            $currentLayup = null;

            foreach ($lines as $line) {
                if (empty(trim($line))) continue;

                $row = str_getcsv($line);
                $rowData = array_combine($headers, $row);

                // If this is a new layup row
                if (isset($rowData['layup_name'])) {
                    if ($currentLayup) {
                        $data['clt_layups'][] = $currentLayup;
                    }

                    $currentLayup = [
                        'name' => $rowData['layup_name'],
                        'clt_layers' => []
                    ];
                }

                // If this is a layer row
                if (isset($rowData['layer_order']) && $currentLayup) {
                    $currentLayup['clt_layers'][] = [
                        'layer_order' => (int) $rowData['layer_order'],
                        'thickness' => (float) $rowData['thickness'],
                        'width' => (float) $rowData['width'],
                        'angle' => (float) $rowData['angle'],
                    ];
                }
            }

            if ($currentLayup) {
                $data['clt_layups'][] = $currentLayup;
            }

            return $data;
        }

        return false;
    }

    public function resolveConflicts(Request $request, Supplier $supplier)
    {
        $request->validate([
            'resolutions' => 'required|array',
            'resolutions.*' => 'required|in:keep,accept',
        ]);

        $resolutions = $request->input('resolutions');
        $conflicts = session('manual_conflicts', []);

        if (empty($conflicts)) {
            return redirect()->back()->with('error', 'No conflicts found to resolve.');
        }

        $result = $this->importExportService->resolveConflicts($supplier->id, $conflicts, $resolutions);

        if (isset($result['success']) && $result['success']) {
            return redirect()->back()->with('success', 'Conflicts resolved and import completed successfully.');
        }

        return redirect()->back()->with('error', 'Failed to resolve conflicts.');
    }
}
