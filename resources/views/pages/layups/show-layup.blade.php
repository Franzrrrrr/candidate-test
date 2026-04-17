<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-6">

    <!-- BREADCRUMB -->
    <p class="text-sm text-gray-400 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:underline">Home</a> / 
        <a href="{{ route('suppliers.show', $supplier) }}" class="hover:underline">{{ $supplier->name }}</a> / 
        Layups / {{ $layup->name }}
    </p>

    <!-- HEADER CARD -->
    <div class="bg-white rounded-lg shadow-sm p-6 flex justify-between items-start">

        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-semibold text-gray-800">
                    Layup Specification: {{ $layup->name }}
                </h1>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                    Active
                </span>
            </div>

            <p class="text-sm text-gray-400 mt-1">
                Standard {{ $layup->cltLayers->count() }}-layer panel.
            </p>
        </div>

    </div>

    <!-- META INFO -->
    <div class="grid grid-cols-4 gap-4 mt-4">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Supplier</p>
            <p class="text-sm text-gray-700">{{ $supplier->name }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Last Modified</p>
            <p class="text-sm text-gray-700">{{ $layup->updated_at->format('M d, Y') }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Total Thickness</p>
            <p class="text-sm text-green-600 font-semibold">{{ number_format($layup->cltLayers->sum('thickness'), 2) }}mm</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <p class="text-xs text-gray-400">Total Layers</p>
            <p class="text-sm text-green-600 font-semibold">{{ $layup->cltLayers->count() }} Layers</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mt-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN GRID -->
    <div class="grid grid-cols-2 gap-6 mt-6">

        <!-- LEFT: TABLE -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-md font-semibold text-gray-700">
                    Layer Composition
                </h2>
                <button x-data x-on:click="$dispatch('open-modal', 'add-layer')" class="text-green-600 text-sm hover:underline">
                    + Add Layer
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Order</th>
                            <th class="px-4 py-3 text-left">Thickness</th>
                            <th class="px-4 py-3 text-left">Width</th>
                            <th class="px-4 py-3 text-left">Angle</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($layup->cltLayers->sortBy('layer_order') as $layer)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $layer->layer_order }}</td>
                                <td class="px-4 py-3">{{ number_format($layer->thickness, 2) }}mm</td>
                                <td class="px-4 py-3">{{ number_format($layer->width, 2) }}mm</td>
                                <td class="px-4 py-3 text-{{ $layer->angle == 0 ? 'green-600' : 'orange-500' }}">{{ $layer->angle }}°</td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('layers.destroy', [$layup, $layer]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this layer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500 text-xs">No layers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex justify-between px-4 py-3 text-xs text-gray-400">
                    <p>Showing {{ $layup->cltLayers->count() }} layers</p>
                    <p>Calculated Sum: {{ number_format($layup->cltLayers->sum('thickness'), 2) }} mm</p>
                </div>
            </div>

            <!-- NOTE -->
            <div class="bg-white rounded-lg shadow-sm p-4 mt-4">
                <p class="text-sm font-medium text-gray-700 mb-1">
                    Engineering Note
                </p>
                <p class="text-xs text-gray-400">
                    Ensure bonding pressure is adjusted for varying layer grades.
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
                    <span class="inline-block w-3 h-3 bg-yellow-200 border border-gray-300 mr-1"></span> Longitudinal (0°) &nbsp;&nbsp; 
                    <span class="inline-block w-3 h-3 bg-orange-300 border border-gray-300 mr-1"></span> Transverse (90°)
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 flex justify-center">

                <div class="w-48 space-y-1">
                    @forelse ($layup->cltLayers->sortBy('layer_order') as $layer)
                        @php
                            $bgClass = $layer->angle == 0 ? 'bg-yellow-200' : 'bg-orange-300';
                            $paddingClass = $layer->thickness >= 40 ? 'py-4' : ($layer->thickness >= 20 ? 'py-2' : 'py-1');
                        @endphp
                        <div class="{{ $bgClass }} text-center {{ $paddingClass }} rounded text-xs border border-gray-300 shadow-sm">
                            L{{ $layer->layer_order }} ({{ number_format($layer->thickness, 2) }}mm)
                        </div>
                    @empty
                        <div class="text-center text-gray-400 text-sm py-4">No layers to visualize</div>
                    @endforelse
                </div>

            </div>

            <p class="text-xs text-gray-400 text-center mt-2">
                Cross-Laminated Structural Assembly
            </p>
        </div>

    </div>

</div>

<!-- Modal for adding a layer -->
<x-modal name="add-layer">
    <form method="POST" action="{{ route('layers.store', $layup) }}" class="p-6">
        @csrf

        <h2 class="text-lg font-semibold mb-4">Add Layer</h2>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm mb-1">Order</label>
                <input type="number" name="layer_order" class="w-full border rounded p-2" value="{{ $layup->cltLayers->count() + 1 }}" required>
            </div>
            <div>
                <label class="block text-sm mb-1">Thickness (mm)</label>
                <input type="number" step="0.01" name="thickness" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-sm mb-1">Width (mm)</label>
                <input type="number" step="0.01" name="width" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-sm mb-1">Angle (°)</label>
                <select name="angle" class="w-full border rounded p-2" required>
                    <option value="0">0°</option>
                    <option value="90">90°</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <button type="button" class="px-4 py-2 border rounded hover:bg-gray-100" x-on:click="$dispatch('close-modal', 'add-layer')">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Layer</button>
        </div>
    </form>
</x-modal>

</x-app-layout>
