<?php

namespace App\Services;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Repositories\Contracts\CltLayupRepositoryInterface;
use App\Repositories\Contracts\CltLayerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class ImportExportService
{
    protected $supplierRepo;
    protected $layupRepo;
    protected $layerRepo;

    public function __construct(
        SupplierRepositoryInterface $supplierRepo,
        CltLayupRepositoryInterface $layupRepo,
        CltLayerRepositoryInterface $layerRepo
    ) {
        $this->supplierRepo = $supplierRepo;
        $this->layupRepo = $layupRepo;
        $this->layerRepo = $layerRepo;
    }

    public function exportBySupplier($supplierId)
    {
        $supplier = Supplier::with('cltLayups.cltLayers')->findOrFail($supplierId);
        return response()->json($supplier);
    }

    public function importBySupplier($supplierId, array $data, $conflictResolution = 'reject', $isDryRun = false)
    {
        // dd([$supplierId,'data' => $data, 'conflictResolution' => $conflictResolution, 'isDryRun' => $isDryRun]);
        // conflictResolution: reject, overwrite, skip, duplicate, manual

        $supplier = $this->supplierRepo->find($supplierId);
        $importedLayups = $data['clt_layups'] ?? [];
        $results = [
            'layups_created' => 0,
            'layups_updated' => 0,
            'layers_created' => 0,
            'layers_updated' => 0,
            'conflicts' => []
        ];

        // Always detect conflicts first
        $conflicts = $this->detectConflicts($supplierId, $importedLayups);
        // dd($conflicts);

        // If conflicts exist and strategy is reject, return conflicts
        if ($conflictResolution === 'reject' && !empty($conflicts)) {
            return ['success' => false, 'conflicts' => $conflicts];
        }

        // If conflicts exist and strategy is manual, return conflicts for resolution
        if ($conflictResolution === 'manual' && !empty($conflicts)) {
            return ['success' => false, 'conflicts' => $conflicts];
        }

        if (!$isDryRun) {
            DB::beginTransaction();
        }

        try {
            foreach ($importedLayups as $importedLayup) {
                $layup = $this->layupRepo->findByNameAndSupplier($importedLayup['name'], $supplierId);
                $layupName = $importedLayup['name'];

                // Handle duplicate strategy for layups
                if ($layup && $conflictResolution === 'duplicate') {
                    $originalName = $layupName;
                    $suffix = 1;
                    do {
                        $layupName = $originalName . ' (imported' . ($suffix > 1 ? " $suffix" : '') . ')';
                        $existingLayup = $this->layupRepo->findByNameAndSupplier($layupName, $supplierId);
                        $suffix++;
                    } while ($existingLayup);

                    $layup = null; // Force creation of new layup
                }

                if (!$layup) {
                    if (!$isDryRun) {
                        $layup = $this->layupRepo->create([
                            'supplier_id' => $supplierId,
                            'name' => $layupName,
                        ]);
                    } else {
                        $layup = (object) ['id' => 'dry-run-id', 'name' => $layupName];
                    }
                    $results['layups_created']++;
                }

                if (isset($importedLayup['clt_layers'])) {
                    foreach ($importedLayup['clt_layers'] as $importedLayer) {
                        $layer = $this->layerRepo->findByOrderAndLayup($importedLayer['layer_order'], $layup->id);

                        if ($layer) {
                            $isConflict = $this->isLayerConflict($layer, $importedLayer);
                            if ($isConflict) {
                                if ($conflictResolution === 'overwrite') {
                                    if (!$isDryRun) {
                                        $this->layerRepo->update($layer->id, [
                                            'thickness' => $importedLayer['thickness'],
                                            'width' => $importedLayer['width'],
                                            'angle' => $importedLayer['angle'],
                                        ]);
                                    }
                                    $results['layers_updated']++;
                                } elseif ($conflictResolution === 'skip') {
                                    // Do nothing
                                } elseif ($conflictResolution === 'manual') {
                                    // Collect conflicts for manual resolution
                                    $results['conflicts'][] = [
                                        'layup_id' => $layup->id,
                                        'layup_name' => $layup->name,
                                        'layer_id' => $layer->id,
                                        'layer_order' => $layer->layer_order,
                                        'existing' => [
                                            'thickness' => $layer->thickness,
                                            'width' => $layer->width,
                                            'angle' => $layer->angle,
                                        ],
                                        'imported' => [
                                            'thickness' => $importedLayer['thickness'],
                                            'width' => $importedLayer['width'],
                                            'angle' => $importedLayer['angle'],
                                        ],
                                    ];
                                }
                            }
                        } else {
                            if (!$isDryRun) {
                                $this->layerRepo->create([
                                    'layup_id' => $layup->id,
                                    'layer_order' => $importedLayer['layer_order'],
                                    'thickness' => $importedLayer['thickness'],
                                    'width' => $importedLayer['width'],
                                    'angle' => $importedLayer['angle'],
                                ]);
                            }
                            $results['layers_created']++;
                        }
                    }
                }
            }

            if (!$isDryRun) {
                DB::commit();
            }

            // Always return conflicts for modal display if any exist
            if (!empty($results['conflicts'])) {
                return ['success' => false, 'conflicts' => $results['conflicts'], 'dry_run' => $isDryRun];
            }

            return ['success' => true, 'results' => $results, 'dry_run' => $isDryRun];
        } catch (Exception $e) {
            if (!$isDryRun) {
                DB::rollBack();
            }
            throw $e;
        }
    }

    public function detectConflicts($supplierId, array $importedLayups)
    {
        $conflicts = [];

        foreach ($importedLayups as $importedLayup) {
            $layup = $this->layupRepo->findByNameAndSupplier($importedLayup['name'], $supplierId);

            if ($layup && isset($importedLayup['clt_layers'])) {
                foreach ($importedLayup['clt_layers'] as $importedLayer) {
                    $layer = $this->layerRepo->findByOrderAndLayup($importedLayer['layer_order'], $layup->id);
                    if ($layer && $this->isLayerConflict($layer, $importedLayer)) {
                        $conflicts[] = [
                            'layup_name' => $layup->name,
                            'layer_order' => $layer->layer_order,
                            'existing' => [
                                'thickness' => $layer->thickness,
                                'width' => $layer->width,
                                'angle' => $layer->angle,
                            ],
                            'imported' => [
                                'thickness' => $importedLayer['thickness'],
                                'width' => $importedLayer['width'],
                                'angle' => $importedLayer['angle'],
                            ],
                        ];
                    }
                }
            }
        }


        return $conflicts;
    }

    private function isLayerConflict($existingLayer, $importedLayer)
    {
        // If layer_order matches AND (thickness OR width OR angle) differ
        return (
            (float) $existingLayer->thickness == (float) $importedLayer['thickness'] &&
            (float) $existingLayer->width == (float) $importedLayer['width'] &&
            (float) $existingLayer->angle == (float) $importedLayer['angle']
        );
    }

    public function resolveConflicts($supplierId, array $conflicts, array $resolutions)
    {
        DB::beginTransaction();

        try {
            foreach ($conflicts as $index => $conflict) {
                $resolution = $resolutions[$index] ?? null;

                if ($resolution === 'accept') {
                    // Apply imported data
                    $this->layerRepo->update($conflict['layer_id'], [
                        'thickness' => $conflict['imported']['thickness'],
                        'width' => $conflict['imported']['width'],
                        'angle' => $conflict['imported']['angle'],
                    ]);
                }
                // If resolution === 'keep', do nothing (keep existing data)
            }

            DB::commit();
            return ['success' => true];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
