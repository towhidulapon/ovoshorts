<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::namespace('Api')->name('api.')->group(function () {

    Route::controller('AppController')->group(function () {
        Route::get('general-setting', 'generalSetting');
        Route::get('get-countries', 'getCountries');
        Route::get('language/{key}', 'getLanguage');
        Route::get('policies', 'policies');
        Route::get('faq', 'faq');

        Route::get('shorts', 'index');
        Route::post('shorts/record', 'recordView');
        Route::post('shorts/analytics/track/{id}', 'trackAnalytics');
        Route::get('shorts/analytics/get/{id}', 'getAnalytics');

        Route::get('user/details/{username?}', 'userProfile');

        Route::get('/get/stars', 'getStars');

        Route::get('/get/comments', 'getComments');

        Route::post('shorts/share', 'share');
        Route::get('/search/{index}', 'search');
        Route::get('/hashtag/{hashtag}', 'hashtag');
    });

    Route::controller('PusherController')->group(function () {
        Route::post('pusher/auth', 'authenticationApp');
        Route::post('pusher/auth/{socketId}/{channelName}', 'authentication');
    });

    Route::namespace('Auth')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::post('login', 'login');
            Route::post('check-token', 'checkToken');
            Route::post('social-login', 'socialLogin');
        });
        Route::post('register', 'RegisterController@register');

        Route::controller('ForgotPasswordController')->group(function () {
            Route::post('password/email', 'sendResetCodeEmail');
            Route::post('password/verify-code', 'verifyCode');
            Route::post('password/reset', 'reset');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('user-data-submit', 'UserController@userDataSubmit');

        //authorization
        Route::middleware('registration.complete')->controller('AuthorizationController')->group(function () {
            Route::get('authorization', 'authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode');
            Route::post('verify-email', 'emailVerification');
            Route::post('verify-mobile', 'mobileVerification');
            Route::post('verify-g2fa', 'g2faVerification');
        });

        Route::middleware(['check.status'])->group(function () {

            Route::middleware('registration.complete')->group(function () {

                Route::controller('UserController')->group(function () {

                    Route::get('dashboard', 'dashboard');
                    Route::get('profile-details', 'profileDetails');
                    Route::post('profile-setting', 'submitProfile');
                    Route::post('change-password', 'submitPassword');

                    Route::get('user-info', 'userInfo');
                    //KYC
                    Route::get('kyc-form', 'kycForm');
                    Route::post('kyc-submit', 'kycSubmit');

                    //Report
                    Route::any('deposit/history', 'depositHistory');
                    Route::get('transactions', 'transactions');

                    Route::post('add-device-token', 'addDeviceToken');
                    Route::get('push-notifications', 'pushNotifications');
                    Route::post('push-notifications/read/{id}', 'pushNotificationsRead');

                    //2FA
                    Route::get('twofactor', 'show2faForm');
                    Route::post('twofactor/enable', 'create2fa');
                    Route::post('twofactor/disable', 'disable2fa');

                    Route::post('delete-account', 'deleteAccount');
                });

                Route::controller('ShortsUploadController')->prefix('shorts-upload')->group(function () {
                    Route::post('upload', 'uploadShort');
                    Route::get('categories', 'getCategories');
                    // Route::post('draft', 'createDraft');
                    // Route::get('delete-draft/{id?}', 'deleteDraft');
                });

                Route::controller('CommentController')->prefix('comment')->group(function () {
                    Route::post('/', 'store');
                    Route::post('/reply/store', 'replyStore');
                    Route::post('/reaction', 'reaction');
                });

                Route::controller('ReactionController')->prefix('reaction')->group(function () {
                    Route::post('react', 'reaction');
                });

                Route::controller('SavedShortController')->prefix('saved')->group(function () {
                    Route::post('/short', 'toggle');
                });

                Route::controller('MessageController')->prefix('message')->group(function () {
                    Route::get('index/{username?}', 'index');
                    Route::get('fetch/{userId?}', 'fetchMessages');
                    Route::post('send', 'send');
                    Route::get('fetch-message', 'fetchMessagesHtml');
                    Route::get('chatlist', 'fetchSidebar');
                    Route::post('mark-as-read', 'markAsRead');
                    Route::get('media/download/{mediaId}', 'downloadMedia');
                    Route::post('online-status', 'updateOnlineStatus');
                    Route::get('online-users', 'onlineUsers');
                });

                Route::controller('StarController')->prefix('star')->group(function () {
                    Route::post('/store/info', 'storePaymentInfo');
                });

                Route::controller('StarTransactionController')->prefix('star-transaction')->group(function () {
                    Route::post('/send-stars', 'sendStars');
                    Route::post('/convert-to-balance', 'convertStarsToBalance');
                });

                Route::controller('VerificationController')->prefix('verification')->group(function () {
                    Route::get('/', 'index');
                    Route::get('/verification-data', 'verificationData');
                    Route::post('/apply', 'applyVerification');
                    Route::post('/purchase', 'purchaseVerification');
                    Route::post('/store-info', 'storePaymentInfo');
                });

                Route::controller('DashboardController')->prefix('dashboard')->group(function () {
                    Route::get('analytics', 'analytics');
                    Route::get('post-analytics/{id}', 'postAnalytics');
                    Route::get('analytics/content', 'analyticsContent');
                    Route::get('analytics/viewers', 'analyticsViewers');
                    Route::get('post', 'post');
                    Route::post('update/privacy', 'updatePrivacy');
                    Route::post('pin/{id}', 'pinShort');
                    Route::post('short/delete/{id}', 'deleteShort');
                });

                Route::controller('FriendsController')->prefix('friend')->group(function () {
                    Route::get('/index', 'index');
                    Route::post('follow/{id}', 'follow');
                    Route::post('unfollow/{id}', 'unfollow');
                    Route::get('following', 'following');
                    Route::get('following-shorts', 'followingShorts');
                    Route::get('new-followers', 'newFollowers');
                    Route::get('followers/{id}', 'followers');
                });

                // Withdraw
                Route::controller('WithdrawController')->group(function () {
                    Route::middleware('kyc')->group(function () {
                        Route::get('withdraw-method', 'withdrawMethod');
                        Route::post('withdraw-request', 'withdrawStore');
                        Route::post('withdraw-request/confirm', 'withdrawSubmit');
                    });
                    Route::get('withdraw/history', 'withdrawLog');
                });

                // Payment
                Route::controller('PaymentController')->group(function () {
                    Route::get('deposit/methods', 'methods');
                    Route::post('deposit/insert', 'depositInsert');
                    Route::post('app/payment/confirm', 'appPaymentConfirm');
                });

                Route::controller('TicketController')->prefix('ticket')->group(function () {
                    Route::get('/', 'supportTicket');
                    Route::post('create', 'storeSupportTicket');
                    Route::get('view/{ticket}', 'viewTicket');
                    Route::post('reply/{id}', 'replyTicket');
                    Route::post('close/{id}', 'closeTicket');
                    Route::get('download/{attachment_id}', 'ticketDownload');
                });
            });
        });
        Route::get('logout', 'Auth\LoginController@logout');
    });
});
