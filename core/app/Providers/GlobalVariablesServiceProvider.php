<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Comment;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Message;
use App\Models\Short;
use App\Models\StarsTransaction;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\UserReaction;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;

class GlobalVariablesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $viewShare['emptyMessage'] = 'No data found';

        view()->composer(['admin.partials.topnav', "Template::partials.header", "Template::partials.auth_header"], function ($view) {
            $view->with([
                'languages' => Language::get(),
            ]);
        });

        view()->composer(['admin.partials.sidenav', 'admin.partials.topnav'], function ($view) {
            $view->with([
                'menus'                    => json_decode(file_get_contents(resource_path('views/admin/partials/menu.json'))),
                'pendingTicketCount'       => SupportTicket::whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingDepositsCount'     => Deposit::where('star_purchase_id', null)->pending()->count(),
                'pendingStarRechargeCount' => Deposit::where('star_purchase_id', '!=', null)->pending()->count(),
                'pendingWithdrawCount'     => Withdrawal::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'     => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
                'hasNotification'        => AdminNotification::exists(),
            ]);
        });

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'              => User::banned()->count(),
                'emailUnverifiedUsersCount'     => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'    => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'       => User::kycUnverified()->count(),
                'kycPendingUsersCount'          => User::kycPending()->count(),
                'verificationPendingUsersCount' => User::verificationPending()->count(),
                'unpublishedShortsCount'        => Short::where('is_approved', Status::SHORT_PENDING)->orWhere('status', Status::UNPUBLISHED)->count(),
                'draftShortsCount'              => Short::where('status', Status::DRAFT)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

         View()->composer([
            'Template::home',
            'Template::user.short.explore',
            'Template::user.friend.*',
            'Template::user.message.index',
            'Template::user.profile_details',
            'Template::user.short.hashtag',
            'Template::user.short.search',
        ], function ($view) {
            if (!auth()->check()) {
                return $view->with('groupedNotifications', [
                    'today'      => collect(),
                    'yesterday'  => collect(),
                    'this_month' => collect(),
                ])->with('unreadNotifications', 0);
            }

            static $cached = null;

            if ($cached === null) {
                $user         = auth()->user();
                $userShortIds = Short::where('user_id', $user->id)->pluck('id');

                $likes = UserReaction::whereIn('shorts_id', $userShortIds)
                    ->whereNot('user_id', $user->id)
                    ->with(['user:id,username,image', 'short:id,cover_image'])
                    ->select('id', 'user_id', 'shorts_id', 'created_at')
                    ->get();

                $comments = Comment::whereIn('shorts_id', $userShortIds)
                    ->whereNot('user_id', $user->id)
                    ->whereNull('parent_id')
                    ->with(['user:id,username,image', 'short:id,cover_image'])
                    ->select('id', 'user_id', 'shorts_id', 'message', 'created_at')
                    ->get();

                $stars = StarsTransaction::whereIn('short_id', $userShortIds)
                    ->whereNot('sender_id', $user->id)
                    ->with(['sender:id,username,image', 'short:id,cover_image'])
                    ->select('id', 'sender_id', 'short_id', 'stars', 'created_at')
                    ->get();

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

                $thisMonthStart = now()->startOfMonth();

                $cached = [
                    'groupedNotifications' => [
                        'today'      => $notifications->filter(fn($n) => $n['created_at']->isToday()),
                        'yesterday'  => $notifications->filter(fn($n) => $n['created_at']->isYesterday()),
                        'this_month' => $notifications->filter(fn($n) =>
                            $n['created_at']->gte($thisMonthStart)
                            && !$n['created_at']->isToday()
                            && !$n['created_at']->isYesterday()
                        ),
                    ],
                    'unreadNotifications'  => $notifications->count(),
                ];
            }

            $view->with('groupedNotifications', $cached['groupedNotifications'])
                ->with('unreadNotifications', $cached['unreadNotifications']);
        });


        // View()->composer(['Template::home', 'Template::user.short.explore', 'Template::user.friend.*', 'Template::user.message.index', 'Template::user.profile_details'], function ($view) {
        //     if (auth()->check()) {
        //         $user         = auth()->user();
        //         $userShortIds = Short::where('user_id', $user->id)->pluck('id');

        //         // Existing likes
        //         $likes = UserReaction::whereIn('shorts_id', $userShortIds)
        //             ->whereNot('user_id', $user->id)
        //             ->with(['user' => function ($query) {
        //                 $query->select('id', 'username', 'image');
        //             }, 'short' => function ($query) {
        //                 $query->select('id', 'cover_image');
        //             }])
        //             ->select('id', 'user_id', 'shorts_id', 'created_at')
        //             ->get();

        //         // Existing comments
        //         $comments = Comment::whereIn('shorts_id', $userShortIds)
        //             ->whereNot('user_id', $user->id)
        //             ->whereNull('parent_id')
        //             ->with(['user' => function ($query) {
        //                 $query->select('id', 'username', 'image');
        //             }, 'short' => function ($query) {
        //                 $query->select('id', 'cover_image');
        //             }])
        //             ->select('id', 'user_id', 'shorts_id', 'message', 'created_at')
        //             ->get();

        //         // New: Stars transactions
        //         $stars = StarsTransaction::whereIn('short_id', $userShortIds)
        //             ->whereNot('sender_id', $user->id)
        //             ->with(['sender' => function ($query) {
        //                 $query->select('id', 'username', 'image');
        //             }, 'short' => function ($query) {
        //                 $query->select('id', 'cover_image');
        //             }])
        //             ->select('id', 'sender_id', 'short_id', 'stars', 'created_at')
        //             ->get();

        //         $followers = $user->followers()
        //             ->where('follows.created_at', '>=', now()->subDays(7))
        //             ->withPivot('created_at')
        //             ->get()
        //             ->map(function ($follower) {
        //                 return [
        //                     'type'       => 'follower',
        //                     'user'       => $follower,
        //                     'created_at' => $follower->pivot->created_at,
        //                 ];
        //             });

        //         // Map likes
        //         $likesArray = $likes->map(function ($like) {
        //             return [
        //                 'type'       => 'like',
        //                 'user'       => $like->user,
        //                 'short'      => $like->short,
        //                 'created_at' => $like->created_at,
        //             ];
        //         });

        //         // Map comments
        //         $commentsArray = $comments->map(function ($comment) {
        //             return [
        //                 'type'       => 'comment',
        //                 'user'       => $comment->user,
        //                 'short'      => $comment->short,
        //                 'comment'    => $comment->message,
        //                 'created_at' => $comment->created_at,
        //             ];
        //         });

        //         // Map stars
        //         $starsArray = $stars->map(function ($star) {
        //             return [
        //                 'type'       => 'star',
        //                 'user'       => $star->sender,
        //                 'short'      => $star->short,
        //                 'stars'      => $star->stars,
        //                 'created_at' => $star->created_at,
        //             ];
        //         });

        //         // Merge all notifications
        //         $notifications = collect(array_merge(
        //             $likesArray->toArray(),
        //             $commentsArray->toArray(),
        //             $starsArray->toArray(),
        //             $followers->toArray()
        //         ))->sortByDesc('created_at')->values();

        //         // Group notifications
        //         $today          = Carbon::today();
        //         $yesterday      = Carbon::yesterday();
        //         $thisMonthStart = Carbon::now()->startOfMonth();

        //         $groupedNotifications = [
        //             'today'      => $notifications->filter(fn($n) => $n['created_at']->isToday()),
        //             'yesterday'  => $notifications->filter(fn($n) => $n['created_at']->isYesterday()),
        //             'this_month' => $notifications->filter(fn($n) => $n['created_at']->gte($thisMonthStart) && !$n['created_at']->isToday() && !$n['created_at']->isYesterday()),
        //         ];

        //         $unreadNotifications = $notifications->count();

        //         $view->with('groupedNotifications', $groupedNotifications)
        //             ->with('unreadNotifications', $unreadNotifications);
        //     } else {
        //         $view->with('groupedNotifications', ['today' => collect(), 'yesterday' => collect(), 'this_month' => collect()])
        //             ->with('unreadNotifications', 0);
        //     }
        // });

        view()->share($viewShare);
    }
}
