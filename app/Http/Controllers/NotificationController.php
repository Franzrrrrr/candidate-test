<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);

        return view('pages.notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        // Mark as read if not already read
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('pages.notifications.show', compact('notification'));
    }

    public function unread(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->unreadNotifications()
            ->limit(10)
            ->get();

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at->toISOString(),
                    'data' => $notification->data,
                ];
            })
        ]);
    }

    public function markAsRead(Notification $notification): JsonResponse
    {
        $notification->markAsRead();

        // Determine redirect based on notification type
        $redirectUrl = match($notification->type) {
            'import_rejected' => route('notifications.import-rejected', $notification),
            'conflict_detected' => route('notifications.conflict-details', $notification),
            default => route('notifications.show', $notification),
        };

        return response()->json([
            'success' => true,
            'redirect' => $redirectUrl
        ]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()
            ->unreadNotifications()
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function importRejected(Notification $notification)
    {
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('pages.notifications.import-rejected', compact('notification'));
    }

    public function conflictDetails(Notification $notification)
    {
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('pages.notifications.conflict-details', compact('notification'));
    }
}
