<x-app-layout>

    <!-- HEADER -->
    <div class="max-w-7xl mx-auto px-6 py-6">

        <!-- Breadcrumb -->
        <p class="text-sm text-gray-400 mb-3">
            Suppliers / Nordic Structures Inc.
        </p>

        <!-- Card Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-semibold text-gray-800">
                        Nordic Structures Inc.
                    </h1>
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                        Active Partner
                    </span>
                </div>
                <p class="text-sm text-gray-400 mt-1">
                    ID: SUP-2024-001
                </p>
            </div>

            <button class="border px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                ✏️ Edit Supplier
            </button>
        </div>

        <!-- INFO GRID -->
        <div class="grid grid-cols-4 gap-4 mt-4">

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

        </div>

        <!-- LAYUPS HEADER -->
        <div class="flex items-center justify-between mt-8 mb-3">
            <h2 class="text-md font-semibold text-gray-700">
                Associated Layups
            </h2>

            <div class="flex gap-2">
                <button class="px-3 py-2 border rounded-lg text-sm hover:bg-gray-100">
                    Import
                </button>
                <button class="px-3 py-2 border rounded-lg text-sm hover:bg-gray-100">
                    Export
                </button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                    + Add Layup
                </button>
            </div>
        </div>

        <!-- TABLE -->
        {{-- <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm">

                <!-- HEAD -->
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Layup ID</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3">Thickness</th>
                        <th class="px-6 py-3">Ply Count</th>
                        <th class="px-6 py-3">Species/Grade</th>
                        <th class="px-6 py-3">Revision</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">L-204-A</td>
                        <td class="px-6 py-4">Standard 3-Ply Wall</td>
                        <td class="px-6 py-4 text-center">105mm</td>
                        <td class="px-6 py-4 text-center">3</td>
                        <td class="px-6 py-4">Spruce / No. 2</td>
                        <td class="px-6 py-4 text-xs text-gray-400">Rev 2 (Oct 10)</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">L-204-B</td>
                        <td class="px-6 py-4">Heavy Floor Panel</td>
                        <td class="px-6 py-4 text-center">175mm</td>
                        <td class="px-6 py-4 text-center">5</td>
                        <td class="px-6 py-4">Spruce / Select</td>
                        <td class="px-6 py-4 text-xs text-gray-400">Rev 1 (Sep 22)</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">L-500-X</td>
                        <td class="px-6 py-4">Custom Span Beam</td>
                        <td class="px-6 py-4 text-center">245mm</td>
                        <td class="px-6 py-4 text-center">7</td>
                        <td class="px-6 py-4">Pine / No. 1</td>
                        <td class="px-6 py-4 text-xs text-gray-400">Draft v2</td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">
                                Draft
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">L-205-C</td>
                        <td class="px-6 py-4">Standard 3-Ply Floor</td>
                        <td class="px-6 py-4 text-center">105mm</td>
                        <td class="px-6 py-4 text-center">3</td>
                        <td class="px-6 py-4">Spruce / No. 2</td>
                        <td class="px-6 py-4 text-xs text-gray-400">Rev 1 (Jan 15)</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">
                                Archived
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">•••</td>
                    </tr>

                </tbody>
            </table>

            <!-- FOOTER -->
            <div class="flex justify-between items-center px-6 py-4 text-sm text-gray-400">
                <p>Showing 4 of 12 layups</p>
                <div class="flex gap-2">
                    <button class="px-2 py-1 border rounded">‹</button>
                    <button class="px-2 py-1 border rounded">›</button>
                </div>
            </div>

        </div> --}}

    </div>

</x-app-layout>
