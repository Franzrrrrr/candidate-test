@props(['unreadCount' => 0])

<div x-data="{ isOpen: false }" class="relative">
    <!-- Notification Button -->
    <button @click="isOpen = !isOpen"
            class="relative p-2 text-gray-600 hover:text-gray-800 transition-colors">
        <!-- Bell Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>

        <!-- Badge -->
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="isOpen = false"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
         style="display: none;">

        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                <button class="text-xs text-blue-600 hover:text-blue-800">Mark all as read</button>
            </div>
        </div>

        <!-- Notification List -->
        <div class="max-h-96 overflow-y-auto">
            <!-- Notifications will be loaded here -->
            <div id="notification-list">
                <!-- Loading state -->
                <div class="p-4 text-center text-gray-500 text-sm">
                    Loading notifications...
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200">
            <a href="{{ route('notifications.index') }}"
               class="text-sm text-blue-600 hover:text-blue-800 block text-center">
                View all notifications
            </a>
        </div>
    </div>
</div>

<script>
// Load notifications via AJAX
document.addEventListener('DOMContentLoaded', function() {
    const notificationButton = document.querySelector('[x-data*="isOpen"]');
    if (notificationButton) {
        notificationButton.addEventListener('click', function() {
            loadNotifications();
        });
    }
});

function loadNotifications() {
    fetch('/notifications/unread')
        .then(response => response.json())
        .then(data => {
            const listContainer = document.getElementById('notification-list');
            if (data.notifications && data.notifications.length > 0) {
                console.log('Notifications loaded:', data.notifications);
                listContainer.innerHTML = data.notifications.map(notification => `
                    <div class="notification-item px-4 py-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer ${!notification.is_read ? 'bg-blue-50' : ''}"
                         onclick="viewNotification(${notification.id})">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-2 h-2 mt-2 ${!notification.is_read ? 'bg-blue-600' : 'bg-transparent'} rounded-full"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">${notification.title}</p>
                                <p class="text-xs text-gray-500 mt-1">${notification.message}</p>
                                <p class="text-xs text-gray-400 mt-1">${formatTime(notification.created_at)}</p>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                listContainer.innerHTML = `
                    <div class="p-4 text-center text-gray-500 text-sm">
                        No notifications
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
}

function viewNotification(id) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }

        return response.json();
    })
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    })
    .catch(error => console.error(error));
}

function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;

    if (diff < 60000) return 'Just now';
    if (diff < 3600000) return Math.floor(diff / 60000) + ' min ago';
    if (diff < 86400000) return Math.floor(diff / 3600000) + ' hours ago';
    return date.toLocaleDateString();
}
</script>
