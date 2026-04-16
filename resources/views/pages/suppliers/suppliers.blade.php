<x-app-layout>
    <!-- HEADER -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Suppliers
                </h2>
                <p class="text-sm text-gray-500">
                    Manage timber suppliers and material sourcing.
                </p>
            </div>

           <button
                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700"
                x-data
                x-on:click="$dispatch('open-modal', 'create-supplier')"
            >
                + Add Supplier
            </button>
        </div>
    </x-slot>

    <!-- SEARCH + ACTION -->
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- SEARCH -->
        <div class="relative w-80">
            <input
                type="text"
                placeholder="Search suppliers by name..."
                class="w-full h-10 pl-10 pr-4 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                🔍
            </span>
        </div>

        <!-- ACTION BUTTON -->
        <div class="flex gap-2">
            <button class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                Filter
            </button>
            <button class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                Export
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="max-w-7xl mx-auto px-6 pb-6">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">

            <table class="w-full text-sm text-left">

                <!-- HEAD -->
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Total Layups</th>
                        <th class="px-6 py-3">Created At</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">
                    @foreach ($suppliers as $supplier)
                        <tr
                            class="hover:bg-green-100 cursor-pointer"
                            onclick="window.location='{{ route('suppliers.show', $supplier) }}'"
                        >
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold">
                                    {{ substr($supplier->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $supplier->name }}</p>
                                    <p class="text-xs text-gray-400">ID: {{ $supplier->ext_id }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $supplier->cltLayups->count() }}</td>
                            <td class="px-6 py-4">{{ $supplier->created_at->format('M j, Y') ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-right">•••</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- FOOTER -->
            <div class="flex items-center justify-between px-6 py-4 text-sm text-gray-500">
                <p>Showing 1 to 5 of 42 results</p>
                <div class="flex gap-2">
                    <button class="px-2 py-1 border rounded">‹</button>
                    <button class="px-2 py-1 border rounded">›</button>
                </div>
            </div>

        </div>
    </div>

    <x-modal name="create-supplier">
        <form method="POST" action="{{ route('suppliers.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold mb-4">Create Supplier</h2>

            <!-- INPUT -->
            <div class="mb-4">
                <label class="block text-sm mb-1">Name</label>
                <input
                    type="text"
                    name="name"
                    class="w-full border rounded p-2"
                    placeholder="Supplier name..."
                    required
                >
            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="px-4 py-2 border rounded"
                    x-on:click="$dispatch('close-modal', 'create-supplier')"
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
