<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\GatewayCurrency;
use App\Models\Star;
use App\Models\StarPurchase;
use App\Models\Transaction;
use App\Traits\StarManager;
use Illuminate\Http\Request;

class StarController extends Controller
{
    use StarManager;
}
