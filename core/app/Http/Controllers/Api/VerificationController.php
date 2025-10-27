<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\VerificationManager;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerificationManager;
}
