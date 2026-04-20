@props(['supplier' => null])

<div x-data="{
    isOpen: false,
    supplier: @json($supplier),
    formData: {
        name: '{{ $supplier?->name ?? '' }}',
        email: '{{ $supplier?->email ?? '' }}',
        phone: '{{ $supplier?->phone ?? '' }}',
        address: '{{ $supplier?->address ?? '' }}'
    },
    errors: {},
    processing: false
}" x-init="if (window.location.hash === '#edit-supplier') { isOpen = true; }">

    <!-- Edit Button -->
    <button @click="isOpen = true; supplier = {{ $supplier ? json_encode($supplier) : 'null' }}; formData = { name: supplier?.name || '', email: supplier?.email || '', phone: supplier?.phone || '', address: supplier?.address || '' };"
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
                        <h3 class="text-lg font-medium text-gray-900">Update Supplier</h3>
                        <button @click="isOpen = false"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ $supplier ? route('suppliers.update', $supplier) : route('suppliers.store') }}"
                      @submit.prevent="handleSubmit"
                      class="px-6 py-4">
                    @csrf
                    @if($supplier)
                        @method('PUT')
                    @endif

                    <!-- Supplier Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Supplier Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               x-model="formData.name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               x-model="formData.email"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone
                        </label>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               x-model="formData.phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                            Address
                        </label>
                        <textarea id="address"
                                  name="address"
                                  rows="3"
                                  x-model="formData.address"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                            <span x-show="!processing">Update Supplier</span>
                            <span x-show="processing">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleSubmit() {
            this.processing = true;
            this.$el.submit();
        }
    </script>
</div>
