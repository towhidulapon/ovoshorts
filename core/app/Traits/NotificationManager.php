<?php

namespace App\Traits;

use App\Services\NotificationService;
use Illuminate\Http\Request;

trait NotificationManager {
    public function index() {
        $user          = auth()->user();
        $notifications = NotificationService::getNotifications($user);

        $pageTitle = 'Notifications';
        $view = 'Template::user.privacy_setting';

        return responseManager("notifications", 'notifications', 'success', [
            'pageTitle' => $pageTitle,
            'view'      => $view,
            'user'      => $user,
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

    public function getSettings() {
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

    public function saveSettings(Request $request) {
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
        if($request->has('show_activity_status')) {
            $user->show_activity_status = $request->show_activity_status;
        }

        $user->save();

        return apiResponse("notification_settings", "success", ["Settings updated successfully"], [
            'settings' => [
                'notify_likes'         => $user->notify_likes,
                'notify_comments'      => $user->notify_comments,
                'notify_followers'     => $user->notify_followers,
                'notify_stars'         => $user->notify_stars,
                'show_activity_status' => $user->show_activity_status,
            ],

        ]);
    }
}
