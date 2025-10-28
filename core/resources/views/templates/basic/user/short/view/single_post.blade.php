@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="home__right px-0">
        <div class="home-body overflow-hidden">
            <div class="video__wrapper video-details-wrapper bg-img position-relative" data-background-image="{{ getImage(getFilepath('coverImage') . '/' . $short->cover_image, getFileSize('coverImage')) }}">
                <div class="video-details-header d-flex">
                    <a href="#" class="video__back-button">
                        <i class="las la-times"></i>
                    </a>

                    <div class="video-details-header__right d-flex gap-2 align-items-center">
                        <div class="comment__details-btn dropdown-btn d-flex d-xl-none">
                            <i class="las la-comment"></i>
                        </div>
                    </div>
                </div>

                <div class="video__wrapper-slider">
                    <div class="shorts-video_sliders">
                        <div class="video-item">
                            <div class="video-item-wrapper">
                                <video class="video-player" playsinline preload="metadata" data-video_id="{{ encrypt($short->id) }}" data-short-id="{{ $short->id }}" controls poster="{{ getImage(getFilePath('coverImage') . '/' . $short->cover_image, getFileSize('coverImage')) }}">
                                    <source src="{{ $short->fileUrl }}" type="video/{{ $short->extension }}">
                                </video>
                                <div class="video-item-content">
                                    <div class="video-item-content__title">
                                        <span class="name"> {{ $short?->user?->username }}</span>
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                                <path d="M12.9841 22.5158C18.507 22.5158 22.9841 18.0386 22.9841 12.5158C22.9841 6.99293 18.507 2.51578 12.9841 2.51578C7.46128 2.51578 2.98413 6.99293 2.98413 12.5158C2.98413 18.0386 7.46128 22.5158 12.9841 22.5158Z" fill="hsl(var(--base-two))" />
                                                <path d="M9.98413 12.5158L11.9841 14.5158L15.9841 10.5158" stroke="white" stroke-width="2.9921" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="time">{{ diffForHumans($short->post_at) }}</span>
                                    </div>
                                    <p class="video-item-content__desc">
                                        {!! $short->description !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shorts-video_arrows"></div>
            </div>
            <div class="video-comment comment__details video-details-right">
                <span class="sidebar-menu__close d-xl-none d-block"><i class="fas fa-times"></i></span>
                <div class="right-sidebar">
                    <div class="right-sidebar__header d-block">
                        <div class="video-profile-card">
                            <div class="video-profile__auhtor">
                                <div class="video-profile__auhtor-left">
                                    <div class="video-profile__auhtor__thumb">
                                        <img class="fit-image" src="{{ getImage(getFilePath('userProfile') . '/' . $short?->user?->image, getFileSize('userProfile')) }}" alt="image">
                                    </div>
                                    <div class="video-profile__auhtor__content">
                                        <h6 class="video-profile__auhtor__name">{{ $short?->user?->firstname }}
                                            {{ $short?->user?->lastname }}
                                        </h6>
                                        <span class="video-profile__auhtor__username">{{ $short?->user?->username }}
                                        </span>
                                    </div>
                                </div>
                                <div class="video-profile__auhtor-right">
                                    <div class="dropdown message-item__dropdown">
                                        <button class="btn dropdown-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('user.dashboard.post') }}" class="dropdown-item"><i class="las la-bell"></i> @lang('Privacy Settings')</a></li>
                                            <li><button class="dropdown-item confirmationBtn" data-question=" @lang('Are you sure to remove this short?')" data-action="{{ route('user.dashboard.short.delete', $short->id) }}"><i class="las la-trash-alt"></i> @lang('Delete')</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="video-profile__auhtor__desc">
                                <p>{!! $short->description !!}</p>
                            </div>
                        </div>
                        @php
$isLiked =
    auth()->check() &&
    App\Models\UserReaction::where('shorts_id', $short->id)
        ->where('user_id', auth()->id())
        ->exists();
$isSaved =
    auth()->check() &&
    App\Models\SavedShort::where('shorts_id', $short->id)
        ->where('user_id', auth()->id())
        ->exists();
                        @endphp
                        <div class="video-action-wrapper">
                            <div class="video-item__action video-action-button-group">
                                <div class="cmn-button-item">
                                    <button class="like-button  button-item reactionBtn like-btn {{ $isLiked ? 'liked' : '' }}" data-shorts-id="{{ $short->id }}" data-shorts-owner-id="{{ $short->user_id }}" tabindex="0">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                                            <path d="M19.1799 3.61667C17.0683 3.61667 15.1783 4.64334 13.9999 6.21834C12.8216 4.64334 10.9316 3.61667 8.81992 3.61667C5.23825 3.61667 2.33325 6.53334 2.33325 10.1383C2.33325 11.5267 2.55492 12.81 2.93992 14C4.78325 19.8333 10.4649 23.3217 13.2766 24.2783C13.6733 24.4183 14.3266 24.4183 14.7233 24.2783C17.5349 23.3217 23.2166 19.8333 25.0599 14C25.4449 12.81 25.6666 11.5267 25.6666 10.1383C25.6666 6.53334 22.7616 3.61667 19.1799 3.61667Z" fill="CurrentColor"></path>
                                        </svg>
                                    </button>
                                    <span class="button-text likeCount like-count">{{ showFormatCount($short->likes_count) }}</span>
                                </div>
                                @if ($short->allow_comment === Status::YES)
                                    <div class="cmn-button-item button-comment">
                                        <button class="like-button button-item reactionBtn" tabindex="0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                                                <path d="M18.6666 2.33333H9.33325C4.66659 2.33333 2.33325 4.66667 2.33325 9.33333V24.5C2.33325 25.1417 2.85825 25.6667 3.49992 25.6667H18.6666C23.3333 25.6667 25.6666 23.3333 25.6666 18.6667V9.33333C25.6666 4.66667 23.3333 2.33333 18.6666 2.33333ZM16.3333 17.7917H8.16659C7.68825 17.7917 7.29159 17.395 7.29159 16.9167C7.29159 16.4383 7.68825 16.0417 8.16659 16.0417H16.3333C16.8116 16.0417 17.2083 16.4383 17.2083 16.9167C17.2083 17.395 16.8116 17.7917 16.3333 17.7917ZM19.8333 11.9583H8.16659C7.68825 11.9583 7.29159 11.5617 7.29159 11.0833C7.29159 10.605 7.68825 10.2083 8.16659 10.2083H19.8333C20.3116 10.2083 20.7083 10.605 20.7083 11.0833C20.7083 11.5617 20.3116 11.9583 19.8333 11.9583Z" fill="CurrentColor"></path>
                                            </svg>
                                        </button>
                                        <span class="button-text likeCount comment-count">{{ showFormatCount($short->comments->count()) }}</span>
                                    </div>
                                @endif
                                <div class="cmn-button-item">
                                    <button class="like-button  button-item reactionBtn save-btn {{ $isSaved ? 'saved' : '' }}" data-shorts-id="{{ $short->id }}" tabindex="0">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                                            <path d="M19.6233 2.33333H8.37662C5.89162 2.33333 3.87329 4.36333 3.87329 6.83667V23.275C3.87329 25.375 5.37829 26.2617 7.22162 25.2467L12.915 22.085C13.5216 21.7467 14.5016 21.7467 15.0966 22.085L20.79 25.2467C22.6333 26.2733 24.1383 25.3867 24.1383 23.275V6.83667C24.1266 4.36333 22.1083 2.33333 19.6233 2.33333ZM17.5116 11.375C16.38 11.7833 15.19 11.9933 14 11.9933C12.81 11.9933 11.62 11.7833 10.4883 11.375C10.0333 11.2117 9.79996 10.71 9.96329 10.255C10.1383 9.8 10.64 9.56667 11.095 9.73C12.9733 10.4067 15.0383 10.4067 16.9166 9.73C17.3716 9.56667 17.8733 9.8 18.0366 10.255C18.2 10.71 17.9666 11.2117 17.5116 11.375Z" fill="CurrentColor"></path>
                                        </svg>
                                    </button>
                                    <span class="button-text likeCount save-count">{{ showFormatCount($short->savedShorts->count()) }}</span>
                                </div>
                                <div class="cmn-button-item">
                                    <button class="like-button button-item send-stars-btn @if ($short->user_id == auth()->id()) disabled @endif" data-receiver-id="{{ $short->user_id }}" data-short-id="{{ $short->id }}" tabindex="0" @if ($short->user_id == auth()->id()) disabled @endif>
                                        ⭐
                                    </button>
                                    <span class="button-text likeCount star-count">{{ $short->stars_sum_stars ?? 0 }}</span>
                                </div>


                            </div>
                            <div class="social-media__wrapper">
                                <button class="social-media__link blue share-link" data-shorts-id="{{ $short->id }}" data-platform="link"><i class="fas fa-link"></i></button>
                                <a href="#" target="_blank" class="social-media__link red telegram-link" data-platform="telegram"><i class="fab fa-telegram-plane"></i></a>
                                <a href="#" target="_blank" class="social-media__link green whatsapp-link" data-platform="whatsapp"><i class="fab fa-whatsapp"></i></a>
                                <a href="#" target="_blank" class="social-media__link fb fb-link" data-platform="facebook"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                        <div class="input-group video-action__copybtn copy-board d-none">
                            <input type="text" name="key" value="" class="form-control form--control referralURL" readonly="" id="key">
                            <button type="button" class="btn text-white copybtn" id="copyBoard">
                                @lang('Copy link')
                            </button>
                        </div>

                        <ul class="nav nav-pills mb-3 custom--tab video-action-tabs" id="pills-tab" role="tablist">
                            @if ($short->allow_comments === Status::YES)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">@lang('Comments')
                                        ({{ showFormatCount($short->comments->count()) }})</button>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">@lang('Creator videos')</button>
                            </li>
                        </ul>
                    </div>


                    <div class="right-sidebar__body">
                        <div class="tab-content" id="pills-tabContent">
                            @if ($short->allow_comments === Status::YES)
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                                    <div class="comments-skeleton d-none">
                                        @for ($i = 0; $i <= 7; $i++)
                                            @include($activeTemplate . 'user.short.view.comment_skeleton')
                                        @endfor
                                    </div>

                                    <div class="comment-item-wrapper comments-container">

                                    </div>

                                    <div class="text-center py-3 comments-loading d-none">
                                        <div class="spinner-border text-light" role="status">
                                            <span class="visually-hidden">@lang('Loading...')</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                <div class="d-none shorts-skeleton">
                                    <div class="row g-3">
                                        @for ($i = 0; $i <= 9; $i++)
                                            <div class="col-6 col-md-4">
                                                <div class="skeleton-card">
                                                    <div class="skeleton-thumb placeholder-glow">
                                                        <span class="placeholder w-100 h-100"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="explore-item-wrapper explore-item-wrapper--grid shorts-container">

                                </div>
                                <div class="text-center py-3 shorts-loading d-none">
                                    <div class="spinner-border text-light" role="status">
                                        <span class="visually-hidden">@lang('Loading...')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($short->allow_comments === Status::YES)
                        <div class="comment-area__box section-bg border-top-0">
                            <div class="comment-area__box-inner">
                                <form class="comment-box__message comment-form no-submit-loader">
                                    <input type="hidden" name="shorts_id" class="short-id" value="{{ $short->id }}">
                                    <div class="input-group gap-2">
                                        <div class="chat__box">
                                            <div class="chat__box__inner d-flex w-100 gap-2">
                                                <input type="text" class="form--control form-control message" name="message" placeholder="@lang('Add Comment')" required>
                                            </div>
                                            <button type="submit" class="chat__box-icon">@lang('Post')</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal isFrontend="true" />
@endsection

<div class="modal custom--modal fade" id="sendStarsModal" tabindex="-1" aria-labelledby="shareProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sendStarsForm" class="no-submit-loader" method="POST" action="{{ route('user.star.transaction.send') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Send Stars')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="receiver_id" id="receiverId">
                    <input type="hidden" name="shorts_id" id="shortId">
                    <div class="mb-3">
                        <label>@lang('Number of Stars')</label>
                        <input type="number" class="form-control form--control" name="stars" min="1" required>
                    </div>
                    <div class="mb-3">
                        <h6 class="available-stars">@lang('Stars Available:') {{ auth()?->user()?->stars }}</h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary">@lang('Send')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('style')
    <style>
        .shorts-skeleton {
            margin-top: 10px;
        }

        .skeleton-card {
            background: #111;
            border-radius: 8px;
            overflow: hidden;
        }

        .skeleton-thumb {
            width: 100%;
            height: 200px;
            border-radius: 6px;
            background: #222;
        }

        .placeholder {
            background-color: #2c2c2c !important;
        }

        .placeholder-glow .placeholder {
            background: linear-gradient(90deg, #2c2c2c 25%, #3a3a3a 50%, #2c2c2c 75%);
            background-size: 200% 100%;
            animation: placeholder-shimmer 1.5s infinite;
        }

        @keyframes placeholder-shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                let commentPage = 1;
                let shortsPage = 1;
                let isLoadingComments = false;
                let isLoadingShorts = false;
                let hasMoreComments = true;
                let hasMoreShorts = true;
                let currentShortId = {{ $short->id }};
                let currentUserId = {{ $short->user_id }};

                // Comments
                function showCommentSkeletonLoader() {
                    $('.comments-skeleton').removeClass('d-none');
                    $('.comments-container').addClass('d-none');
                    $('.comments-loading').addClass('d-none');
                }

                function hideCommentSkeletonLoader() {
                    $('.comments-skeleton').addClass('d-none');
                    $('.comments-container').removeClass('d-none');
                }

                function showCommentLoadingIndicator() {
                    $('.comments-loading').removeClass('d-none');
                }

                function hideCommentLoadingIndicator() {
                    $('.comments-loading').addClass('d-none');
                }

                // Shorts
                function showShortsSkeletonLoader() {
                    $('.shorts-skeleton').removeClass('d-none');
                    $('.shorts-container').addClass('d-none');
                    $('.shorts-loading').addClass('d-none');
                }

                function hideShortsSkeletonLoader() {
                    $('.shorts-skeleton').addClass('d-none');
                    $('.shorts-container').removeClass('d-none');
                }

                function showShortsLoadingIndicator() {
                    $('.shorts-loading').removeClass('d-none');
                }

                function hideShortsLoadingIndicator() {
                    $('.shorts-loading').addClass('d-none');
                }

                function initializePlyrPlayers($container) {
                    $container.find('.video-player').each(function () {
                        let poster = $(this).attr('poster');
                        let player = new Plyr(this);
                        if (poster) {
                            $(this).attr('poster', poster);
                        }
                    });
                }

                function loadComments(shortId, page = 1, append = false) {
                    if (isLoadingComments || !hasMoreComments) return;

                    isLoadingComments = true;
                    if (page === 1) {
                        showCommentSkeletonLoader();
                        $('.comments-container').empty();
                    } else {
                        showCommentLoadingIndicator();
                    }

                    $.ajax({
                        type: "GET",
                        url: "{{ route('user.comment.get') }}",
                        data: { shorts_id: shortId, page: page },
                        success: function (response) {
                            console.log('Comments response:', response);
                            if (response.data && response.data.success) {
                                hideCommentSkeletonLoader();
                                hideCommentLoadingIndicator();
                                if (append) {
                                    $('.comments-container').append(response.data.html);
                                } else {
                                    $('.comments-container').html(response.data.html);
                                }
                                hasMoreComments = response.data.has_more;
                                commentPage = response.data.next_page || page + 1;
                            } else {
                                notify('error', 'Failed to load comments');
                            }
                            isLoadingComments = false;
                        }
                    });
                }

                function loadShorts(userId, shortId, page = 1, append = false) {
                    if (isLoadingShorts || !hasMoreShorts) return;

                    isLoadingShorts = true;

                    if (page === 1) {
                        // Show skeleton loader for initial load
                        $('.shorts-skeleton').removeClass('d-none');
                        $('.shorts-container').addClass('d-none');
                        $('.shorts-loading').addClass('d-none');
                        $('.shorts-container').empty();
                    } else {
                        // Show loading indicator for pagination
                        $('.shorts-skeleton').addClass('d-none');
                        $('.shorts-container').removeClass('d-none');
                        $('.shorts-loading').removeClass('d-none');
                    }

                    $.ajax({
                        type: "GET",
                        url: "{{ route('user.shorts.get') }}",
                        data: {
                            user_id: userId,
                            exclude_short_id: shortId,
                            page: page
                        },
                        success: function (response) {
                            console.log('Shorts response:', response);

                            // Hide both loaders
                            $('.shorts-skeleton').addClass('d-none');
                            $('.shorts-loading').addClass('d-none');
                            $('.shorts-container').removeClass('d-none');

                            if (response.data && response.data.success) {
                                if (append) {
                                    $('.shorts-container').append(response.data.html);
                                } else {
                                    $('.shorts-container').html(response.data.html);
                                }

                                // Initialize video players
                                initializePlyrPlayers($('.shorts-container'));

                                // Update pagination state
                                hasMoreShorts = response.data.has_more;
                                shortsPage = response.data.next_page || page + 1;
                            } else {
                                notify('error', 'Failed to load shorts');
                            }
                            isLoadingShorts = false;
                        }
                    });
                }

                $('#pills-home-tab').on('shown.bs.tab', function () {
                    console.log('Comments tab shown, loading comments for shortId:', currentShortId);
                    commentPage = 1;
                    hasMoreComments = true;
                    loadComments(currentShortId);
                    $('.comment-area__box').removeClass('d-none');
                });

                $('#pills-profile-tab').on('shown.bs.tab', function () {
                    console.log('Creator Videos tab shown, loading shorts for userId:', currentUserId);
                    shortsPage = 1;
                    hasMoreShorts = true;
                    loadShorts(currentUserId, currentShortId);
                    $('.comment-area__box').addClass('d-none');
                });

                if ($('#pills-home-tab').hasClass('active')) {
                    $('.comment-area__box').removeClass('d-none');
                    loadComments(currentShortId);
                }

                if ($('#pills-profile-tab').hasClass('active')) {
                    $('.comment-area__box').addClass('d-none');
                    loadShorts(currentUserId, currentShortId);
                }

                let scrollTimeout;
                $('.right-sidebar__body').on('scroll', function () {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        var $this = $(this);
                        var scrollTop = $this.scrollTop();
                        var innerHeight = $this.innerHeight();
                        var scrollHeight = $this[0].scrollHeight;

                        if (scrollTop + innerHeight >= scrollHeight - 100) {
                            if ($('#pills-home').hasClass('active') && !isLoadingComments && hasMoreComments && currentShortId) {
                                console.log('Loading more comments, page:', commentPage);
                                loadComments(currentShortId, commentPage, true);
                            } else if ($('#pills-profile').hasClass('active') && !isLoadingShorts && hasMoreShorts && currentUserId) {
                                console.log('Loading more shorts, page:', shortsPage);
                                loadShorts(currentUserId, currentShortId, shortsPage, true);
                            }
                        }
                    });
                });

                $('.comment-form').on('submit', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('user.login') }}";
                        return;
                    }
                    var $form = $(this);
                    var formData = new FormData($form[0]);
                    formData.append("_token", "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('user.comment.store') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log('Comment store response:', response);
                            if (response.success) {
                                var $commentCountElement = $('.button-comment .comment-count');
                                $commentCountElement.text(response.comment_count);
                                $form.trigger('reset');
                                $('.comments-container').prepend(response.html);
                                notify('success', 'Comment added successfully');
                                $('#pills-home-tab').text(`Comments (${response.comment_count})`);
                            } else {
                                notify('error', 'Failed to add comment');
                            }
                        }
                    });
                });

                $(document).on('click', '.like-btn', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('user.login') }}";
                        return;
                    }
                    var $button = $(this);
                    var $countElement = $button.closest('.cmn-button-item, .explore-item').find('.like-count');
                    var shortsId = $button.data('shorts-id');
                    var shortsOwnerId = $button.data('shorts-owner-id');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('shorts_id', shortsId);
                    formData.append('shorts_owner_id', shortsOwnerId);
                    $.ajax({
                        url: "{{ route('user.reaction.like') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log('Like response:', response);
                            if (response.data.status === 'liked') {
                                $button.addClass('liked');
                            } else {
                                $button.removeClass('liked');
                            }
                            $countElement.text(response.data.like_count);
                        }
                    });
                });

                $(document).on('click', '.comment-reaction-btn', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('user.login') }}";
                        return;
                    }
                    var $btn = $(this);
                    var commentId = $btn.data('comment-id');
                    var $likesCount = $btn.find('.likes-count');
                    $.ajax({
                        url: "{{ route('user.comment.reaction') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            comment_id: commentId
                        },
                        success: function (response) {
                            if (response.data.success) {
                                $likesCount.text(response.data.likes);
                                if (response.data.status === 'liked') {
                                    $btn.addClass('liked');
                                } else {
                                    $btn.removeClass('liked');
                                }
                                notify('success', response.data.message);
                            } else {
                                notify('error', 'Failed to update reaction');
                            }
                        }
                    });
                });

                $(document).on('submit', '.reply-form', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('user.login') }}";
                        return;
                    }
                    var $form = $(this);
                    var formData = new FormData(this);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('user.comment.reply.store') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log('Reply response:', response);
                            if (response.success) {
                                $form[0].reset();
                                $form.closest('.reply-form-container').addClass('d-none');
                                var $repliesContainer = $form.closest('.comment-item').find('.replies-container');
                                $repliesContainer.prepend(response.html);
                                $repliesContainer.show();
                                var $viewRepliesBtn = $form.closest('.comment-item').find('.view-replies');
                                if ($viewRepliesBtn.length) {
                                    var currentCount = parseInt($viewRepliesBtn.find('.count-text').text().match(/\d+/)[0]);
                                    $viewRepliesBtn.find('.count-text').text('― View ' + (currentCount + 1) + ' replies');
                                } else {
                                    var newBtnHtml =
                                        '<button class="common-action-btn view-replies" data-comment-id="' +
                                        $form.data('comment-id') + '">' +
                                        '<span class="count-text">― View 1 reply </span> <i class="las la-angle-down"></i>' +
                                        '</button>';
                                    $form.closest('.comment-item').find('.comment-item__action').append(newBtnHtml);
                                }
                            } else {
                                notify('error', 'Failed to add reply');
                            }
                        }
                    });
                });

                $(document).on('click', '.reply-btn', function (e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var $commentItem = $btn.closest('.comment-item');
                    var $replyFormContainer = $commentItem.find('.reply-form-container');
                    $replyFormContainer.toggleClass('d-none');
                    if (!$replyFormContainer.hasClass('d-none')) {
                        $replyFormContainer.find('input[name="message"]').focus();
                    }
                });

                $(document).on('click', '.view-replies', function (e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var $commentItem = $btn.closest('.comment-item');
                    var $repliesContainer = $commentItem.find('.replies-container');
                    $repliesContainer.toggleClass('d-none');
                    $btn.find('i').toggleClass('la-angle-down la-angle-up');
                });

                $(document).on('click', '.save-btn', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('user.login') }}";
                        return;
                    }
                    var $btn = $(this);
                    var $countElement = $btn.closest('.cmn-button-item').find('.save-count');
                    var shortsId = $btn.data('shorts-id');
                    $.ajax({
                        url: "{{ route('user.saved.short') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            shorts_id: shortsId
                        },
                        success: function (response) {
                            console.log('Save response:', response);
                            if (response.data.success) {
                                $countElement.text(response.data.saved_count);
                                if (response.data.status === 'saved') {
                                    $btn.addClass('saved');
                                } else {
                                    $btn.removeClass('saved');
                                }
                                notify('success', response.data.message);
                            } else {
                                notify('error', 'Failed to update save status');
                            }
                        }
                    });
                });

                $('.send-stars-btn').on('click', function () {
                    var receiverId = $(this).data('receiver-id');
                    var shortId = $(this).data('short-id');
                    $('#sendStarsForm').data('clickedButton', this);
                    $('#receiverId').val(receiverId);
                    $('#shortId').val(shortId);
                    $('#sendStarsModal').modal('show');
                });

                $('#sendStarsForm').on('submit', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        window.location.href = "{{ route('user.login') }}";
                        return;
                    }
                    var $form = $(this);
                    var formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('user.star.transaction.send') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log('Star transaction response:', response);
                            if (response.status == 'success') {
                                var $btn = $($form.data('clickedButton'));
                                $btn.siblings('.star-count').text(response.data.stars_count);
                                notify('success', response.message);
                                $('.available-stars').text(response.data.stars_available);
                                $form.trigger('reset');
                                $('#sendStarsModal').modal('hide');
                            } else {
                                notify('error', response.message);
                            }
                        }
                    });
                });

                $(document).on('click', '.share-link, .telegram-link, .whatsapp-link, .fb-link', function (e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var shortsId = currentShortId;
                    var platform = $btn.data('platform');
                    var $countElement = $('.video-item__action').find('.share-count');
                    $.ajax({
                        url: "{{ route('short.share') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            shorts_id: shortsId,
                            platform: platform
                        },
                        success: function (response) {
                            console.log('Share response:', response);
                            if (response.data.success) {
                                if ($countElement.length) {
                                    $countElement.text(response.data.shares_count);
                                }
                                if (platform === 'link') {
                                    $('.referralURL').val(response.data.share_url);
                                    $('.copy-board').removeClass('d-none');
                                } else if (platform === 'telegram') {
                                    window.open('https://t.me/share/url?url=' + encodeURIComponent(response.data.share_url), '_blank');
                                } else if (platform === 'whatsapp') {
                                    window.open('https://wa.me/?text=' + encodeURIComponent(response.data.share_url), '_blank');
                                } else if (platform === 'facebook') {
                                    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(response.data.share_url), '_blank');
                                }
                                notify('success', response.message);
                            } else {
                                notify('error', 'Failed to share');
                            }
                        }
                    });
                });

                $(document).on('click', '.copybtn', async function (e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var textToCopy = $('.referralURL').val();
                    try {
                        await navigator.clipboard.writeText(textToCopy);
                        notify('success', 'Link copied to clipboard!');
                        $btn.text('Copied!').prop('disabled', true);
                        setTimeout(function () {
                            $btn.text('Copy link').prop('disabled', false);
                        }, 2000);
                    } catch (error) {
                        console.error('Error copying link:', error);
                        notify('error', 'Failed to copy link');
                    }
                });

                $(document).on('click', '.video__back-button', function (e) {
                    e.preventDefault();

                    const referrer = document.referrer;

                    const exploreRoute = "{{ route('explore') }}";
                    const userRouteBase = "{{ url('user') }}";

                    if (referrer.startsWith(exploreRoute) || referrer.startsWith(userRouteBase)) {
                        window.location.href = referrer;
                        return;
                    }

                    if (window.history.length > 1) {
                        window.history.back();
                        return;
                    }

                    window.location.href = exploreRoute;
                });
            });
        })(jQuery);
    </script>
@endpush