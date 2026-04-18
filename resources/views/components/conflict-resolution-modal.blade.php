@props(['conflicts', 'supplier'])

<div
    x-data="{
        showModal: {{ count($conflicts) ? 'true' : 'false' }},
        conflicts: @js($conflicts),
        currentConflictIndex: 0,
        resolutions: {},

        get currentConflict() {
            return this.conflicts[this.currentConflictIndex] ?? null
        },

        get total() {
            return this.conflicts.length
        },

        get allResolved() {
            return Object.keys(this.resolutions).length === this.total
        },

        nextConflict() {
            if (this.currentConflictIndex < this.total - 1) {
                this.currentConflictIndex++
            }
        },

        previousConflict() {
            if (this.currentConflictIndex > 0) {
                this.currentConflictIndex--
            }
        },

        resolveConflict(action) {
            this.resolutions[this.currentConflictIndex] = action

            if (this.currentConflictIndex < this.total - 1) {
                this.nextConflict()
            } else if (this.allResolved) {
                this.submitResolutions()
            }
        },

        getConflictDescription(conflict) {
            let diff = []

            if (conflict.existing.thickness != conflict.imported.thickness) {
                diff.push('Thickness')
            }

            if (conflict.existing.width != conflict.imported.width) {
                diff.push('Width')
            }

            if (conflict.existing.angle != conflict.imported.angle) {
                diff.push('Angle')
            }

            return diff.length ? diff.join(', ') + ' mismatch' : 'No difference'
        },

        submitResolutions() {
            const form = document.getElementById('resolve-form')

            document.getElementById('resolutions-input').value =
                JSON.stringify(this.resolutions)

            document.getElementById('conflicts-input').value =
                JSON.stringify(this.conflicts)

            form.submit()
        }
    }"
    x-show="showModal"
    x-cloak
    class="fixed inset-0 z-50 bg-black/50 overflow-y-auto"
>
    <div class="min-h-screen flex items-center justify-center p-6">

        <!-- CARD -->
        <div
            x-show="showModal"
            x-transition
            class="bg-white rounded-xl shadow-2xl w-full max-w-6xl overflow-hidden"
        >

            <!-- HEADER -->
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Conflict Resolution
                    </h2>
                    <p class="text-sm text-gray-400">
                        Review imported layup conflicts
                    </p>
                </div>

                <button
                    @click="showModal = false"
                    class="text-xl text-gray-400 hover:text-gray-700"
                >
                    ×
                </button>
            </div>

            <div class="flex">

                <!-- SIDEBAR -->
                <div class="w-80 border-r bg-gray-50 p-4">

                    <h3 class="font-semibold text-sm text-gray-700 mb-4">
                        Conflicting Layups (<span x-text="total"></span>)
                    </h3>

                    <template x-for="(conflict,index) in conflicts" :key="index">
                        <div
                            @click="currentConflictIndex = index"
                            class="p-3 mb-2 rounded-lg border cursor-pointer transition"
                            :class="currentConflictIndex === index
                                ? 'border-green-500 bg-green-50'
                                : 'border-gray-200 bg-white'"
                        >
                            <div class="flex justify-between gap-2">
                                <div>
                                    <p class="font-medium text-sm text-gray-800"
                                       x-text="conflict.layup_name">
                                    </p>

                                    <p class="text-xs text-gray-500"
                                       x-text="getConflictDescription(conflict)">
                                    </p>
                                </div>

                                <div>
                                    <span
                                        x-show="resolutions[index]"
                                        class="text-green-600"
                                    >✔</span>

                                    <span
                                        x-show="!resolutions[index]"
                                        class="text-red-500"
                                    >●</span>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>

                <!-- CONTENT -->
                <div class="flex-1 p-6" x-show="currentConflict">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800"
                            x-text="currentConflict.layup_name">
                        </h3>

                        <p class="text-sm text-gray-400">
                            Compare current data vs imported data
                        </p>
                    </div>

                    <!-- TABLE -->
                    <div class="grid grid-cols-2 gap-6">

                        <!-- EXISTING -->
                        <div>
                            <h4 class="font-semibold text-sm mb-3 text-gray-700">
                                Existing
                            </h4>

                            <table class="w-full text-sm border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-left">Thickness</th>
                                        <th class="p-2 text-left">Width</th>
                                        <th class="p-2 text-left">Angle</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="p-2"
                                            x-text="currentConflict.existing.thickness"></td>
                                        <td class="p-2"
                                            x-text="currentConflict.existing.width"></td>
                                        <td class="p-2"
                                            x-text="currentConflict.existing.angle"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- IMPORTED -->
                        <div>
                            <h4 class="font-semibold text-sm mb-3 text-gray-700">
                                Imported
                            </h4>

                            <table class="w-full text-sm border rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-left">Thickness</th>
                                        <th class="p-2 text-left">Width</th>
                                        <th class="p-2 text-left">Angle</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="p-2 bg-red-50"
                                            x-text="currentConflict.imported.thickness"></td>
                                        <td class="p-2 bg-red-50"
                                            x-text="currentConflict.imported.width"></td>
                                        <td class="p-2 bg-red-50"
                                            x-text="currentConflict.imported.angle"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="mt-8 flex justify-center gap-4">

                        <button
                            @click="resolveConflict('keep')"
                            class="px-5 py-2 border rounded-lg hover:bg-gray-100"
                        >
                            Keep Existing
                        </button>

                        <button
                            @click="resolveConflict('accept')"
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                        >
                            Accept Imported
                        </button>

                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t px-6 py-4 flex justify-between items-center bg-gray-50">

                <button
                    @click="previousConflict"
                    class="px-4 py-2 border rounded"
                >
                    Prev
                </button>

                <span class="text-sm text-gray-600">
                    <span x-text="currentConflictIndex + 1"></span>
                    /
                    <span x-text="total"></span>
                </span>

                <button
                    @click="nextConflict"
                    class="px-4 py-2 border rounded"
                >
                    Next
                </button>

            </div>

        </div>

    </div>

    <!-- FORM SUBMIT -->
    <form
    id="resolve-form"
    method="POST"
    action="{{ route('suppliers.resolve-conflicts', $supplier) }}"
    class="hidden"
    >
        @csrf

        <input type="hidden" name="resolutions" id="resolutions-input">
        <input type="hidden" name="conflicts" id="conflicts-input">

    </form>
</div>
