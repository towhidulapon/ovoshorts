@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <div class="home-fluid">
        <div class="home__inner">
            @if (!request()->routeIs('user.short.view'))
                @include('Template::partials.sidebar')
                <div class="home__right">

                    @include('Template::partials.mobile_bottom')

                    @php
    $isProfileDetails = request()->routeIs('user.profile.details', 'user.profile');
    $isExploreRoute = request()->routeIs('explore', 'user.friend.index', 'user.friend.following');
    $shouldShowHeader = !request()->routeIs('explore');
                    @endphp

                    <div class="home-body{{ $isProfileDetails ? '' : ($isExploreRoute ? ' common-body' : ' overflow-hidden') }}">
                        @if ($shouldShowHeader)
                            @include('Template::partials.header')
                        @endif
                        @include('Template::partials.mobile_top_menu')
                        @yield('content')
                    </div>

                </div>
            @else
                @yield('content')
            @endif
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        $(document).ready(function () {

            $('.load-more-followings').on('click', function () {
                var button = $(this);
                var page = button.data('page');
                // var skip = button.data('skip');

                $.ajax({
                    url: "{{ route('user.friend.load.following.users') }}",
                    type: "GET",
                    data: { page: page },
                    success: function (response) {
                        $('.followings-container').append(response.html);

                        if(response.hasMore) {
                            button.data('page', page + 1);
                        } else {
                            button.hide();
                        }

                    }
                });
            });

        });
    </script>
@endpush