<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\StarTransactionManager;
use Illuminate\Http\Request;

class StarTransactionController extends Controller
{
    use StarTransactionManager;
}
