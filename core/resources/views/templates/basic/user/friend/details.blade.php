@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body__wrapper common-body">
        <div class="body__wrapper-container">
            <div class="author-profile pt-4">
                <div class="author-profile__thumb">
                    <img src="{{ $follower->image ? getImage(getFilePath('userProfile') . '/' . $follower->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" class="thumb-img fit-image">
                </div>
                <div class="author-profile__content">
                    <h4 class="author-profile__name">
                        {{ $follower->username }}
                    </h4>
                    <div class="author-profile__btn">
                        @if(in_array($follower->id, $following))
                            <button class="btn btn--base-two follow-btn" data-id="{{ $follower->id }}" data-action="unfollow">
                                @lang('Following')
                            </button>
                        @else
                            <button class="btn btn--base follow-btn" data-id="{{ $follower->id }}" data-action="follow">
                                @lang('Follow')
                            </button>
                        @endif

                        <a href="{{ route('user.message.index', $follower->username) }}" class="profile-edit-btn btn btn--base message-btn">@lang('Message')</a>

                        <button type="button" class="profile-action-btn" data-bs-toggle="modal" data-bs-target="#shareProfileModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                <path d="M9.39518 5H8.35352C5.40724 5 3.9341 5 3.01881 5.87868C2.10352 6.75736 2.10352 8.17157 2.10352 11V15C2.10352 17.8284 2.10352 19.2426 3.01881 20.1213C3.9341 21 5.40724 21 8.35352 21H12.5601C15.5064 21 16.9795 21 17.8948 20.1213C18.4878 19.552 18.6966 18.7579 18.7701 17.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16.1667 7.5V4.35355C16.1667 4.15829 16.3316 4 16.535 4C16.6326 4 16.7263 4.03725 16.7954 4.10355L21.5275 8.64645C21.7634 8.87282 21.8958 9.17986 21.8958 9.5C21.8958 9.82014 21.7634 10.1272 21.5275 10.3535L16.7954 14.8964C16.7263 14.9628 16.6326 15 16.535 15C16.3316 15 16.1667 14.8417 16.1667 14.6464V11.5H13.1157C8.875 11.5 7.3125 15 7.3125 15V12.5C7.3125 9.73858 9.64435 7.5 12.5208 7.5H16.1667Z" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <div class="author-profile__activites">
                        <button class="social-counting open-following" data-bs-toggle="modal" data-bs-target="#followingModal">
                            <strong>{{ $follower?->followings()?->count() }}</strong> @lang('Following')
                        </button>

                        <button class="social-counting open-followers" data-bs-toggle="modal" data-bs-target="#followersModal" id="openFollowers">
                            <strong>{{ $follower?->followers()?->count() }}</strong> @lang('Followers')
                        </button>

                        <a class="social-counting">
                            <strong>{{ $totalLikes }}</strong> @lang('Likes')
                        </a>
                    </div>

                    <div class="author-profile__tag">
                        {{ $follower->bio }}
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <div class="profile-tabs__top">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M17.7 21.3351C16.528 21.4998 14.9995 21.4998 12.95 21.4998H11.05C7.01949 21.4998 5.00424 21.4998 3.75212 20.2476C2.5 18.9955 2.5 16.9803 2.5 12.9498V11.0498C2.5 7.01925 2.5 5.00399 3.75212 3.75187C5.00424 2.49976 7.01949 2.49976 11.05 2.49976H12.95C16.9805 2.49976 18.9957 2.49976 20.2478 3.75187C21.5 5.00399 21.5 7.01925 21.5 11.0498V12.9498C21.5 14.158 21.5 15.1851 21.4662 16.0648C21.4392 16.7699 21.4257 17.1224 21.1587 17.2541C20.8917 17.3859 20.5931 17.1746 19.9957 16.752L18.65 15.7998" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.9453 12.3948C14.7686 13.0215 13.9333 13.4644 12.2629 14.3502C10.648 15.2064 9.8406 15.6346 9.18992 15.4625C8.9209 15.3913 8.6758 15.2562 8.47812 15.07C8 14.6198 8 13.7465 8 12C8 10.2535 8 9.38018 8.47812 8.92995C8.6758 8.74381 8.9209 8.60868 9.18992 8.53753C9.8406 8.36544 10.648 8.79357 12.2629 9.64983C13.9333 10.5356 14.7686 10.9785 14.9453 11.6052C15.0182 11.8639 15.0182 12.1361 14.9453 12.3948Z" stroke="CurrentColor" stroke-width="2" stroke-linejoin="round" />
                                </svg> @lang('Videos')</button>
                        </li>
                    </ul>
                    <div class="tabs-action">
                        <button class="tabs-action__btn active" data-sort="latest">@lang('Latest')</button>
                        <button class="tabs-action__btn" data-sort="popular">@lang('Popular')</button>
                        <button class="tabs-action__btn" data-sort="oldest">@lang('Oldest')</button>
                    </div>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        @include('Template::user.friend.shorts', ['shorts' => $shorts])
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

<div class="modal custom--modal fade-in-scale fade" id="shareProfileModal" tabindex="-1" aria-labelledby="shareProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-end p-3 p-lg-4">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body text-center">
                <input type="text" class="form-control form--control mb-3 text-center" id="profileShareLink" readonly value="{{ route('user.profile.details', $follower->username ?? $follower->id) }}">
                <button class="btn btn--base" id="copyProfileLink">@lang('Copy Link')</button>
            </div>
        </div>
    </div>
</div>

<div class="modal custom--modal fade-in-scale fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-end p-3 p-lg-4">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body followers-list">
                <div class="text-center py-3">@lang('Loading...')</div>
            </div>
        </div>
    </div>
</div>

<div class="modal custom--modal fade-in-scale fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-end p-3 p-lg-4">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body following-list">
                <div class="text-center py-3">@lang('Loading...')</div>
            </div>
        </div>
    </div>
</div>

@include('Template::user.short.login_modal')


@push('style')
    <style>
        #followingModal .modal-body.following-list {
            max-height: 300px;
            overflow-y: auto;
        }

        #followersModal .modal-body.following-list {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endpush



@push('script')
    <script>
        (function ($) {
            "use strict";
            let currentPage = 2;
            let isLoading = false;
            let hasMorePages = true;
            let currentSort = 'latest';
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

            $('#copyProfileLink').on('click', function () {
                var copyText = document.getElementById("profileShareLink");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                notify('success', 'Link copied to clipboard');
            });

            function initializeVideoPlayers() {
                $('.video-player').each(function () {
                    let poster = $(this).attr('poster');
                    let player = new Plyr(this);
                    if (poster) {
                        $(this).attr('poster', poster);
                    }
                });
            }

            function loadMoreContent() {
                if (isLoading || !hasMorePages) return;
                isLoading = true;

                $.ajax({
                    url: "{{ route('user.profile.shorts', $follower->username) }}",
                    type: 'GET',
                    data: {
                        sort: currentSort,
                        page: currentPage,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            var $newContent = $(response.data.data).find('.explore-item-wrapper').children();
                            if ($newContent.length > 0) {
                                $('.tab-pane.active').find('.explore-item-wrapper').append($newContent);
                            }

                            hasMorePages = response.data.hasMorePages;
                            currentPage++;
                            initializeVideoPlayers();
                        }
                    },
                    complete: function () {
                        isLoading = false;
                    }
                });
            }

            function loadTabContent(reset = true) {
                if (isLoading) return;
                isLoading = true;

                $.ajax({
                    url: "{{ route('user.profile.shorts', $follower->username) }}",
                    type: 'GET',
                    data: {
                        sort: currentSort,
                        page: 1,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        if (reset) {
                            $('.tab-pane.active').find('#skeleton-loader').removeClass('d-none');
                            $('.tab-pane.active').find('.explore-item-wrapper').addClass('d-none');
                        }
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            $('.tab-pane.active').find('.explore-item-wrapper').html($(response.data.data).find('.explore-item-wrapper').html());
                            $('.tab-pane.active').find('#skeleton-loader').addClass('d-none');
                            $('.tab-pane.active').find('.explore-item-wrapper').removeClass('d-none');

                            hasMorePages = response.data.hasMorePages;
                            currentPage = 2;
                            initializeVideoPlayers();
                        }
                    },
                    complete: function () {
                        isLoading = false;
                    }
                });
            }

            $(document).on("click", ".follow-btn", function (e) {
                e.preventDefault();

                if (!isLoggedIn) {
                    $('.login-modal').modal('show');
                    return;
                }

                let $btn = $(this);
                let userId = $btn.data("id");
                let action = $btn.data("action");

                $.ajax({
                    url: action === "follow"
                        ? "{{ url('user/friend/follow') }}/" + userId
                        : "{{ url('user/friend/unfollow') }}/" + userId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            if (action === "follow") {
                                $btn.removeClass("btn--base").addClass("btn--base-two")
                                    .text("Following")
                                    .data("action", "unfollow");
                                notify('success', response.message);
                            } else {
                                $btn.removeClass("btn--base-two").addClass("btn--base")
                                    .text("Follow")
                                    .data("action", "follow");
                                notify('success', response.message);
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.message-btn', function (e) {
                e.preventDefault();

                if (!isLoggedIn) {
                    $('.login-modal').modal('show');
                    return;
                }

                window.location.href = $(this).attr('href');
            });

            $('.tabs-action__btn').click(function (e) {
                e.preventDefault();
                $('.tabs-action__btn').removeClass('active');
                $(this).addClass('active');
                currentSort = $(this).data('sort');
                loadTabContent(true);
            });


            let followersPage = 1;
            let followersLoading = false;

            $('.open-followers').on('click', function () {
                followersPage = 1;
                $('.followers-list').html('<div class="text-center py-3">Loading...</div>');
                $.get("{{ route('user.friend.follower.all', $follower->id) }}?page=" + followersPage, function (
                    res) {
                    $('.followers-list').html(res);
                });
            });

            $('#followersModal .modal-body').on('scroll', function () {
                let container = $(this);

                if (!followersLoading &&
                    container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {

                    let nextPage = container.find('.load-more').data('next-page');
                    if (nextPage) {
                        followersLoading = true;
                        container.find('.load-more').html('<div class="py-2">@lang('Loading more...')</div>');

                        $.get(nextPage, function (res) {
                            container.find('.load-more').remove();
                            container.append(res);
                            followersLoading = false;
                        });
                    }
                }
            });


            let followingPage = 1;
            let followingLoading = false;

            $('.open-following').on('click', function () {
                followingPage = 1;
                $('.following-list').html('<div class="text-center py-3">Loading...</div>');

                $.get("{{ route('user.friend.following.all', $follower->id) }}?page=" + followingPage, function (
                    res) {
                    $('.following-list').html(res);
                });
            });

            $('#followingModal .modal-body').on('scroll', function () {
                let container = $(this);

                if (!followingLoading &&
                    container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {

                    let nextPage = container.find('.load-more').data('next-page');
                    if (nextPage) {
                        followingLoading = true;
                        container.find('.load-more').html('<div class="py-2">@lang('Loading more...')</div>');

                        $.get(nextPage, function (res) {
                            container.find('.load-more').remove();
                            container.append(res);
                            followingLoading = false;
                        });
                    }
                }
            });

            $(window).on('scroll', function () {
                if (hasMorePages && !isLoading && $(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    loadMoreContent();
                }
            });

            $(document).ready(function () {
                $('.tabs-action__btn[data-sort="' + currentSort + '"]').addClass('active');
                initializeVideoPlayers();
            });
        })(jQuery);
    </script>
@endpush