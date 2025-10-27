<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');
Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blogs', 'blogs')->name('blogs');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');
    Route::get('/explore', 'explore')->name('explore');
    Route::get('/explore/shorts/{id?}', 'exploreShorts')->name('explore.shorts');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('user/details/{username?}', 'userProfile')->name('user.profile');
    Route::get('user/{username}/shorts', 'userProfileShorts')->name('user.profile.shorts');

    Route::get('/search/{index}', 'search')->name('short.search');
    Route::get('/{hashtag}', 'hashtag')->name('short.hashtag');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');

    Route::get('user/shorts/get',  'getShorts')->name('user.shorts.get');
    Route::get('/get/stars', 'getStars')->name('get.stars');

    Route::get('files/{filename}', 'getFile')->name('short.file');

    Route::post('shorts/share', 'share')->name('short.share');
    Route::get('view/short/{id}/{token?}', 'viewShort')->name('user.short.view');
    Route::post('shorts/record', 'recordView')->name('short.record.view');

    Route::post('shorts/analytics/track/{id}', 'trackAnalytics')->name('short.track.analytics');
    Route::get('shorts/analytics/get/{id}', 'getAnalytics')->name('short.get.analytics');

    Route::post('shorts/like/{shortId}', 'like')->name('short.like');
    Route::post('shorts/unlike/{shortId}', 'unlike')->name('short.unlike');
    Route::get('get/comments', 'getComments')->name('user.comment.get');

});

Route::controller('PusherController')->group(function () {
    Route::post('pusher/auth', 'authenticationApp');
    Route::post('pusher/auth/{socketId}/{channelName}', 'authentication');
});
