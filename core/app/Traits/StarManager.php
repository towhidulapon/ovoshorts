<?php
namespace App\Traits;

use App\Constants\Status;
use App\Http\Controllers\Api\PaymentController as ApiPaymentController;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\GatewayCurrency;
use App\Models\Star;
use App\Models\StarPurchase;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

trait StarManager
{
    public function getStars(Request $request)
    {
        $pageTitle           = 'Stars';

        $token = $request->bearerToken();

        $user = null;


        if ($token) {
            $personalToken = PersonalAccessToken::findToken($token);
            if ($personalToken && $personalToken->tokenable instanceof User) {
                $user = $personalToken->tokenable;
            }
        }else {
            $user = auth()->user();
        }

        $stars               = Star::active()->orderBy('price', 'asc')->get();
        $link                = route('home', ['reference' => $user->username ?? '']);
        $totalReferral       = $user ? User::where('ref_by', $user->id)->count() : 0;
        $totalReferralAmount = $user ? Transaction::where('user_id', $user->id)->where('remark', 'referral_commission')->sum('amount') : 0;

        $view = 'Template::stars';

        return responseManager('Star recharge', $pageTitle, 'success', [
            'view'                => $view,
            'user'                => $user,
            'balance'             => $user?->balance,
            'stars'               => $stars,
            'link'                => $link,
            'totalReferral'       => $totalReferral,
            'totalReferralAmount' => $totalReferralAmount,
            'pageTitle'           => $pageTitle,
        ]);

    }
    public function rechargeIndex(Request $request)
    {
        $pageTitle       = 'Star Recharge';
        $starId          = $request->star_id;
        $star            = Star::findOrFail($starId);
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('name')->get();

        $view = 'Template::user.star.recharge';

        return responseManager('Star recharge', $pageTitle, 'success', [
            'view'            => $view,
            'star'            => $star,
            'gatewayCurrency' => $gatewayCurrency,
            'pageTitle'       => $pageTitle,
        ]);

    }

    public function storePaymentInfo(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|gt:0',
            'gateway'  => 'required',
            'currency' => 'required',
        ]);

        $user = auth()->user();

        $starPurchase          = new StarPurchase();
        $starPurchase->user_id = $user->id;
        $starPurchase->star_id = $request->star_id;
        $starPurchase->status  = Status::PAYMENT_INITIATE;
        $starPurchase->save();

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
                $data = (new ApiPaymentController())->insertDepositData($gate, $request->amount, $starPurchase->id);
                $notify[] = 'Deposit inserted';
                return apiResponse("deposit_inserted", "success", $notify, [
                    'deposit'      => $data,
                    'redirect_url' => route('deposit.app.confirm', encrypt($data->id)),
                ]);

            } else {
                $data = (new PaymentController())->insertDepositData($gate, $request->amount, $starPurchase->id);
            }

            return to_route('user.deposit.confirm');
        }

        if ($starPurchase->star->price > $user->balance) {
            $message = 'Insufficient Balance';
            return responseManager('insufficient_balance', $message);
        }

        $this->confirmPurchase($user, $starPurchase->id, $request->amount);

        $redirect = 'user.transactions';

        $message = 'Star Recharged successfully';
        return responseManager('successfully_recharged', $message, 'success', [
            'redirect' => $redirect
        ]);

    }
    public function confirmPurchase($user, $starPurchaseId, $amount)
    {
        $starPurchase         = StarPurchase::findOrFail($starPurchaseId);
        $starPurchase->status = Status::PAYMENT_SUCCESS;
        $starPurchase->save();

        $user->balance -= $amount;
        $user->stars += $starPurchase->star->stars;
        $user->save();

        $userTransaction               = new Transaction();
        $userTransaction->user_id      = $user->id;
        $userTransaction->amount       = $amount;
        $userTransaction->post_balance = $user->balance;
        $userTransaction->trx_type     = '-';
        $userTransaction->details      = 'Star Recharge';
        $userTransaction->trx          = getTrx();
        $userTransaction->remark       = 'star_recharge';
        $userTransaction->save();

        notify($user, 'STAR_RECHARGE_SUCCESS', [
            'amount'         => showAmount($amount),
            'star'           => $starPurchase->star->stars,
            'transaction_id' => $userTransaction->trx,
            'date'           => showDateTime($userTransaction->created_at),
            'post_balance'   => showAmount($user->balance),
        ]);

        $otherStarPurchase = StarPurchase::where('user_id', $user->id)->where('id', '!=', $starPurchaseId)->exists();

        if (!$otherStarPurchase) {
            userReferralCommission($user);
        }

        return [
            'status'  => true,
            'message' => 'Star Recharged successfully',
        ];

    }
}
