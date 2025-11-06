<div class="video__wrapper">
    <div class="video__wrapper-slider">
        <div class="shorts-video_sliders video-slider">
            @forelse ($shorts as $short)
                @include('Template::user.short.view.video_item', ['short' => $short])
            @empty
                <x-empty-message message="No short found" />
            @endforelse
        </div>
    </div>

    <div class="shorts-loading text-center py-4 d-none">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">@lang('Loading...')</span>
        </div>
    </div>

    <div class="shorts-video_arrows"></div>

    <input type="hidden" id="next-page" value="2">
    <input type="hidden" id="has-more" value="{{ $hasMorePages ? '1' : '0' }}">

</div>
<div class="video-comment">
    <div class="right-sidebar">
        <div class="right-sidebar__header">
            <h5 class="right-sidebar__title">@lang('Comments')</h5>
            <button type="button" class="common-action-close"><i class="las la-times"></i></button>
        </div>
        <div class="right-sidebar__body">

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
        <div class="comment-area__box section-bg border-top-0">
            <div class="comment-area__box-inner">
                <form class="comment-box__message comment-form no-submit-loader">
                    <input type="hidden" name="shorts_id" class="short-id" value="{{ $short->id ?? '' }}">
                    <div class="input-group gap-2">
                        <div class="chat__box">
                            <div class="chat__box__inner d-flex w-100 gap-2">
                                <input type="text" class="form--control form-control message" name="message" placeholder=@lang('Comment') required>
                            </div>
                            <button type="submit" class="chat__box-icon">@lang('Post')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Share Modal -->
<div class="modal custom--modal fade-in-scale fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Share to')</h5>
                <button type="button" class="close" data-bs-dismiss="modal"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-center gap-3 d-none">
                    <a href="#" class="share-option whatsapp-link" data-platform="whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640">
                            <path fill="#63E6BE" d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z" />
                        </svg>
                        <div>@lang('WhatsApp')</div>
                    </a>
                    <a href="#" class="share-option facebook-link" data-platform="facebook">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.073 24 12.073z" fill="#3b5998" />
                        </svg>
                        <div>@lang('Facebook')</div>
                    </a>
                    <a href="#" class="share-option telegram-link" data-platform="telegram">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640">
                            <path fill="#74C0FC" d="M320 72C183 72 72 183 72 320C72 457 183 568 320 568C457 568 568 457 568 320C568 183 457 72 320 72zM435 240.7C431.3 279.9 415.1 375.1 406.9 419C403.4 437.6 396.6 443.8 390 444.4C375.6 445.7 364.7 434.9 350.7 425.7C328.9 411.4 316.5 402.5 295.4 388.5C270.9 372.4 286.8 363.5 300.7 349C304.4 345.2 367.8 287.5 369 282.3C369.2 281.6 369.3 279.2 367.8 277.9C366.3 276.6 364.2 277.1 362.7 277.4C360.5 277.9 325.6 300.9 258.1 346.5C248.2 353.3 239.2 356.6 231.2 356.4C222.3 356.2 205.3 351.4 192.6 347.3C177.1 342.3 164.7 339.6 165.8 331C166.4 326.5 172.5 322 184.2 317.3C256.5 285.8 304.7 265 328.8 255C397.7 226.4 412 221.4 421.3 221.2C423.4 221.2 427.9 221.7 430.9 224.1C432.9 225.8 434.1 228.2 434.4 230.8C434.9 234 435 237.3 434.8 240.6z" />
                        </svg>
                        <div>@lang('Telegram')</div>
                    </a>
                    <a href="#" class="share-option copy-link" data-platform="link">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z" fill="#000" />
                        </svg>
                        <div>@lang('Copy Link')</div>
                        <input type="text" class="referralURL form-control d-none" readonly>
                    </a>
                </div>

                <div class="sheer-list">
                    <a href="#" target="_blank" class="sheer_icon facebook-i">
                        <i class="fab fa-facebook-f"></i> <span>@lang('Facebook')</span>
                    </a>

                    <a href="#" class="sheer_icon link-i">
                        <i class="fas fa-link"></i> <span>@lang('Link')</span>
                    </a>
                    <a href="#" target="_blank" class="sheer_icon linkedin-i">
                        <i class="fab fa-linkedin-in"></i> <span>@lang('Linkedin')</span>
                    </a>

                    <a href="#" target="_blank" class="sheer_icon pinterest-i">
                        <i class="fab fa-pinterest-p"></i> <span>@lang('Pinterest')</span>
                    </a>

                    <a href="#" target="_blank" class="sheer_icon whatsapp-i">
                        <i class="fab fa-whatsapp"></i> <span>@lang('Whatsapp')</span>
                    </a>

                    <a href="#" target="_blank" class="sheer_icon messenger-i">
                        <i class="fa-brands fa-facebook-messenger"></i> <span>@lang('Messenger')</span>
                    </a>
                </div>
                <div class="sheer_link d-none">
                    <input type="text" class="form--control" id="copyText" readonly>
                    <button class="btn btn--base copyBtn">@lang('Copy')</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal custom--modal fade-in-scale fade" id="sendStarsModal" tabindex="-1" aria-labelledby="shareProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sendStarsForm" class="no-submit-loader" method="POST" action="{{ route('user.star.transaction.send') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Send Stars')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><i class="las la-times"></i></button>
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

@include('Template::user.short.login_modal')

@push('script')
    <script>
        (function ($) {
            "use strict";
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
            const loadMoreUrl = "{{ route('load.more.shorts') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $(document).ready(function () {
                let isLoading = false;
                const $slider = $('.shorts-video_sliders');
                const $arrows = $('.shorts-video_arrows');
                const nextPageInput = $('#next-page');
                const hasMoreInput = $('#has-more');

                if (!$slider.length) return;

                function playVisibleVideo() {
                    const $currentSlide = $slider.find('.slick-slide.slick-current');
                    const $currentVideo = $currentSlide.find('.video-player')[0];

                    $('.video-player').each(function () {
                        if (this !== $currentVideo) {
                            this.pause();
                        }
                    });

                    if ($currentVideo) {
                        $currentVideo.play().catch(() => { });
                    }
                }

                $slider.on('afterChange', function (event, slick, currentSlide) {
                    playVisibleVideo();

                    const $currentVideo = $(slick.$slides[currentSlide]).find('.video-player');
                    const newShortId = $currentVideo.data('short-id');

                    if($('.video-comment').hasClass('show') && newShortId && newShortId !== currentShortId) {
                        currentShortId = newShortId;
                        currentPage = 1;
                        hasMoreComments = true;

                        $('.comments-container').empty();
                        showSkeletonLoader();

                        loadComments(currentShortId);
                    }
                });

                playVisibleVideo();

                $slider.slick({
                    infinite: false,
                    dots: false,
                    arrows: true,
                    vertical: true,
                    verticalSwiping: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-up"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-down"></i></button>',
                    appendArrows: $arrows
                });

                $slider.on('wheel', function (e) {
                    e.preventDefault();
                    if (e.originalEvent.deltaY < 0) $(this).slick('slickPrev');
                    else $(this).slick('slickNext');
                });

                function initPlyr() {
                    $('.video-player').each(function () {
                        if (!$(this).data('plyr-initialized')) {
                            const player = new Plyr(this);
                            $(this).data('plyr-initialized', true);
                        }
                    });
                }

                function attachVideoEvents($container = $(document)) {
                    $container.find('.video-player').each(function () {
                        if (!$(this).data('events-attached')) {
                            var $video = $(this);
                            var shortId = $video.data('short-id');
                            var $viewCountSpan = $video.closest('.video-item').find('.view-count');
                            var playTime = 0;
                            var lastSentTime = 0;

                            $video.on('timeupdate', function () {
                                playTime = $video[0].currentTime;
                                if (Math.floor(playTime) % 5 === 0 && playTime > lastSentTime) {
                                    $.ajax({
                                        url: '{{ route('short.track.analytics', ':id') }}'.replace(':id', shortId),
                                        type: 'POST',
                                        data: {
                                            play_time: Math.floor(playTime - lastSentTime),
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                lastSentTime = Math.floor(playTime);
                                                console.log('Playtime recorded for short ID: ' + shortId);
                                            }
                                        }
                                    });
                                }
                            });

                            $video.on('ended', function () {
                                $.ajax({
                                    url: '{{ route('short.record.view') }}',
                                    type: 'POST',
                                    data: {
                                        shorts_id: shortId,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            $viewCountSpan.text(response.views_count);
                                        }
                                    }
                                });
                            });

                            $video.on('pause', function () {
                                playTime = 0;
                                lastSentTime = 0;
                            });

                            $(this).data('events-attached', true);
                        }
                    });
                }

                initPlyr();
                attachVideoEvents();

                $slider.on('afterChange', function (event, slick, currentSlide) {
                    const totalSlides = slick.slideCount;
                    if (currentSlide === totalSlides - 1) loadMoreShorts();
                });

                function loadMoreShorts() {
                    const hasMore = hasMoreInput.val() === '1';
                    const nextPage = parseInt(nextPageInput.val());
                    if (!hasMore || isLoading) return;
                    isLoading = true;

                    $.ajax({
                        url: loadMoreUrl,
                        type: 'GET',
                        data: { page: nextPage },
                        success: function (response) {
                            if (response.success === true) {
                                const $newSlides = $(response.data.html);
                                const $validSlides = $newSlides.find('.video-item').addBack('.video-item');

                                if ($validSlides.length > 0) {
                                    $validSlides.each(function () {
                                        $slider.slick('slickAdd', $(this));
                                    });
                                }

                                initPlyr($newSlides);
                                attachVideoEvents($newSlides);

                                nextPageInput.val(nextPage + 1);
                                hasMoreInput.val(response.data.hasMore ? '1' : '0');
                            } else {
                                console.warn('Unexpected response:', response);
                            }
                        },
                        complete: function () {
                            isLoading = false;
                        }
                    });
                }

                let currentPage = 1;
                let hasMoreComments = true;
                let currentShortId = null;

                function showSkeletonLoader() {
                    $('.comments-skeleton').removeClass('d-none');
                    $('.comments-container').addClass('d-none');
                    $('.comments-loading').addClass('d-none');
                }

                function hideSkeletonLoader() {
                    $('.comments-skeleton').addClass('d-none');
                    $('.comments-container').removeClass('d-none');
                }

                function showLoadingIndicator() {
                    $('.comments-loading').removeClass('d-none');
                }

                function hideLoadingIndicator() {
                    $('.comments-loading').addClass('d-none');
                }

                $(document).on('click', ".like-btn", function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        $('.login-modal').modal('show');
                        return;
                    }
                    var $button = $(this);
                    var $countElement = $button.closest(".cmn-button-item").find(".like-count");
                    var shortsId = $button.data("shorts-id");
                    var shortsOwnerId = $button.data("shorts-owner-id");
                    var formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("shorts_id", shortsId);
                    formData.append("shorts_owner_id", shortsOwnerId);
                    $.ajax({
                        url: "{{ route('user.reaction.like') }}",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.data.status === 'liked') {
                                $button.addClass("liked");
                            } else {
                                $button.removeClass("liked");
                            }
                            $countElement.text(response.data.like_count);
                        }
                    });
                });

                function loadComments(shortId, page = 1, append = false) {
                    if (isLoading || !hasMoreComments) return;

                    isLoading = true;
                    if (page === 1) {
                        showSkeletonLoader();
                        $('.comments-container').empty();
                    } else {
                        showLoadingIndicator();
                    }

                    $.ajax({
                        type: "GET",
                        url: "{{ route('user.comment.get') }}",
                        data: {
                            shorts_id: shortId,
                            page: page
                        },
                        success: function (response) {
                            if (response.data && response.data.success) {
                                hideSkeletonLoader();
                                hideLoadingIndicator();
                                if (append) {
                                    $('.comments-container').append(response.data.html);
                                } else {
                                    $('.comments-container').html(response.data.html);
                                }
                                hasMoreComments = response.data.has_more;
                                currentPage = response.data.next_page;
                            } else {
                                notify('error', 'Failed to load comments');
                            }
                            isLoading = false;
                        }
                    });
                }


                $(document).on('click', '.comment-btn', function (e) {
                    e.preventDefault();
                    var $button = $(this);
                    var shortId = $button.data('short-id')

                    if (!shortId) {
                        shortId = $button.closest('.video-item').find('.video-player').data('short-id');
                    }

                    $('.short-id').val(shortId);
                    currentShortId = shortId;
                    currentPage = 1;
                    hasMoreComments = true;

                    $('.video-comment, .right-sidebar').toggleClass('show');

                    loadComments(shortId);
                });

                $('.common-action-close').on('click', function () {
                    $('.video-comment').removeClass('show');
                    $('.right-sidebar').removeClass('show');
                    $('.comments-container').empty();
                    currentShortId = null;
                    currentPage = 1;
                    hasMoreComments = true;
                });

                $('.right-sidebar__body').on('scroll', function () {
                    var $this = $(this);
                    if (
                        $this.scrollTop() + $this.innerHeight() >= $this[0].scrollHeight - 50 &&
                        !isLoading &&
                        hasMoreComments &&
                        currentShortId
                    ) {
                        loadComments(currentShortId, currentPage, true);
                    }
                });

                $('.comment-form').on('submit', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        $('.login-modal').modal('show');
                        return;
                    }
                    var $btn = $(this);
                    var formData = new FormData(this);
                    formData.append("_token", "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('user.comment.store') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                var shortId = $('.short-id').val();
                                var $videoItem = $('.video-item').find(`[data-short-id="${shortId}"]`).closest('.video-item');
                                var $commentCountElement = $videoItem.find('.button-comment .comment-count');
                                $commentCountElement.text(response.comment_count);
                                $('.comment-form').trigger('reset');
                                $('.comments-container').prepend(response.html);
                            }
                        }
                    });
                });

                $(document).on('submit', '.reply-form', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        $('.login-modal').modal('show');
                        return;
                    }
                    var $form = $(this);
                    var formData = new FormData(this);
                    formData.append("_token", "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('user.comment.reply.store') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
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
                                    var newBtnHtml = '<button class="common-action-btn view-replies" data-comment-id="' + $form.data('comment-id') + '">' +
                                        '<span class="count-text">― View 1 reply </span> <i class="las la-angle-down"></i>' +
                                        '</button>';
                                    $form.closest('.comment-item').find('.comment-item__action').append(newBtnHtml);
                                }
                            }
                        }
                    });
                });

                $(document).on('click', '.send-stars-btn', function () {
                    var receiverId = $(this).data('receiver-id');
                    var shortId = $(this).data('short-id');

                    $('#sendStarsForm').data('clickedButton', this);

                    if (!isLoggedIn) {
                        $('.login-modal').modal('show');
                        return;
                    }

                    $('#receiverId').val(receiverId);
                    $('#shortId').val(shortId);
                    $('#sendStarsModal').modal('show');
                });

                $('#sendStarsForm').on('submit', function (e) {
                    e.preventDefault();

                    var $form = $(this);
                    var formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('user.star.transaction.send') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
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

                $(document).on("click", ".follow-btn", function (e) {
                    e.preventDefault();
                    let $btn = $(this);
                    let userId = $btn.data("id");
                    let action = $btn.data("action");

                    $.ajax({
                        url: action === "follow" ? "{{ url('user/friend/follow') }}/" + userId : "{{ url('user/friend/unfollow') }}/" + userId,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            if (response.status === "success") {
                                let $icon = $btn.find("i");
                                if (action === "follow") {
                                    $icon.removeClass("la-plus").addClass("la-check");
                                    $btn.data("action", "unfollow");
                                } else {
                                    $icon.removeClass("la-check").addClass("la-plus");
                                    $btn.data("action", "follow");
                                }
                                notify('success', response.message);

                                $(".sidebar-following-container").load("{{ route('user.friend.sidebar.following') }}");
                            }
                        }
                    });
                });

                $(document).on('click', '.comment-reaction-btn', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        $('.login-modal').modal('show');
                        return;
                    }
                    var $btn = $(this);
                    var commentId = $btn.data('comment-id');
                    var $likesCount = $btn.find('.likes-count');
                    $.ajax({
                        url: "{{ route('user.comment.reaction') }}",
                        method: "POST",
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
                            }
                        }
                    });
                });

                $(document).on('click', '.save-btn', function (e) {
                    e.preventDefault();
                    if (!isLoggedIn) {
                        $('.login-modal').modal('show');
                        return;
                    }
                    var $btn = $(this);
                    var $countElement = $btn.closest('.cmn-button-item').find('.save-count');
                    var shortsId = $btn.data('shorts-id');
                    $.ajax({
                        url: "{{ route('user.saved.short') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            shorts_id: shortsId
                        },
                        success: function (response) {
                            if (response.data.success) {
                                $countElement.text(response.data.saved_count);
                                if (response.data.status === 'saved') {
                                    $btn.addClass('saved');
                                } else {
                                    $btn.removeClass('saved');
                                }
                                notify('success', response.data.message);
                            }
                        }
                    });
                });

                $('.share-btn').on('click', function (e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var shortsId = $btn.data('shorts-id');
                    $('#shareModal').data('shorts-id', shortsId).modal('show');
                });

                $(document).on('click', '.share-btn', function (e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var shortsId = $btn.data('shorts-id');
                    $('#shareModal').data('shorts-id', shortsId).modal('show');
                });


                $(document).on('click', '.sheer_icon', function (e) {
                    e.preventDefault();

                    var platform = '';
                    if ($(this).hasClass('facebook-i')) platform = 'facebook';
                    else if ($(this).hasClass('link-i')) platform = 'link';
                    else if ($(this).hasClass('linkedin-i')) platform = 'linkedin';
                    else if ($(this).hasClass('pinterest-i')) platform = 'pinterest';
                    else if ($(this).hasClass('whatsapp-i')) platform = 'whatsapp';
                    else if ($(this).hasClass('messenger-i')) platform = 'messenger';

                    var shortsId = $('#shareModal').data('shorts-id');
                    var $countElement = $('.video-item').find(`[data-shorts-id="${shortsId}"]`).closest('.video-item').find('.share-count');

                    $.ajax({
                        url: "{{ route('short.share') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            shorts_id: shortsId,
                            platform: platform
                        },
                        success: function (response) {
                            if (response.data.success) {
                                var shortUrl = response.data.share_url;
                                console.log(shortUrl);
                                var shareText = encodeURIComponent("Check out this video! " + shortUrl);
                                var shareUrl = '';

                                $countElement.text(response.data.shares_count);

                                $('#shareModal').data('short-url', shortUrl);

                                switch (platform) {
                                    case 'facebook':
                                        shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shortUrl);
                                        break;
                                    case 'linkedin':
                                        shareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(shortUrl);
                                        break;
                                    case 'pinterest':
                                        shareUrl = 'https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shortUrl);
                                        break;
                                    case 'whatsapp':
                                        shareUrl = 'https://wa.me/?text=' + shareText;
                                        break;
                                    case 'messenger':
                                        shareUrl = 'fb-messenger://share/?link=' + encodeURIComponent(shortUrl);
                                        break;
                                    case 'link':
                                        $('.referralURL').val(shortUrl).select();
                                        if (navigator.clipboard) {
                                            navigator.clipboard.writeText(shortUrl).then(
                                                function () {
                                                    notify('success', 'Link copied to clipboard!');
                                                    $('#shareModal').modal('hide');
                                                    $('.referralURL').addClass('d-none');
                                                },
                                                function (err) {
                                                    notify('error', 'Failed to copy link: ' + err);
                                                }
                                            );
                                        } else {
                                            $('.referralURL').select();
                                            document.execCommand('copy');
                                            notify('success', 'Link copied to clipboard!');
                                            $('#shareModal').modal('hide');
                                            $('.referralURL').addClass('d-none');
                                        }
                                        break;
                                }

                                if (shareUrl) {
                                    window.open(shareUrl, '_blank');
                                }

                            } else {
                                notify('error', response.data.message);
                            }
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endpush