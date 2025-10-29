<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\FriendsManager;

class FriendsController extends Controller
{
    use FriendsManager;

    public function sidebarFollowingUsers()
    {
        $followings = auth()->user()->followings()->get();
        return view('Template::partials.sidebar_followings', compact('followings'));
    }
}
