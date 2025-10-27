<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Short;
use App\Models\User;
use App\Traits\FriendsManager;

class FriendsController extends Controller
{
    use FriendsManager;
}
