<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\CommentManager;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use CommentManager;
}
