<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-6">

    <!-- BREADCRUMB -->
    <p class="text-sm text-gray-400 mb-4">
        Home / Suppliers / Layups / L-2023-X
    </p>

    <!-- HEADER CARD -->
    <div class="bg-white rounded-lg shadow-sm p-6 flex justify-between items-start">

        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-semibold text-gray-800">
                    Layup Specification: L-2023-X
                </h1>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                    Active
                </span>
            </div>

            <p class="text-sm text-gray-400 mt-1">
                Standard 5-layer panel for residential structural walls.
            </p>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-100">
                Duplicate
            </button>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                Save Changes
            </button>
        </div>

    </div>

    <!-- META INFO -->
    <div class="grid grid-cols-5 gap-4 mt-4">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Created By</p>
            <p class="text-sm text-gray-700">Eng. Dept A</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Last Modified</p>
            <p class="text-sm text-gray-700">Oct 24, 2023</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Total Thickness</p>
            <p class="text-sm text-green-600 font-semibold">140mm</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Total Layers</p>
            <p class="text-sm text-green-600 font-semibold">5 Layers</p>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-2 gap-6 mt-6">

        <!-- LEFT: TABLE -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-md font-semibold text-gray-700">
                    Layer Composition
                </h2>
                <button class="text-green-600 text-sm hover:underline">
                    + Add Layer
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Thickness</th>
                            <th class="px-4 py-3">Width</th>
                            <th class="px-4 py-3">Angle</th>
                            <th class="px-4 py-3">Grade</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">1</td>
                            <td class="px-4 py-3">40mm</td>
                            <td class="px-4 py-3">1200mm</td>
                            <td class="px-4 py-3">0°</td>
                            <td class="px-4 py-3 text-green-600">C24</td>
                            <td class="px-4 py-3">•••</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">2</td>
                            <td class="px-4 py-3">20mm</td>
                            <td class="px-4 py-3">1200mm</td>
                            <td class="px-4 py-3 text-orange-500">90°</td>
                            <td class="px-4 py-3 text-gray-600">C16</td>
                            <td class="px-4 py-3">•••</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">3</td>
                            <td class="px-4 py-3">40mm</td>
                            <td class="px-4 py-3">1200mm</td>
                            <td class="px-4 py-3">0°</td>
                            <td class="px-4 py-3 text-green-600">C24</td>
                            <td class="px-4 py-3">•••</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">4</td>
                            <td class="px-4 py-3">20mm</td>
                            <td class="px-4 py-3">1200mm</td>
                            <td class="px-4 py-3 text-orange-500">90°</td>
                            <td class="px-4 py-3 text-gray-600">C16</td>
                            <td class="px-4 py-3">•••</td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">5</td>
                            <td class="px-4 py-3">40mm</td>
                            <td class="px-4 py-3">1200mm</td>
                            <td class="px-4 py-3">0°</td>
                            <td class="px-4 py-3 text-green-600">C24</td>
                            <td class="px-4 py-3">•••</td>
                        </tr>

                    </tbody>
                </table>

                <div class="flex justify-between px-4 py-3 text-xs text-gray-400">
                    <p>Showing 5 layers</p>
                    <p>Calculated Sum: 140.00 mm</p>
                </div>
            </div>

            <!-- NOTE -->
            <div class="bg-white rounded-lg shadow-sm p-4 mt-4">
                <p class="text-sm font-medium text-gray-700 mb-1">
                    Engineering Note
                </p>
                <p class="text-xs text-gray-400">
                    Ensure bonding pressure is adjusted for varying layer grades (C24/C16 mix).
                    Verify alignment of 90° transverse layers.
                </p>
            </div>

        </div>

        <!-- RIGHT: VISUALIZER -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-md font-semibold text-gray-700">
                    Structure Visualizer
                </h2>
                <div class="text-xs text-gray-400">
                    ◼ Longitudinal &nbsp;&nbsp; ◼ Transverse
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 flex justify-center">

                <div class="w-48 space-y-2">

                    <div class="bg-yellow-200 text-center py-3 rounded">
                        L1 (40mm)
                    </div>

                    <div class="bg-orange-300 text-center py-2 rounded">
                        L2 (20mm)
                    </div>

                    <div class="bg-yellow-200 text-center py-3 rounded">
                        L3 (40mm)
                    </div>

                    <div class="bg-orange-300 text-center py-2 rounded">
                        L4 (20mm)
                    </div>

                    <div class="bg-yellow-200 text-center py-3 rounded">
                        L5 (40mm)
                    </div>

                </div>

            </div>

            <p class="text-xs text-gray-400 text-center mt-2">
                Cross-Laminated Structural Assembly
            </p>
        </div>

    </div>

</div>

</x-app-layout>
