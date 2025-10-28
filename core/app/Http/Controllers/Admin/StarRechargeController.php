<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\Deposit;
use Illuminate\Http\Request;

class StarRechargeController extends Controller
{
    protected function starRechargeQuery()
    {
        return Deposit::whereNotNull('star_purchase_id')
            ->with(['user', 'gateway'])
            ->searchable(['trx', 'user:username', 'gateway:name'])
            ->filter(['user_id'])
            ->orderBy('id', getOrderBy())
            ->dateFilter();
    }

    public function pending()
    {
        $pageTitle = 'Pending Star Recharge';
        $recharges = $this->starRechargeQuery()
            ->pending()
            ->paginate(getPaginate());

        return view('admin.star.recharge.log', compact('pageTitle', 'recharges'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Star Recharge';
        $recharges = $this->starRechargeQuery()
            ->approved()
            ->paginate(getPaginate());

        return view('admin.star.recharge.log', compact('pageTitle', 'recharges'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Star Recharge';
        $recharges = $this->starRechargeQuery()
            ->rejected()
            ->paginate(getPaginate());

        return view('admin.star.recharge.log', compact('pageTitle', 'recharges'));
    }

    public function successful()
    {
        $pageTitle = 'Successful Star Recharge';
        $recharges = $this->starRechargeQuery()
            ->successful()
            ->paginate(getPaginate());

        return view('admin.star.recharge.log', compact('pageTitle', 'recharges'));
    }

    public function initiated()
    {
        $pageTitle = 'Initiated Star Recharge';
        $recharges = $this->starRechargeQuery()
            ->initiated()
            ->paginate(getPaginate());

        return view('admin.star.recharge.log', compact('pageTitle', 'recharges'));
    }

    public function allRecharges()
    {
        $pageTitle = 'Star Recharges';
        $recharges = $this->starRechargeQuery()
            ->paginate(getPaginate());

        return view('admin.star.recharge.log', compact('pageTitle', 'recharges'));
    }

    public function details($id)
    {
        $recharge  = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $pageTitle = $recharge->user->username . ' requested ' . showAmount($recharge->amount);
        $details   = ($recharge->detail != null) ? json_encode($recharge->detail) : null;
        return view('admin.star.recharge.detail', compact('pageTitle', 'recharge', 'details'));
    }

    public function approve($id)
    {
        $recharge = Deposit::where('status', Status::PAYMENT_PENDING)->findOrFail($id);

        PaymentController::userDataUpdate($recharge, true);

        $notify[] = ['success', 'Star recharge request approved successfully'];

        return to_route('admin.star.recharge.pending')->withNotify($notify);
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
        return to_route('admin.star.recharge.pending')->withNotify($notify);
    }

}
