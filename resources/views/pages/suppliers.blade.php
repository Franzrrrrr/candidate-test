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

            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
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

                    <!-- ROW 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold">
                                NT
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Nordic Timber Co.</p>
                                <p class="text-xs text-gray-400">ID: SUP-2023-001</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">24</td>
                        <td class="px-6 py-4">Oct 24, 2023</td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <!-- ROW 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600 font-semibold">
                                AC
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Alpine CLT Solutions</p>
                                <p class="text-xs text-gray-400">ID: SUP-2023-042</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">12</td>
                        <td class="px-6 py-4">Nov 02, 2023</td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <!-- ROW 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-100 text-orange-600 font-semibold">
                                MW
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">MassivWood Ltd.</p>
                                <p class="text-xs text-gray-400">ID: SUP-2024-003</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">156</td>
                        <td class="px-6 py-4">Jan 15, 2024</td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <!-- ROW 4 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 text-purple-600 font-semibold">
                                TS
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">TimberStruct Inc.</p>
                                <p class="text-xs text-gray-400">ID: SUP-2024-008</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">89</td>
                        <td class="px-6 py-4">Feb 10, 2024</td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <!-- ROW 5 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-teal-100 text-teal-600 font-semibold">
                                EL
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">EuroLam Systems</p>
                                <p class="text-xs text-gray-400">ID: SUP-2024-015</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">45</td>
                        <td class="px-6 py-4">Feb 28, 2024</td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

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
</x-app-layout>
