<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\SavedShortsManager;
use Illuminate\Http\Request;

class SavedShortController extends Controller
{
    use SavedShortsManager;

}
