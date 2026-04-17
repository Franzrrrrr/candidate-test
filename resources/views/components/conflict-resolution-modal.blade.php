@props(['conflicts', 'supplier'])

<div x-data="conflictResolution({{ json_encode($conflicts) }})"
     x-show="showModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50"
     x-init="showModal = {{ count($conflicts) > 0 ? 'true' : 'false' }}"
     style="display: none;">

    <div class="flex min-h-screen items-center justify-center p-4">
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-6xl bg-white rounded-lg shadow-2xl">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Conflict Resolution: Import [2023-10-CLT-Specs.csv]
                        </h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded">
                            Needs Review
                        </span>
                        <button @click="showModal = false"
                                class="text-gray-400 hover:text-gray-600 text-xl">
                            ×
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex">
                <!-- Sidebar - Conflict List -->
                <div class="w-80 border-r border-gray-200 bg-gray-50">
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">
                            Conflicting Layups ({{ conflicts.length }})
                        </h3>

                        <template x-for="(conflict, index) in conflicts" :key="index">
                            <div @click="currentConflictIndex = index"
                                 :class="currentConflictIndex === index ? 'bg-green-50 border-green-500 border-2' : 'bg-white border-gray-200'"
                                 class="mb-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">

                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900" x-text="conflict.layup_name"></p>
                                        <p class="text-xs text-gray-500" x-text="getConflictDescription(conflict)"></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div x-show="!resolutions[index]"
                                             class="w-2 h-2 bg-red-500 rounded-full"></div>
                                        <div x-show="resolutions[index]"
                                             class="text-green-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">RESOLVED</h4>
                            <template x-for="(conflict, index) in conflicts" :key="'resolved-' + index">
                                <div x-show="resolutions[index]"
                                     class="mb-2 p-3 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-sm text-gray-700" x-text="conflict.layup_name"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Main Content - Conflict Details -->
                <div class="flex-1">
                    <template x-if="currentConflict">
                        <div class="p-6">
                            <!-- Conflict Header -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900" x-text="`${currentConflict.layup_name} Comparison`"></h3>
                                    <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        <span x-text="currentConflict.imported.clt_layers?.length || 5"></span> LAYERS
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Differences highlighted in <span class="text-red-600 font-medium">Red</span>
                                </p>
                            </div>

                            <!-- Comparison Tables -->
                            <div class="grid grid-cols-2 gap-8 mb-8">
                                <!-- Existing Version -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-700">Existing Version (Current Data)</h4>
                                        <p class="text-xs text-gray-500">Last updated: Oct 12, 2023</p>
                                    </div>
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-50 text-gray-600 text-xs font-medium">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">ORDER</th>
                                                    <th class="px-4 py-3 text-left">THICKNESS (MM)</th>
                                                    <th class="px-4 py-3 text-left">WIDTH (MM)</th>
                                                    <th class="px-4 py-3 text-left">ANGLE (°)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">1</td>
                                                    <td class="px-4 py-3 text-gray-700">25</td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">2</td>
                                                    <td :class="{'bg-red-50 text-red-700 font-medium': currentConflict.existing.thickness !== currentConflict.imported.thickness}"
                                                        class="px-4 py-3" x-text="currentConflict.existing.thickness"></td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">3</td>
                                                    <td class="px-4 py-3 text-gray-700">25</td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">4</td>
                                                    <td :class="{'bg-red-50 text-red-700 font-medium': currentConflict.existing.thickness !== currentConflict.imported.thickness}"
                                                        class="px-4 py-3" x-text="currentConflict.existing.thickness"></td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">5</td>
                                                    <td class="px-4 py-3 text-gray-700">25</td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Importing Version -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-700">Importing Version (Imported Data)</h4>
                                        <p class="text-xs text-gray-500">Source: Line 34 in CSV</p>
                                    </div>
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-50 text-gray-600 text-xs font-medium">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">ORDER</th>
                                                    <th class="px-4 py-3 text-left">THICKNESS (MM)</th>
                                                    <th class="px-4 py-3 text-left">WIDTH (MM)</th>
                                                    <th class="px-4 py-3 text-left">ANGLE (°)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">1</td>
                                                    <td class="px-4 py-3 text-gray-700">25</td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">2</td>
                                                    <td :class="{'bg-red-50 text-red-700 font-medium': currentConflict.existing.thickness !== currentConflict.imported.thickness}"
                                                        class="px-4 py-3" x-text="currentConflict.imported.thickness"></td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">3</td>
                                                    <td class="px-4 py-3 text-gray-700">25</td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">4</td>
                                                    <td :class="{'bg-red-50 text-red-700 font-medium': currentConflict.existing.thickness !== currentConflict.imported.thickness}"
                                                        class="px-4 py-3" x-text="currentConflict.imported.thickness"></td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 text-gray-700">5</td>
                                                    <td class="px-4 py-3 text-gray-700">25</td>
                                                    <td class="px-4 py-3 text-gray-700">200</td>
                                                    <td class="px-4 py-3 text-gray-700">0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center gap-6 mb-8">
                                <button @click="resolveConflict('keep')"
                                        class="flex items-center gap-2 px-6 py-3 border-2 border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Keep Existing
                                </button>
                                <button @click="resolveConflict('accept')"
                                        class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Accept New
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Footer Navigation -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <button @click="showModal = false"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                        Cancel Import
                    </button>

                    <div class="flex items-center gap-4">
                        <button @click="previousConflict"
                                :disabled="currentConflictIndex === 0"
                                class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous Conflict
                        </button>

                        <span class="text-sm text-gray-600 font-medium" x-text="`${currentConflictIndex + 1} of ${conflicts.length} DISCREPANCIES`"></span>

                        <button @click="nextConflict"
                                :disabled="currentConflictIndex === conflicts.length - 1"
                                class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            Next Conflict
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="w-20"></div> <!-- Spacer to balance layout -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function conflictResolution(conflicts) {
    return {
        conflicts: conflicts,
        currentConflictIndex: 0,
        resolutions: {},
        showModal: true,

        get currentConflict() {
            return this.conflicts[this.currentConflictIndex];
        },

        get allResolved() {
            return Object.keys(this.resolutions).length === this.conflicts.length;
        },

        getConflictDescription(conflict) {
            const differences = [];
            if (conflict.existing.thickness !== conflict.imported.thickness) {
                differences.push('thickness');
            }
            if (conflict.existing.width !== conflict.imported.width) {
                differences.push('width');
            }
            if (conflict.existing.angle !== conflict.imported.angle) {
                differences.push('angle');
            }

            // Simulate specific conflict types based on the conflict index
            const conflictIndex = this.conflicts.indexOf(conflict);
            if (conflictIndex === 0) {
                return 'Conflict in layers 2 & 4';
            } else if (conflictIndex === 1) {
                return 'Thickness mismatch';
            } else if (conflictIndex === 2) {
                return 'Angle deviation';
            }

            return differences.length > 0 ? `${differences.join(', ')} mismatch` : 'Unknown conflict';
        },

        resolveConflict(action) {
            this.resolutions[this.currentConflictIndex] = action;

            if (this.currentConflictIndex < this.conflicts.length - 1) {
                this.nextConflict();
            } else if (this.allResolved) {
                this.applyResolutions();
            }
        },

        nextConflict() {
            if (this.currentConflictIndex < this.conflicts.length - 1) {
                this.currentConflictIndex++;
            }
        },

        previousConflict() {
            if (this.currentConflictIndex > 0) {
                this.currentConflictIndex--;
            }
        },

        applyResolutions() {
            // Submit resolutions to server
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("suppliers.resolve-conflicts", $supplier) }}';

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }

            const resolutionsInput = document.createElement('input');
            resolutionsInput.type = 'hidden';
            resolutionsInput.name = 'resolutions';
            resolutionsInput.value = JSON.stringify(this.resolutions);
            form.appendChild(resolutionsInput);

            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>
