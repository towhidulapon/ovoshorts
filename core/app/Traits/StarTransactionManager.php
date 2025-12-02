<?php
namespace App\Traits;

use App\Models\Short;
use App\Models\StarsTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

trait StarTransactionManager
{
    public function sendStars(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'stars'       => 'required|integer|gte:0',
            'shorts_id'   => 'required|exists:shorts,id',
        ]);

        if ($request->receiver_id == auth()->user()->id) {
            return apiResponse('receiver_not_found', 'error', ['Can\'t send stars to yourself']);
        }

        $sender = auth()->user();
        if ($sender->stars < $request->stars) {
            return apiResponse('not_enough_stars', 'error', ['Not enough stars']);
        }

        $sender->stars -= $request->stars;
        $sender->save();

        $receiver = User::find($request->receiver_id);
        $receiver->stars += $request->stars;
        $receiver->save();

        $starsTransaction              = new StarsTransaction();
        $starsTransaction->sender_id   = $sender->id;
        $starsTransaction->receiver_id = $receiver->id;
        $starsTransaction->short_id    = $request->shorts_id;
        $starsTransaction->stars       = $request->stars;
        $starsTransaction->save();

        $short           = Short::find($request->shorts_id);
        $shortTotalStars = $short->stars()->sum('stars');

        if($receiver->notify_stars){
            notify($receiver, 'STAR_ADDED', [
                'username'   => auth()->user()->username,
                'short'      => $short,
                'stars'      => $request->stars,
                'created_at' => now(),
            ]);
        }

        return apiResponse('star_sent', 'success', ['Stars sent successfully!'], [
            'stars_count' => $shortTotalStars,
            'stars_available' => $sender->stars
        ]);
    }

    public function convertStarsToBalance(Request $request)
    {
        $request->validate([
            'stars' => 'required|integer|gte:0',
        ]);

        $user = auth()->user();
        if ($user->stars < $request->stars) {
            return apiResponse('not_enough_stars', 'error', ['Not enough stars']);
        }

        $user->stars -= $request->stars;
        $amount = $request->stars * gs('star_price');
        $user->balance += $amount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Stars Converted to Balance';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'star_converted';
        $transaction->save();

        return responseManager('star_converted', 'Stars converted successfully', 'success', [
            'balance' => showAmount($user->balance),
            'stars_available' => $user->stars
        ]);

    }

}
