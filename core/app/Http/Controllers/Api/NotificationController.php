<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user          = auth()->user();
        $notifications = NotificationService::getNotifications($user);

        return apiResponse("notifications", "success", ["Notifications retrieved"], [
            'notifications' => $notifications,
            'settings'      => [
                'notify_likes'     => $user->notify_likes,
                'notify_comments'  => $user->notify_comments,
                'notify_followers' => $user->notify_followers,
                'notify_stars'     => $user->notify_stars,
            ],
            'imagePath'     => getFilePath('userProfile'),
            'coverImage'    => getFilePath('coverImage'),
        ]);
    }

    public function getSettings()
    {
        $user = auth()->user();

        return apiResponse("notification_settings", "success", ["Notification settings retrieved"], [
            'settings' => [
                'notify_likes'         => $user->notify_likes,
                'notify_comments'      => $user->notify_comments,
                'notify_followers'     => $user->notify_followers,
                'notify_stars'         => $user->notify_stars,
            ],
        ]);
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'notify_likes'         => 'nullable',
            'notify_comments'      => 'nullable',
            'notify_followers'     => 'nullable',
            'notify_stars'         => 'nullable',
        ]);

        $user = auth()->user();

        if ($request->has('notify_likes')) {
            $user->notify_likes = $request->notify_likes;
        }
        if ($request->has('notify_comments')) {
            $user->notify_comments = $request->notify_comments;
        }
        if ($request->has('notify_followers')) {
            $user->notify_followers = $request->notify_followers;
        }
        if ($request->has('notify_stars')) {
            $user->notify_stars = $request->notify_stars;
        }

        $user->save();

        return apiResponse("notification_settings", "success", ["Notification settings updated"], [
            'settings' => [
                'notify_likes'         => $user->notify_likes,
                'notify_comments'      => $user->notify_comments,
                'notify_followers'     => $user->notify_followers,
                'notify_stars'         => $user->notify_stars,
            ],
        ]);
    }
}
