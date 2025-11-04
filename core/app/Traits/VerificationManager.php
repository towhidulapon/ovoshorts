<?php
namespace App\Traits;

use App\Constants\Status;
use App\Http\Controllers\Api\PaymentController as ApiPaymentController;
use App\Http\Controllers\Gateway\PaymentController;
use App\Lib\FormProcessor;
use App\Models\Form;
use App\Models\GatewayCurrency;
use App\Models\Transaction;
use Illuminate\Http\Request;

trait VerificationManager
{
    public function index()
    {
        if (auth()->user()->is_verified == Status::VERIFICATION_PENDING) {
            $notify[] = ['error', 'Your Verification is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->is_verified == Status::VERIFICATION_SUCCESS) {
            $notify[] = ['error', 'You are already verified'];
            return to_route('user.home')->withNotify($notify);
        }

        $pageTitle = "Verification";
        $user      = auth()->user();

        $view = 'Template::user.verification.index';

        return responseManager('verification page', $pageTitle, 'success', [
            'pageTitle' => $pageTitle,
            'user'      => $user,
            'view'      => $view,
        ]);

    }

    public function verificationData()
    {
        $user      = auth()->user();
        $pageTitle = 'Verification Data';
        abort_if($user->is_verified == Status::VERIFICATION_SUCCESS, 403);
        return view('Template::user.verification.info', compact('pageTitle', 'user'));
    }

    public function applyVerification(Request $request)
    {
        $form           = Form::where('act', 'verification')->firstOrFail();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $user = auth()->user();
        foreach (@$user->verification_data ?? [] as $verificationData) {
            if ($verificationData->type == 'file') {
                fileManager()->removeFile(getFilePath('verification') . '/' . $verificationData->value);
            }
        }
        $userData                            = $formProcessor->processFormData($request, $formData);
        $user->verification_data             = $userData;
        $user->verification_rejection_reason = null;
        $user->is_verified                   = Status::VERIFICATION_PENDING;
        $user->verification_type             = Status::FREE;
        $user->save();

        $message  = 'Verification data submitted successfully';
        $redirect = 'user.home';

        return responseManager('verification data', $message, 'success', [
            'redirect' => $redirect,
            'formData' => $formData,
        ]);

    }

    public function purchaseVerification(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);
        $pageTitle       = 'Verification Payment';
        $amount          = $request->amount;
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();

        return view('Template::user.verification.payment', compact('pageTitle', 'gatewayCurrency', 'amount'));
    }

    public function storePaymentInfo(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|gt:0',
            'gateway'  => 'required',
            'currency' => 'required',
        ]);

        $user = auth()->user();

        $user->is_verified = Status::PAYMENT_INITIATE;
        $user->save();

        if ($request->gateway != 'main-balance') {

            $gate = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', Status::ENABLE);
            })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();

            if (!$gate) {
                $message = 'Invalid gateway';
                return responseManager('invalid_gateway', $message);
            }
            if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
                $message = 'Please follow deposit limit';
                return responseManager('deposit_limit', $message);
            }

            if (isApiRequest()) {
                $data = (new ApiPaymentController())->insertDepositData($gate, $request->amount, null, true);
                $notify[] = 'Deposit inserted';
                return apiResponse("deposit_inserted", "success", $notify, [
                    'deposit'      => $data,
                    'redirect_url' => route('deposit.app.confirm', encrypt($data->id)),
                ]);
            } else {
                $data = (new PaymentController())->insertDepositData($gate, $request->amount, null, true);
            }

            return to_route('user.deposit.confirm');
        }

        if ($request->amount > $user->balance) {
            $message = 'Insufficient Balance';
            return responseManager('insufficient_balance', $message);
        }

        $this->confirmPurchase($user, $request->amount);

        $message  = 'Verification payment successfully done';
        $redirect = 'user.transactions';
        return responseManager('verification payment', $message, 'success', [
            'redirect' => $redirect,
        ]);

    }
    public function confirmPurchase($user, $amount)
    {
        $user->is_verified       = Status::VERIFICATION_SUCCESS;
        $user->verification_type = Status::PAID;
        $user->save();

        $user->balance -= $amount;
        $user->save();

        $userTransaction               = new Transaction();
        $userTransaction->user_id      = $user->id;
        $userTransaction->amount       = $amount;
        $userTransaction->post_balance = $user->balance;
        $userTransaction->trx_type     = '-';
        $userTransaction->details      = 'Verification Payment';
        $userTransaction->trx          = getTrx();
        $userTransaction->remark       = 'verification_payment';
        $userTransaction->save();

        notify($user, 'VERIFICATION_PAYMENT_SUCCESS', [
            'amount'         => showAmount($amount),
            'transaction_id' => $userTransaction->trx,
            'date'           => showDateTime($userTransaction->created_at),
            'post_balance'   => showAmount($user->balance),
        ]);

    }
}
