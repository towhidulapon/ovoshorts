<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\StarTransactionManager;
use Illuminate\Http\Request;

class StarTransactionController extends Controller
{
    use StarTransactionManager;
}
