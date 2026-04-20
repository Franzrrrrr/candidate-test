@props(['layup' => null, 'supplier' => null])

<div
    x-data="{
        isOpen: false,
        processing: false,
        layup: @js($layup),
        supplier: @js($supplier),

        formData: {
            name: '{{ $layup?->name ?? '' }}',
            description: '{{ $layup?->description ?? '' }}'
        },

        openModal() {
            this.isOpen = true

            this.formData = {
                name: this.layup?.name ?? '',
                description: this.layup?.description ?? ''
            }
        },

        closeModal() {
            this.isOpen = false
            this.processing = false
        },

        handleSubmit() {
            this.processing = true
            this.$refs.form.submit()
        }
    }"
>
    <!-- BUTTON -->
    <button
        type="button"
        @click="openModal()"
        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
    >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
    </button>

    <!-- MODAL -->
    <div
        x-show="isOpen"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
        style="display:none"
    >
        <!-- BACKDROP -->
        <div
            class="absolute inset-0 bg-black/50"
            @click="closeModal()"
        ></div>

        <!-- PANEL -->
        <div
            @click.stop
            class="relative bg-white rounded-xl shadow-xl w-full max-w-lg"
        >
            <!-- HEADER -->
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">
                    Update Layup
                </h2>

                <button
                    type="button"
                    @click="closeModal()"
                    class="text-gray-400 hover:text-gray-700 text-xl"
                >
                    ×
                </button>
            </div>

            <!-- FORM -->
            <form
                x-ref="form"
                method="POST"
                action="{{ route('layups.update', [$supplier, $layup]) }}"
                @submit.prevent="handleSubmit()"
                class="p-6"
            >
                @csrf
                @method('PUT')

                <!-- NAME -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Layup Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        x-model="formData.name"
                        required
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    >
                </div>

                <!-- DESCRIPTION -->
                {{-- <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        x-model="formData.description"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    ></textarea>
                </div> --}}

                <!-- SUPPLIER -->
                <div class="mb-6 p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
                    Supplier: {{ $supplier->name }}
                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        @click="closeModal()"
                        class="px-4 py-2 border rounded-lg"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        :disabled="processing"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg disabled:opacity-50"
                    >
                        <span x-show="!processing">Update</span>
                        <span x-show="processing">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
