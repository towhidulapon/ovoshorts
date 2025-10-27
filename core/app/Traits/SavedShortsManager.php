<?php

namespace App\Traits;

use App\Models\SavedShort;
use Illuminate\Http\Request;

trait SavedShortsManager
{
    public function toggle(Request $request)
    {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
        ]);

        $userId   = auth()->user()->id;
        $shortsId = $request->shorts_id;

        $savedShort = SavedShort::where('user_id', $userId)->where('shorts_id', $shortsId)->first();

        if ($savedShort) {
            $savedShort->delete();
            $status  = 'unsaved';
            $message = 'Video removed from favorites';
        } else {
            $savedShort            = new SavedShort();
            $savedShort->user_id   = $userId;
            $savedShort->shorts_id = $shortsId;
            $savedShort->save();
            $status  = 'saved';
            $message = 'Video added to favorites';
        }

        $savedCount = SavedShort::where('shorts_id', $shortsId)->count();

        return apiResponse('saved', 'success', [$message], [
            'success'     => true,
            'status'      => $status,
            'saved_count' => $savedCount,
            'message'     => $message,
        ]);

    }
}
