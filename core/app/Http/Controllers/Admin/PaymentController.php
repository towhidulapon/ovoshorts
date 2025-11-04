<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController as GatewayPaymentController;
use App\Models\Deposit;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected function paymentQuery()
    {
        return Deposit::where(function ($query) {
            $query->whereNotNull('star_purchase_id')
                ->orWhere('is_verification', 1);
        })
            ->with(['user', 'gateway'])
            ->searchable(['trx', 'user:username', 'gateway:name'])
            ->filter(['user_id'])
            ->orderBy('id', getOrderBy())
            ->dateFilter();
    }

    public function pending()
    {
        $pageTitle = 'Pending Payments';
        $recharges = $this->paymentQuery()
            ->pending()
            ->paginate(getPaginate());

        return view('admin.payment.log', compact('pageTitle', 'recharges'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Payments';
        $recharges = $this->paymentQuery()
            ->approved()
            ->paginate(getPaginate());

        return view('admin.payment.log', compact('pageTitle', 'recharges'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Payments';
        $recharges = $this->paymentQuery()
            ->rejected()
            ->paginate(getPaginate());

        return view('admin.payment.log', compact('pageTitle', 'recharges'));
    }

    public function successful()
    {
        $pageTitle = 'Successful Payments';
        $recharges = $this->paymentQuery()
            ->successful()
            ->paginate(getPaginate());

        return view('admin.payment.log', compact('pageTitle', 'recharges'));
    }

    public function initiated()
    {
        $pageTitle = 'Initiated Payments';
        $recharges = $this->paymentQuery()
            ->initiated()
            ->paginate(getPaginate());

        return view('admin.payment.log', compact('pageTitle', 'recharges'));
    }

    public function allPayments()
    {
        $pageTitle = 'Payments';
        $recharges = $this->paymentQuery()
            ->paginate(getPaginate());

        return view('admin.payment.log', compact('pageTitle', 'recharges'));
    }

    public function details($id)
    {
        $recharge  = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $pageTitle = $recharge->user->username . ' requested ' . showAmount($recharge->amount);
        $details   = ($recharge->detail != null) ? json_encode($recharge->detail) : null;
        return view('admin.payment.detail', compact('pageTitle', 'recharge', 'details'));
    }

    public function approve($id)
    {
        $recharge = Deposit::where('status', Status::PAYMENT_PENDING)->findOrFail($id);

        GatewayPaymentController::userDataUpdate($recharge, true);

        $notify[] = ['success', 'Payments request approved successfully'];

        return to_route('admin.payment.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id'      => 'required|integer',
            'message' => 'required|string|max:255',
        ]);
        $recharge = Deposit::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->firstOrFail();

        $recharge->admin_feedback = $request->message;
        $recharge->status         = Status::PAYMENT_REJECT;
        $recharge->save();

        notify($recharge->user, 'RECHARGE_REJECT', [
            'method_name'       => $recharge->methodName(),
            'method_currency'   => $recharge->method_currency,
            'method_amount'     => showAmount($recharge->final_amount, currencyFormat: false),
            'amount'            => showAmount($recharge->amount, currencyFormat: false),
            'charge'            => showAmount($recharge->charge, currencyFormat: false),
            'rate'              => showAmount($recharge->rate, currencyFormat: false),
            'trx'               => $recharge->trx,
            'rejection_message' => $request->message,
        ]);

        $notify[] = ['success', 'Recharge request rejected successfully'];
        return to_route('admin.payment.pending')->withNotify($notify);
    }

}
