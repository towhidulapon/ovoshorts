<?php

namespace App\Traits;

use App\Models\UserReaction;
use App\Models\User;
use Illuminate\Http\Request;

trait ReactionManager
{
    public function reaction(Request $request)
    {
        $request->validate([
            'shorts_id'       => 'required|exists:shorts,id',
            'shorts_owner_id' => 'required|exists:users,id',
        ]);

        $reaction = UserReaction::where('user_id', auth()->user()->id)->where('shorts_id', $request->shorts_id)->first();

        if ($reaction) {
            $reaction->delete();
            $status = 'unliked';
        } else {
            $reaction                  = new UserReaction();
            $reaction->user_id         = auth()->user()->id;
            $reaction->shorts_id       = $request->shorts_id;
            $reaction->shorts_owner_id = $request->shorts_owner_id;
            $reaction->save();
            $status = 'liked';
        }

        $likeCount = UserReaction::where('shorts_id', $request->shorts_id)->count();

        $owner = User::find($request->shorts_owner_id);

        if($owner->notify_like){
            notify($owner, 'LIKE_ADDED', [
                'username'   => auth()->user()->username,
                'short'      => $request->shorts_id,
                'created_at' => now(),
            ]);
        }

        return apiResponse('like', 'success', ['You have ' . $status . ' the short'], [
            'status'     => $status,
            'like_count' => showFormatCount($likeCount),
        ]);

    }
}
