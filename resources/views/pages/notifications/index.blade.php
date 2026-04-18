<x-app-layout>
    <!-- HEADER -->
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Notifications
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Stay updated with the latest system notifications
                </p>
            </div>
            <button onclick="markAllAsRead()" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                Mark All as Read
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="flex border-b border-gray-200">
                <button onclick="filterNotifications('all')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 border-blue-500 text-blue-600">
                    All Notifications
                </button>
                <button onclick="filterNotifications('unread')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    Unread
                </button>
                <button onclick="filterNotifications('import_rejected')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    Import Rejected
                </button>
                <button onclick="filterNotifications('conflict_detected')" 
                        class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    Conflicts
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow {{ !$notification->is_read ? 'border-l-4 border-l-blue-500' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <!-- Icon based on type -->
                                @switch($notification->type)
                                    @case('import_rejected')
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        @break
                                    @case('conflict_detected')
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        @break
                                    @default
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        @break
                                @endswitch

                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $notification->title }}
                                    </h3>
                                    @if(!$notification->is_read)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded mt-1">
                                            New
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-gray-600 mb-3">
                                {{ $notification->message }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    {{ $notification->created_at->format('M d, Y H:i') }}
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    @if($notification->type === 'import_rejected')
                                        <a href="{{ route('notifications.import-rejected', $notification) }}" 
                                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            View Details
                                        </a>
                                    @elseif($notification->type === 'conflict_detected')
                                        <a href="{{ route('notifications.conflict-details', $notification) }}" 
                                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            View Conflicts
                                        </a>
                                    @else
                                        <a href="{{ route('notifications.show', $notification) }}" 
                                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            View
                                        </a>
                                    @endif
                                    
                                    @if(!$notification->is_read)
                                        <button onclick="markAsRead({{ $notification->id }})" 
                                                class="text-sm text-gray-500 hover:text-gray-700">
                                            Mark as read
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                    <p class="text-gray-500">You're all caught up! No new notifications to show.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <script>
        function markAllAsRead() {
            fetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function filterNotifications(type) {
            const url = new URL(window.location);
            if (type === 'all') {
                url.searchParams.delete('type');
            } else {
                url.searchParams.set('type', type);
            }
            window.location.href = url.toString();
        }
    </script>
</x-app-layout>
