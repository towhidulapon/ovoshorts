@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body__wrapper common-body">
        <div class="body__wrapper-container">

            <div class="author-profile pt-4">
                <div class="author-profile__thumb">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                        class="thumb-img fit-image">
                </div>
                <div class="author-profile__content">
                    <h4 class="author-profile__name">{{ $user->username }}</h4>
                    <div class="author-profile__btn">
                        <a href="{{ route('user.profile.setting') }}"
                            class="profile-edit-btn btn btn--base">@lang('Edit Profile')</a>
                        <a href="{{ route('user.profile.privacy.setting') }}" class="profile-action-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                                fill="none">
                                <path
                                    d="M15.5 12.5C15.5 14.433 13.933 16 12 16C10.067 16 8.5 14.433 8.5 12.5C8.5 10.567 10.067 9 12 9C13.933 9 15.5 10.567 15.5 12.5Z"
                                    stroke="CurrentColor" stroke-width="1.5" />
                                <path
                                    d="M21.011 14.5965C21.5329 14.4558 21.7939 14.3854 21.8969 14.2508C22 14.1163 22 13.8998 22 13.4669V11.5332C22 11.1003 22 10.8838 21.8969 10.7493C21.7938 10.6147 21.5329 10.5443 21.011 10.4036C19.0606 9.8776 17.8399 7.83852 18.3433 5.90088C18.4817 5.368 18.5509 5.10157 18.4848 4.9453C18.4187 4.78903 18.2291 4.68135 17.8497 4.46597L16.125 3.48674C15.7528 3.2754 15.5667 3.16973 15.3997 3.19223C15.2326 3.21473 15.0442 3.40274 14.6672 3.77874C13.208 5.23449 10.7936 5.23443 9.33434 3.77865C8.95743 3.40264 8.76898 3.21464 8.60193 3.19213C8.43489 3.16963 8.24877 3.2753 7.87653 3.48664L6.15184 4.46588C5.77253 4.68124 5.58287 4.78892 5.51678 4.94516C5.45068 5.10141 5.51987 5.36788 5.65825 5.90081C6.16137 7.83851 4.93972 9.87764 2.98902 10.4036C2.46712 10.5443 2.20617 10.6147 2.10308 10.7492C2 10.8838 2 11.1003 2 11.5332V13.4669C2 13.8998 2 14.1163 2.10308 14.2508C2.20615 14.3854 2.46711 14.4558 2.98902 14.5965C4.9394 15.1225 6.16008 17.1616 5.65672 19.0992C5.51829 19.6321 5.44907 19.8985 5.51516 20.0548C5.58126 20.2111 5.77092 20.3188 6.15025 20.5341L7.87495 21.5134C8.24721 21.7247 8.43334 21.8304 8.6004 21.8079C8.76746 21.7854 8.95588 21.5973 9.33271 21.2213C10.7927 19.7644 13.2088 19.7643 14.6689 21.2212C15.0457 21.5973 15.2341 21.7853 15.4012 21.8078C15.5682 21.8303 15.7544 21.7246 16.1266 21.5133L17.8513 20.534C18.2307 20.3187 18.4204 20.211 18.4864 20.0547C18.5525 19.8984 18.4833 19.632 18.3448 19.0991C17.8412 17.1616 19.0609 15.1226 21.011 14.5965Z"
                                    stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </a>
                        <button type="button" class="profile-action-btn" data-bs-toggle="modal"
                            data-bs-target="#shareProfileModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                                fill="none">
                                <path
                                    d="M9.39518 5H8.35352C5.40724 5 3.9341 5 3.01881 5.87868C2.10352 6.75736 2.10352 8.17157 2.10352 11V15C2.10352 17.8284 2.10352 19.2426 3.01881 20.1213C3.9341 21 5.40724 21 8.35352 21H12.5601C15.5064 21 16.9795 21 17.8948 20.1213C18.4878 19.552 18.6966 18.7579 18.7701 17.5"
                                    stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M16.1667 7.5V4.35355C16.1667 4.15829 16.3316 4 16.535 4C16.6326 4 16.7263 4.03725 16.7954 4.10355L21.5275 8.64645C21.7634 8.87282 21.8958 9.17986 21.8958 9.5C21.8958 9.82014 21.7634 10.1272 21.5275 10.3535L16.7954 14.8964C16.7263 14.9628 16.6326 15 16.535 15C16.3316 15 16.1667 14.8417 16.1667 14.6464V11.5H13.1157C8.875 11.5 7.3125 15 7.3125 15V12.5C7.3125 9.73858 9.64435 7.5 12.5208 7.5H16.1667Z"
                                    stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <div class="author-profile__activites">
                        <button class="social-counting open-following" data-bs-toggle="modal"
                            data-bs-target="#followingModal">
                            <strong>{{ $user?->followings()?->count() }}</strong> @lang('Following')
                        </button>

                        <button class="social-counting open-followers" data-bs-toggle="modal"
                            data-bs-target="#followersModal" id="openFollowers">
                            <strong>{{ $user?->followers()?->count() }}</strong> @lang('Followers')
                        </button>

                        <a class="social-counting">
                            <strong>{{ $totalLikes }}</strong> @lang('Likes')
                        </a>
                    </div>

                    <div class="author-profile__tag">{{ $user->bio }}</div>
                </div>
            </div>

            <div class="profile-tabs">
                <div class="profile-tabs__top">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link videos active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button">@lang('Videos')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link favorites" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button">@lang('Favorites')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link liked" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button">@lang('Liked')</button>
                        </li>
                    </ul>
                    <div class="tabs-action">
                        @foreach (['latest', 'popular', 'oldest'] as $type)
                            <button class="tabs-action__btn {{ $sort === $type ? 'active' : '' }}"
                                data-sort="{{ $type }}">@lang(ucfirst($type))</button>
                        @endforeach
                    </div>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    @foreach ([
            'home' => $shorts,
            'profile' => $favShorts,
            'contact' => $likedShorts,
        ] as $tab => $collection)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{{ $tab }}"
                            role="tabpanel">
                            @include('Template::user.tab_content', compact('collection', 'tab'))
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

<div class="modal custom--modal fade" id="shareProfileModal" tabindex="-1" aria-labelledby="shareProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title text--base">@lang('Share Profile')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control form--control mb-3 text-center" id="profileShareLink" readonly
                    value="{{ route('user.profile.details', $user->username ?? $user->id) }}">
                <button class="btn btn--base" id="copyProfileLink">@lang('Copy Link')</button>
            </div>
        </div>
    </div>
</div>

<div class="modal custom--modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Followers')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="@lang('Close')"></button>
            </div>
            <div class="modal-body followers-list">
                <div class="text-center py-3">@lang('Loading...')</div>
            </div>
        </div>
    </div>
</div>

<div class="modal custom--modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Following')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="@lang('Close')"></button>
            </div>
            <div class="modal-body following-list">
                <div class="text-center py-3">@lang('Loading...')</div>
            </div>
        </div>
    </div>
</div>


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
        (function($) {
            "use strict";
            let currentPage = 2;
            let isLoading = false;
            let hasMorePages = true;
            let currentSort = '{{ $sort }}' || 'latest';
            let currentTab = 'home';

            $('#copyProfileLink').click(function() {
                $('#profileShareLink').select();
                document.execCommand("copy");
                notify('success', 'Link copied to clipboard');
            });

            function initializeVideoPlayers() {
                $('.video-player').each(function() {
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
                    url: "{{ route('user.profile.tab.content') }}",
                    type: 'GET',
                    data: {
                        tab: currentTab,
                        sort: currentSort,
                        page: currentPage,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            var $newContent = $(response.data.data).find('.explore-item-wrapper')
                        .children();
                            if ($newContent.length > 0) {
                                $('#pills-' + currentTab).find('.explore-item-wrapper').append($newContent);
                            }

                            hasMorePages = response.data.hasMorePages;
                            currentPage++;
                            initializeVideoPlayers();
                        }
                    },
                    complete: function() {
                        isLoading = false;
                    }
                });
            }

            function loadTabContent(reset = true) {
                if (isLoading) return;
                isLoading = true;

                $.ajax({
                    url: "{{ route('user.profile.tab.content') }}",
                    type: 'GET',
                    data: {
                        tab: currentTab,
                        sort: currentSort,
                        page: 1,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        if (reset) {
                            $('#pills-' + currentTab).html($('#skeleton-loader').html());
                        }
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#pills-' + currentTab).html(response.data.data);
                            hasMorePages = response.data.hasMorePages;
                            currentPage = 2;
                            initializeVideoPlayers();
                        }
                    },
                    complete: function() {
                        isLoading = false;
                    }
                });
            }

            $('.tabs-action__btn').click(function(e) {
                e.preventDefault();
                $('.tabs-action__btn').removeClass('active');
                $(this).addClass('active');
                currentSort = $(this).data('sort');
                loadTabContent(true);
            });

            $('.nav-link').click(function(e) {
                e.preventDefault();
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
                currentTab = $(this).attr('data-bs-target').replace('#pills-', '');
                currentPage = 2;
                hasMorePages = true;
                $('.tabs-action__btn').toggleClass('d-none', !$(this).hasClass('videos'));
                loadTabContent(true);
            });

            let followersPage = 1;
            let followersLoading = false;

            $('.open-followers').on('click', function() {
                followersPage = 1;
                $('.followers-list').html('<div class="text-center py-3">Loading...</div>');
                $.get("{{ route('user.friend.follower.all', $user->id) }}?page=" + followersPage, function(
                res) {
                    $('.followers-list').html(res);
                });
            });

            $('#followersModal .modal-body').on('scroll', function() {
                let container = $(this);

                if (!followersLoading &&
                    container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {

                    let nextPage = container.find('.load-more').data('next-page');
                    if (nextPage) {
                        followersLoading = true;
                        container.find('.load-more').html('<div class="py-2">@lang('Loading more...')</div>');

                        $.get(nextPage, function(res) {
                            container.find('.load-more').remove();
                            container.append(res);
                            followersLoading = false;
                        });
                    }
                }
            });


            let followingPage = 1;
            let followingLoading = false;

            $('.open-following').on('click', function() {
                followingPage = 1;
                $('.following-list').html('<div class="text-center py-3">Loading...</div>');

                $.get("{{ route('user.friend.following.all', $user->id) }}?page=" + followingPage, function(
                    res) {
                    $('.following-list').html(res);
                });
            });

            $('#followingModal .modal-body').on('scroll', function() {
                let container = $(this);

                if (!followingLoading &&
                    container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {

                    let nextPage = container.find('.load-more').data('next-page');
                    if (nextPage) {
                        followingLoading = true;
                        container.find('.load-more').html('<div class="py-2">@lang('Loading more...')</div>');

                        $.get(nextPage, function(res) {
                            container.find('.load-more').remove();
                            container.append(res);
                            followingLoading = false;
                        });
                    }
                }
            });


            $(window).on('scroll', function() {
                if (hasMorePages && !isLoading && $(window).scrollTop() + $(window).height() >= $(document)
                    .height() - 200) {
                    loadMoreContent();
                }
            });

            $(document).ready(function() {
                $('.tabs-action__btn[data-sort="' + currentSort + '"]').addClass('active');
                initializeVideoPlayers();
            });
        })(jQuery);
    </script>
@endpush
