<x-app-layout>

    <!-- HEADER -->
    <div class="max-w-7xl mx-auto px-6 py-6">

        <!-- Breadcrumb -->
        <p class="text-sm text-gray-400 mb-3">
            Suppliers / {{$supplier->name}}
        </p>

        <!-- Card Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-semibold text-gray-800">
                        {{$supplier->name}}
                    </h1>
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                        Active Partner
                    </span>
                </div>
                <p class="text-sm text-gray-400 mt-1">
                    ID: {{$supplier->ext_id}}
                </p>
            </div>

            <button class="border px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                ✏️ Edit Supplier
            </button>
        </div>

        <!-- INFO GRID -->
        <!-- <div class="grid grid-cols-4 gap-4 mt-4">

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-xs text-gray-400 mb-1">Primary Contact</p>
                <p class="text-sm text-gray-700">engineering@nordic.ca</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-xs text-gray-400 mb-1">Location</p>
                <p class="text-sm text-gray-700">Montreal, QC, Canada</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-xs text-gray-400 mb-1">Material Certifications</p>
                <p class="text-sm text-gray-700">SPF No. 1/2, D. Fir-L</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <p class="text-xs text-gray-400 mb-1">Last Audit Date</p>
                <p class="text-sm text-gray-700">Oct 12, 2023</p>
            </div>

        </div> -->

        <!-- LAYUPS HEADER -->
        <div class="flex items-center justify-between mt-8 mb-3">
            <h2 class="text-md font-semibold text-gray-700">
                Associated Layups
            </h2>

            <div class="flex gap-2">
                <button x-data x-on:click="$dispatch('open-modal', 'import-layup')" class="px-3 py-2 border rounded-lg text-sm hover:bg-gray-100">
                    Import
                </button>
                <a href="{{ route('suppliers.export', $supplier) }}" target="_blank" class="px-3 py-2 border rounded-lg text-sm hover:bg-gray-100 inline-block">
                    Export
                </a>
                <button
                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700"
                x-data
                x-on:click="$dispatch('open-modal', 'create-layup')"
            >
                + Add Layup
            </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('conflicts'))
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
                <p class="font-bold">Conflicts detected during import:</p>
                <ul class="list-disc pl-5">
                    @foreach(session('conflicts') as $conflict)
                    @php
                        \Log::info($conflict);
                    @endphp
                        <li>Layup: {{ $conflict['layup_name'] }}, Layer Order: {{ $conflict['layer_order'] }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('manual_conflicts'))
        @php
            \Log::info(session('manual_conflicts'));
        @endphp
            <!-- Conflict Detection Alert -->
            <div class="bg-orange-100 border border-orange-200 rounded-lg p-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-200 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-orange-800">Conflicts Detected During Import</h3>
                        <p class="text-xs text-orange-600 mt-1">
                            {{ count(session('manual_conflicts')) }} conflict(s) found. Please review and resolve them manually.
                        </p>
                    </div>
                </div>
            </div>

            <x-conflict-resolution-modal :conflicts="session('manual_conflicts')" :supplier="$supplier" />
        @endif

        <!-- TABLE -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm">

                <!-- HEAD -->
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Layup ID</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">

                    @foreach ($layups as $layup)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $layup->id }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('layups.show', [$supplier, $layup]) }}" class="text-blue-600 hover:underline">
                                    {{ $layup->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-3">
                                <a href="{{ route('inventory', [$supplier, $layup]) }}" class="text-green-600 hover:underline text-sm">View Layers</a>
                                <form action="{{ route('layups.destroy', [$supplier, $layup]) }}" method="POST" onsubmit="return confirm('Delete this layup?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <!-- Pagination -->
            @if($layups->hasPages())
                <div class="flex items-center justify-between px-6 py-4 text-sm text-gray-500 border-t">
                    <p>
                        Showing {{ $layups->firstItem() ?? 0 }} to {{ $layups->lastItem() ?? 0 }}
                        of {{ $layups->total() }} layups
                    </p>

                    {{ $layups->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- <x-modal name="import-layup">
        <form method="POST" action="{{ route('suppliers.import', $supplier) }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold mb-4">Import Layups</h2>

            <div class="mb-4">
                <label class="block text-sm mb-1">JSON File</label>
                <input
                    type="file"
                    name="import_file"
                    accept=".json,application/json"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1">Conflict Resolution</label>
                <select name="conflict_resolution" class="w-full border rounded p-2">
                    <option value="reject">Reject Import</option>
                    <option value="overwrite">Overwrite Existing</option>
                    <option value="skip">Skip Conflict</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="px-4 py-2 border rounded"
                    x-on:click="$dispatch('close-modal', 'import-layup')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded"
                >
                    Import
                </button>
            </div>
        </form>
    </x-modal> -->

    <x-modal name="import-layup" maxWidth="2xl">
        <form method="POST"
            action="{{ route('suppliers.import', $supplier) }}"
            enctype="multipart/form-data"
            class="p-0">

            @csrf

            <!-- HEADER -->
            <div class="px-6 py-5 border-b flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Import Layup Data
                    </h2>
                    <p class="text-sm text-gray-400 mt-1">
                        Upload JSON / CSV file for supplier layups.
                    </p>
                </div>

                <button type="button"
                    x-on:click="$dispatch('close-modal', 'import-layup')"
                    class="text-gray-400 hover:text-gray-700 text-xl">
                    ×
                </button>
            </div>

            <!-- BODY -->
            <div class="p-6 space-y-5">

                <!-- Upload Area -->
                <div x-data="{ fileName: '' }">

                    <label
                        class="border-2 border-dashed border-gray-300 rounded-xl p-8 block cursor-pointer hover:border-green-500 transition">

                        <input
                            type="file"
                            name="import_file"
                            accept=".json,.csv"
                            class="hidden"
                            required
                            @change="fileName = $event.target.files[0].name"
                        >

                        <div class="text-center">
                            <div class="text-3xl mb-2">📤</div>

                            <p class="text-sm text-gray-700 font-medium">
                                Click to upload
                            </p>

                            <p class="text-xs text-gray-400 mt-1" x-show="!fileName">
                                CSV or JSON up to 10MB
                            </p>

                            <p class="text-sm text-green-600 mt-2 font-medium" x-text="fileName" x-show="fileName"></p>
                        </div>

                    </label>

                </div>

                <!-- Conflict Strategy -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Conflict Resolution Strategy
                    </label>

                    <select
                        name="conflict_resolution"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">

                        <option value="skip">
                            Skip conflicts (Default)
                        </option>

                        <option value="overwrite">
                            Overwrite Existing
                        </option>

                        <option value="duplicate">
                            Duplicate Layup
                        </option>

                        <option value="manual">
                            Manual Resolution
                        </option>

                        <option value="reject">
                            Reject Entire Import
                        </option>

                    </select>
                </div>

                <!-- Dry Run -->
                <label
                    class="flex items-start gap-3 border rounded-lg px-4 py-3 cursor-pointer">

                    <input
                        type="checkbox"
                        name="dry_run"
                        value="1"
                        class="mt-1 rounded border-gray-300">

                    <div>
                        <p class="text-sm font-medium text-gray-700">
                            Run as Dry Run
                        </p>

                        <p class="text-xs text-gray-400">
                            Preview the import process without saving changes.
                        </p>
                    </div>

                </label>

                <!-- Warning -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-red-700">
                        Potential Conflicts Detected
                    </p>

                    <p class="text-xs text-red-500 mt-1">
                        Existing layups with same names may trigger conflict resolution.
                    </p>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="px-6 py-4 border-t flex justify-end gap-3">

                <button
                    type="button"
                    x-on:click="$dispatch('close-modal', 'import-layup')"
                    class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-100">

                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">

                    Confirm Import
                </button>

            </div>

        </form>
    </x-modal>

    <x-modal name="create-layup">
        <form method="POST" action="{{ route('layups.store', $supplier) }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold mb-4">Create Layup</h2>

            <div class="mb-4">
                <label class="block text-sm mb-1">Name</label>
                <input
                    type="text"
                    name="name"
                    class="w-full border rounded p-2"
                    placeholder="Layup name..."
                    required
                >
            </div>
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="px-4 py-2 border rounded"
                    x-on:click="$dispatch('close-modal', 'create-layup')"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded"
                >
                    Create
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
