@props(['layer' => null, 'layup' => null])

<div x-data="{
    isOpen: false,
    layer: {{ $layer ? json_encode($layer) : 'null' }},
    layup: {{ $layup ? json_encode($layup) : 'null' }},
    formData: {
        layer_order: '{{ $layer?->layer_order ?? '' }}',
        thickness: '{{ $layer?->thickness ?? '' }}',
        width: '{{ $layer?->width ?? '' }}',
        angle: '{{ $layer?->angle ?? '' }}'
    },
    errors: {},
    processing: false,
    handleSubmit(event) {
        this.processing = true;
        event.target.submit();
    },
    openModal() {
        this.isOpen = true;
        this.layer = {{ $layer ? json_encode($layer) : 'null' }};
        this.formData = {
            layer_order: this.layer?.layer_order || '',
            thickness: this.layer?.thickness || '',
            width: this.layer?.width || '',
            angle: this.layer?.angle || ''
        };
    }
}">

    <!-- Edit Button -->
    <button @click="openModal()"
            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        Edit
    </button>

    <!-- Modal -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Background overlay -->
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75"
                 @click="isOpen = false">
            </div>

            <!-- Modal Panel -->
            <div class="relative bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full"
                 x-show="isOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.stop>

                <!-- Header -->
                <div class="bg-white px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Update Layer</h3>
                        <button @click="isOpen = false"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ $layer ? route('layers.update', [$layup, $layer]) : route('layers.store', $layup) }}"
                      @submit.prevent="handleSubmit"
                      class="px-6 py-4">
                    @csrf
                    @if($layer)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- Layer Order -->
                        <div>
                            <label for="layer_order" class="block text-sm font-medium text-gray-700 mb-1">
                                Order <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="layer_order"
                                   name="layer_order"
                                   x-model="formData.layer_order"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   min="1"
                                   required>
                            @error('layer_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Thickness -->
                        <div>
                            <label for="thickness" class="block text-sm font-medium text-gray-700 mb-1">
                                Thickness (mm) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="thickness"
                                   name="thickness"
                                   x-model="formData.thickness"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   step="0.01"
                                   min="0.01"
                                   required>
                            @error('thickness')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Width -->
                        <div>
                            <label for="width" class="block text-sm font-medium text-gray-700 mb-1">
                                Width (mm) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="width"
                                   name="width"
                                   x-model="formData.width"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   step="0.01"
                                   min="0.01"
                                   required>
                            @error('width')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Angle -->
                        <div>
                            <label for="angle" class="block text-sm font-medium text-gray-700 mb-1">
                                Angle (°) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="angle"
                                   name="angle"
                                   x-model="formData.angle"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   step="0.1"
                                   min="-90"
                                   max="90"
                                   required>
                            @error('angle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Layup Info (Read-only) -->
                    @if($layup)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <strong>Layup:</strong> {{ $layup->name }}
                        </p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                @click="isOpen = false"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit"
                                :disabled="processing"
                                class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                            <span x-show="!processing">Update Layer</span>
                            <span x-show="processing">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
