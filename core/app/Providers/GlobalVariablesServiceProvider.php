<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Short;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use App\Services\NotificationService;
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
                'menus'                => json_decode(file_get_contents(resource_path('views/admin/partials/menu.json'))),
                'pendingTicketCount'   => SupportTicket::whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
                'pendingDepositsCount' => Deposit::where('star_purchase_id', null)->pending()->count(),
                'pendingPaymentCount'  => Deposit::where(function ($query) {
                    $query->whereNotNull('star_purchase_id')
                        ->orWhere('is_verification', 1);
                })
                    ->pending()
                    ->count(),
                'pendingWithdrawCount' => Withdrawal::pending()->count(),
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
                'unpublishedShortsCount'        => Short::approved()->unpublished()->count(),
                'pendingShortsCount'            => Short::where('is_approved', Status::SHORT_PENDING)->where('status', Status::UNPUBLISHED)->count(),
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

            if ($cached == null) {
                $user         = auth()->user();
                $notifications = NotificationService::getNotifications($user);

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

        view()->share($viewShare);
    }
}
