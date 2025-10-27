<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Traits\MessageManager;

class MessageController extends Controller
{
    use MessageManager;
}
