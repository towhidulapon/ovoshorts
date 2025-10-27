@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body__wrapper">
        <div class="body__wrapper-container">
            <div class="explore-section">
                <div class="explore-item-follower friends-container">
                    @include('Template::user.friend.users_list', ['users' => $users, 'following' => $following])
                </div>

                <div id="loading-indicator" class="text-center my-4 d-none">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">@lang('Loading...')</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        let currentPage = 2;
        let isLoading = false;
        let hasMorePages = true;

        function initVideoHover() {
            $('.friends-container .explore-item').each(function () {
                let $video = $(this).find('.video-player');
                $(this).off('mouseenter mouseleave');
                $(this).on('mouseenter', function () {
                    if ($video.length) {
                        $video[0].muted = true;
                        $video[0].play().catch(err => {
                            console.log("Play failed:", err);
                        });
                    }
                });
                $(this).on('mouseleave', function () {
                    if ($video.length && !$video[0].paused) {
                        $video[0].pause();
                        $video[0].currentTime = 0;
                    }
                });
            });
        }

        function initPlyr() {
            if (typeof window.plyrInstances !== 'undefined') {
                window.plyrInstances.forEach(player => player.destroy());
            }

            const players = Array.from(document.querySelectorAll('.friends-container .video-player')).map(p => new Plyr(p));
            window.plyrInstances = players;
        }

        function loadMoreFriends() {
            if (isLoading || !hasMorePages) return;

            isLoading = true;
            $('#loading-indicator').removeClass('d-none');
            $('.load-more').prop('disabled', true);

            $.ajax({
                url: "{{ route('user.friend.list') }}?page=" + currentPage,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        $('.friends-container').append(response.data.data);

                        currentPage++;

                        hasMorePages = response.data.hasMorePages;

                        initPlyr();
                        initVideoHover();

                        if (!hasMorePages) {
                            $('.load-more').addClass('d-none');
                        }
                    }
                },
                complete: function () {
                    isLoading = false;
                    $('#loading-indicator').addClass('d-none');
                    $('.load-more').prop('disabled', false);
                }
            });
        }

        $(window).on('scroll', function () {
            if (hasMorePages && !isLoading && $(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                loadMoreFriends();
            }
        });

        $(document).ready(function () {
            initPlyr();
            initVideoHover();

            const hasMorePagesInitial = $('.load-more').data('has-more-pages');
            if (hasMorePagesInitial !== undefined) {
                hasMorePages = hasMorePagesInitial === 'true';
            }

            if (!hasMorePages) {
                $('.load-more').addClass('d-none');
            }
        });

        $(document).on("click", ".follow-btn", function (e) {
            e.preventDefault();
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

        $(".load-more").on("click", function () {
            loadMoreFriends();
        });
    </script>
@endpush