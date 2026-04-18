<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Profile Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your account settings and preferences</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-gray-600">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-gray-400 mt-2">Head Engineer</p>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">
                                    {{ \App\Models\Supplier::count() }}
                                </div>
                                <div class="text-xs text-gray-500">Suppliers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ auth()->user()->unreadNotifications()->count() }}
                                </div>
                                <div class="text-xs text-gray-500">Unread</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4">Quick Actions</h4>
                    <div class="space-y-2">
                        <a href="{{ route('notifications.index') }}"
                           class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                            View Notifications
                        </a>
                        <a href="{{ route('suppliers') }}"
                           class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                            Manage Suppliers
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Settings Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Profile Information</h2>
                        <p class="text-sm text-gray-500 mt-1">Update your personal information</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Password</h2>
                        <p class="text-sm text-gray-500 mt-1">Change your password</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white rounded-lg shadow-sm border border-red-200">
                    <div class="px-6 py-4 border-b border-red-200">
                        <h2 class="text-lg font-semibold text-red-800">Delete Account</h2>
                        <p class="text-sm text-red-600 mt-1">Permanently delete your account</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
