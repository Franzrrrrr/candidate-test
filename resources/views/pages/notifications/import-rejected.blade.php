<x-app-layout>
    <!-- HEADER -->
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Import Rejected - Details
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Review the conflicts that caused this import to be rejected
                </p>
            </div>
            <a href="{{ route('notifications.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                &larr; Back to Notifications
            </a>
        </div>

        <!-- Alert Card -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">
                        {{ $notification->title }}
                    </h3>
                    <p class="text-red-700 mb-4">
                        {{ $notification->message }}
                    </p>
                    <div class="text-sm text-red-600">
                        <p><strong>Time:</strong> {{ $notification->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Supplier:</strong> {{ $notification->data['supplier_name'] ?? 'N/A' }}</p>
                        <p><strong>File:</strong> {{ $notification->data['filename'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conflict Summary -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Conflict Summary</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600">
                        {{ count($notification->data['conflicts'] ?? []) }}
                    </div>
                    <div class="text-sm text-gray-500">Total Conflicts</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">
                        {{ count($notification->data['conflicting_layups'] ?? []) }}
                    </div>
                    <div class="text-sm text-gray-500">Affected Layups</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $notification->data['total_layers'] ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-500">Total Layers</div>
                </div>
            </div>
        </div>

        <!-- Detailed Conflicts -->
        @if(isset($notification->data['conflicts']) && count($notification->data['conflicts']) > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Detailed Conflicts</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($notification->data['conflicts'] as $index => $conflict)
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-md font-semibold text-gray-800">
                                    {{ $conflict['layup_name'] ?? 'Unknown Layup' }}
                                </h3>
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded">
                                    Conflict #{{ $index + 1 }}
                                </span>
                            </div>

                            <!-- Conflict Details -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-3">
                                    <strong>Layer Order:</strong> {{ $conflict['layer_order'] ?? 'N/A' }}
                                </p>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Existing Version -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Existing Version</h4>
                                        <div class="bg-white border border-gray-200 rounded p-3 text-sm">
                                            <p><strong>Thickness:</strong> {{ $conflict['existing']['thickness'] ?? 'N/A' }}mm</p>
                                            <p><strong>Width:</strong> {{ $conflict['existing']['width'] ?? 'N/A' }}mm</p>
                                            <p><strong>Angle:</strong> {{ $conflict['existing']['angle'] ?? 'N/A' }}°</p>
                                        </div>
                                    </div>

                                    <!-- Incoming Version -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Incoming Version</h4>
                                        <div class="bg-white border border-gray-200 rounded p-3 text-sm">
                                            <p><strong>Thickness:</strong> {{ $conflict['imported']['thickness'] ?? 'N/A' }}mm</p>
                                            <p><strong>Width:</strong> {{ $conflict['imported']['width'] ?? 'N/A' }}mm</p>
                                            <p><strong>Angle:</strong> {{ $conflict['imported']['angle'] ?? 'N/A' }}°</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Difference Highlight -->
                                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded text-sm">
                                    <p class="text-yellow-800">
                                        <strong>Differences detected:</strong> 
                                        @php
                                            $differences = [];
                                            if (isset($conflict['existing']['thickness']) && isset($conflict['imported']['thickness']) && $conflict['existing']['thickness'] != $conflict['imported']['thickness']) {
                                                $differences[] = 'thickness';
                                            }
                                            if (isset($conflict['existing']['width']) && isset($conflict['imported']['width']) && $conflict['existing']['width'] != $conflict['imported']['width']) {
                                                $differences[] = 'width';
                                            }
                                            if (isset($conflict['existing']['angle']) && isset($conflict['imported']['angle']) && $conflict['existing']['angle'] != $conflict['imported']['angle']) {
                                                $differences[] = 'angle';
                                            }
                                        @endphp
                                        {{ implode(', ', $differences) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recommended Actions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-3">Recommended Actions</h3>
            <ul class="space-y-2 text-blue-700">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9.5H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Review the conflicting data and decide which version to keep</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9.5H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Use manual conflict resolution to handle each conflict individually</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9.5H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Consider creating a duplicate layup if you want to preserve both versions</span>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
