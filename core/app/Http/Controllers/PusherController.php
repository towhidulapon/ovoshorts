<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PusherController extends Controller
{

    public function authentication($socketId, $channelName)
    {
        if (strpos($channelName, 'private-user-online-status.') === 0) {
            $userId = substr($channelName, strlen('private-user-online-status.'));

            if (Auth::check()) {
                $pusherSecret = config('app.PUSHER_APP_SECRET');
                $str          = $socketId . ":" . $channelName;
                $hash         = hash_hmac('sha256', $str, $pusherSecret);
                return response()->json([
                    'auth' => config('app.PUSHER_APP_KEY') . ":" . $hash,
                ]);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        if (strpos($channelName, 'private-receive-message-') === 0) {
            $parts = explode('-', $channelName);
            if (count($parts) >= 4) {
                $userId1 = $parts[3];
                $userId2 = $parts[4];

                if (Auth::check() && (Auth::id() == $userId1 || Auth::id() == $userId2)) {
                    $pusherSecret = config('app.PUSHER_APP_SECRET');
                    $str          = $socketId . ":" . $channelName;
                    $hash         = hash_hmac('sha256', $str, $pusherSecret);
                    return response()->json([
                        'auth' => config('app.PUSHER_APP_KEY') . ":" . $hash,
                    ]);
                }
            }
        }

        $pusherSecret = config('app.PUSHER_APP_SECRET');
        $str          = $socketId . ":" . $channelName;
        $hash         = hash_hmac('sha256', $str, $pusherSecret);
        return response()->json([
            'success' => true,
            'message' => "Pusher authentication successfully",
            'auth'    => config('app.PUSHER_APP_KEY') . ":" . $hash,
        ]);
    }

    public function authenticationApp(Request $request)
    {
        $socketId    = $request->socket_id;
        $channelName = $request->channel_name;

        if (strpos($channelName, 'private-user-online-status.') === 0) {
            $userId = substr($channelName, strlen('private-user-online-status.'));

            if (Auth::check()) {
                $pusherSecret = config('app.PUSHER_APP_SECRET');
                $str          = $socketId . ":" . $channelName;
                $hash         = hash_hmac('sha256', $str, $pusherSecret);
                return response()->json([
                    'auth' => config('app.PUSHER_APP_KEY') . ":" . $hash,
                ]);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        if (strpos($channelName, 'private-receive-message-') === 0) {
            $parts = explode('-', $channelName);
            if (count($parts) >= 4) {
                $userId1 = $parts[3];
                $userId2 = $parts[4];

                if (Auth::check() && (Auth::id() == $userId1 || Auth::id() == $userId2)) {
                    $pusherSecret = config('app.PUSHER_APP_SECRET');
                    $str          = $socketId . ":" . $channelName;
                    $hash         = hash_hmac('sha256', $str, $pusherSecret);
                    return response()->json([
                        'auth' => config('app.PUSHER_APP_KEY') . ":" . $hash,
                    ]);
                }
            }
        }

        $pusherSecret = config('app.PUSHER_APP_SECRET');
        $str          = $socketId . ":" . $channelName;
        $hash         = hash_hmac('sha256', $str, $pusherSecret);
        return response()->json([
            'success' => true,
            'message' => "Pusher authentication successfully",
            'auth'    => config('app.PUSHER_APP_KEY') . ":" . $hash,
        ]);
    }
}
