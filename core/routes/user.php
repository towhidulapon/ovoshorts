<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->middleware('guest')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::post('qr-code/login/{id}', 'qrCodeLogin')->name('qrcode.login');
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller('SocialiteController')->group(function () {
        Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
        Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
    });
});

Route::middleware('auth')->name('user.')->group(function () {

    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    //authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function () {

        Route::namespace('User')->group(function () {

            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');


                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::get('profile-privacy-setting', 'profilePrivacySetting')->name('profile.privacy.setting');
                Route::get('profile-details', 'profileDetails')->name('profile.details');
                Route::get('tab-content', 'profileTabContent')->name('profile.tab.content');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });

            //message
            Route::controller('MessageController')->prefix('message')->name('message.')->group(function () {
                Route::get('index/{username?}', 'index')->name('index');
                Route::get('fetch/{userId?}', 'fetchMessages')->name('fetch');
                Route::post('send', 'send')->name('send');
                Route::get('sidebar', 'fetchSidebar')->name('sidebar');
                Route::post('mark-as-read', 'markAsRead')->name('mark.as.read');
                Route::get('media/download/{mediaId}', 'downloadMedia')->name('media.download');
                Route::post('online-status', 'updateOnlineStatus')->name('online.status');
            });

            Route::controller('ShortsUploadController')->prefix('shorts-upload')->name('short.upload.')->group(function () {
                Route::get('/{id?}', 'index')->name('index');
                Route::post('initiate', 'initiateUpload')->name('initiate');
                Route::post('chunk', 'uploadChunk')->name('chunk');
                Route::post('complete', 'completeUpload')->name('complete');
                Route::post('store/{id?}', 'store')->name('store');
                Route::post('draft', 'createDraft')->name('draft');
                Route::post('delete-draft/{id?}', 'deleteDraft')->name('delete.draft');
            });

            Route::controller('StarTransactionController')->prefix('star-transaction')->name('star.transaction.')->group(function () {
                Route::post('send-stars', 'sendStars')->name('send');
                Route::post('convert-to-balance', 'convertStarsToBalance')->name('convert');
            });

            Route::controller('NotificationController')->prefix('notification')->name('notification.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('settings', 'getSettings')->name('settings');
                Route::post('save/settings', 'saveSettings')->name('save.settings');
            });

            Route::controller('DashboardController')->prefix('dashboard')->name('dashboard.')->group(function () {
                Route::get('analytics', 'analytics')->name('analytics');
                Route::get('post-analytics/{id}', 'postAnalytics')->name('analytics.post');
                Route::get('analytics/content', 'analyticsContent')->name('analytics.content');
                Route::get('analytics/viewers', 'analyticsViewers')->name('analytics.viewers');
                Route::get('post', 'post')->name('post');
                Route::post('update/privacy', 'updatePrivacy')->name('update.privacy');
                Route::post('pin/{id}', 'pinShort')->name('short.pin');
                Route::post('delete/{id}', 'deleteShort')->name('short.delete');
            });

            Route::controller('FriendsController')->prefix('friend')->name('friend.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('follow/{id}', 'follow')->name('follow');
                Route::post('unfollow/{id}', 'unfollow')->name('unfollow');
                Route::get('following', 'following')->name('following');
                Route::get('friend-list', 'friendList')->name('list');
                Route::get('following-list', 'followingList')->name('following.list');
                Route::get('followers/{id}', 'followers')->name('follower.all');
                Route::get('following/{id}',  'followingUsers')->name('following.all');
                Route::get('load-following-users', 'loadFollowingUsers')->name('load.following.users');
                Route::get('sidebar-followings', 'sidebarFollowingUsers')->name('sidebar.following');
            });

            Route::controller('ReactionController')->prefix('reaction')->name('reaction.')->group(function () {
                Route::post('react', 'reaction')->name('like');
            });

            Route::controller('CommentController')->prefix('comment')->name('comment.')->group(function () {
                Route::post('/', 'store')->name('store');
                Route::post('reply/store', 'replyStore')->name('reply.store');
                Route::post('reaction', 'reaction')->name('reaction');
            });

            Route::controller('SavedShortController')->prefix('saved')->name('saved.')->group(function () {
                Route::post('short', 'toggle')->name('short');
            });

            Route::controller('StarController')->prefix('star')->name('star.')->group(function () {
                Route::get('recharge', 'rechargeIndex')->name('recharge');
                Route::post('store/info', 'storePaymentInfo')->name('store.info');
            });

            Route::controller('VerificationController')->prefix('verification')->name('verification.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('verification-data', 'verificationData')->name('data');
                Route::post('apply-verification', 'applyVerification')->name('apply');
                Route::get('purchase-verification', 'purchaseVerification')->name('purchase');
                Route::post('store-info', 'storePaymentInfo')->name('store.payment.info');
            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        // Payment
        Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
    });
});
