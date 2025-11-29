<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Short;
use App\Models\StarsTransaction;
use App\Models\UserReaction;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    public static function getNotifications($user)
    {
        $userShortIds = Short::where('user_id', $user->id)->pluck('id');

        $likes = UserReaction::whereIn('shorts_id', $userShortIds)
            ->whereNot('user_id', $user->id)
            ->with(['user:id,username,image', 'short:id,cover_image'])
            ->select('id', 'user_id', 'shorts_id', 'created_at')
            ->paginate();

        $comments = Comment::whereIn('shorts_id', $userShortIds)
            ->whereNot('user_id', $user->id)
            ->whereNull('parent_id')
            ->with(['user:id,username,image', 'short:id,cover_image'])
            ->select('id', 'user_id', 'shorts_id', 'message', 'created_at')
            ->paginate();

        $stars = StarsTransaction::whereIn('short_id', $userShortIds)
            ->whereNot('sender_id', $user->id)
            ->with(['sender:id,username,image', 'short:id,cover_image'])
            ->select('id', 'sender_id', 'short_id', 'stars', 'created_at')
            ->paginate();

        $followers = $user->followers()
            ->where('follows.created_at', '>=', now()->subDays(7))
            ->withPivot('created_at')
            ->get()
            ->map(fn($f) => [
                'type'       => 'follower',
                'user'       => $f,
                'created_at' => $f->pivot->created_at,
            ]);

        $likesArray = $likes->map(fn($l) => [
            'type'       => 'like',
            'user'       => $l->user,
            'short'      => $l->short,
            'created_at' => $l->created_at,
        ]);

        $commentsArray = $comments->map(fn($c) => [
            'type'       => 'comment',
            'user'       => $c->user,
            'short'      => $c->short,
            'comment'    => $c->message,
            'created_at' => $c->created_at,
        ]);

        $starsArray = $stars->map(fn($s) => [
            'type'       => 'star',
            'user'       => $s->sender,
            'short'      => $s->short,
            'stars'      => $s->stars,
            'created_at' => $s->created_at,
        ]);

        $notifications = collect(array_merge(
            $likesArray->toArray(),
            $commentsArray->toArray(),
            $starsArray->toArray(),
            $followers->toArray()
        ))->sortByDesc('created_at')->values();

        return self::paginate($notifications, getPaginate());

        // return $notifications;
    }


public static function paginate($items, $perPage)
{
    $page = request()->get('page', 1);

    return new LengthAwarePaginator(
        $items->slice(($page - 1) * $perPage, $perPage)->values(),
        $items->count(),
        $perPage,
        $page,
        [
            'path' => request()->url(),
            'query' => request()->query(),
        ]
    );
}

}
