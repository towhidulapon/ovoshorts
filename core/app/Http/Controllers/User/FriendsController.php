<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\FriendsManager;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    use FriendsManager;

    // public function sidebarFollowingUsers()
    // {
    //     $followings = auth()->user()->followings()->paginate(getPaginate(5));
    //     return view('Template::partials.sidebar_followings', compact('followings'));
    // }

    public function loadFollowingUsers(Request $request)
    {
        // $page = $request->input('page', 1);

        $followings = auth()->user()->followings()->paginate(getPaginate(5));

        $html = view('Template::partials.sidebar_following_items', [
            'followings' => $followings,
        ])->render();

        return response()->json([
            'html'    => $html,
            'hasMore' => $followings->hasMorePages(),
        ]);
    }

}
