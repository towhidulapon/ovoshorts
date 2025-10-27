<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use App\Lib\FormProcessor;
use App\Models\Form;
use App\Models\GatewayCurrency;
use App\Models\Transaction;
use App\Traits\VerificationManager;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerificationManager;
}
