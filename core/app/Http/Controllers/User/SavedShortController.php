<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SavedShort;
use App\Traits\SavedShortsManager;
use Illuminate\Http\Request;

class SavedShortController extends Controller
{
    use SavedShortsManager;
}
