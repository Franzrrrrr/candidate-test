<x-app-layout>
    <!-- HEADER -->
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Conflict Details
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Review detected conflicts in your import data
                </p>
            </div>
            <a href="{{ route('notifications.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                &larr; Back to Notifications
            </a>
        </div>

        <!-- Alert Card -->
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-orange-800 mb-2">
                        {{ $notification->title }}
                    </h3>
                    <p class="text-orange-700 mb-4">
                        {{ $notification->message }}
                    </p>
                    <div class="text-sm text-orange-600">
                        <p><strong>Time:</strong> {{ $notification->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Supplier:</strong> {{ $notification->data['supplier_name'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conflict Resolution Options -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Resolution Options</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('suppliers.show', $notification->data['supplier_id']) }}?import_retry=true" 
                   class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-800">Retry Import</h3>
                    <p class="text-sm text-gray-500 mt-1">Choose a different resolution strategy</p>
                </a>
                
                <a href="{{ route('suppliers.show', $notification->data['supplier_id']) }}" 
                   class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-800">View Supplier</h3>
                    <p class="text-sm text-gray-500 mt-1">Go to supplier page to manage layups</p>
                </a>
            </div>
        </div>

        <!-- Detailed Conflicts -->
        @if(isset($notification->data['conflicts']) && count($notification->data['conflicts']) > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Detected Conflicts</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($notification->data['conflicts'] as $index => $conflict)
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-md font-semibold text-gray-800">
                                    {{ $conflict['layup_name'] ?? 'Unknown Layup' }}
                                </h3>
                                <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded">
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
    </div>
</x-app-layout>
