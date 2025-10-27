@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body__wrapper">
        <div class="body__wrapper-container">
            <div class="scroll-wrapper__header">
                <div class="scroll-wrapper">
                    <button class="scroll-btn left" id="scrollLeft"><i class="las la-angle-left"></i></button>
                    <div class="scroll-container" id="scrollContainer">
                        <a href="{{ route('explore') }}" class="menu-link {{ request()->route('id') ? '' : 'active' }}" data-id="0">@lang('All')</a>
                        @foreach ($categories as $category)
                            <a href="{{ route('explore', $category->id) }}" class="menu-link {{ request()->route('id') == $category->id ? 'active' : '' }}" data-id="{{ $category->id }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                    <button class="scroll-btn right" id="scrollRight"><i class="las la-angle-right"></i></button>
                </div>
            </div>

            <div class="explore-section">

                @include('Template::user.short_skeleton')

                <div class="explore-item-wrapper explore-shorts" id="explore-shorts-container">
                    @include('Template::user.short.explore_shorts', ['shorts' => $shorts])
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

        (function ($) {
            "use strict";

            let currentPage = 1;
            let categoryId = "{{ request()->route('id') ?? 0 }}";
            let isLoading = false;
            let hasMorePages = {{ $shorts->hasMorePages() ? 'true' : 'false' }};

            function loadMoreShorts() {
                if (isLoading || !hasMorePages) return;

                isLoading = true;
                $('#loading-indicator').removeClass('d-none');

                $.ajax({
                    url: "{{ route('explore', 0) }}",
                    type: 'GET',
                    data: { page: currentPage + 1, id: categoryId },
                    success: function (response) {
                        if (response.html) {
                            $('#explore-shorts-container').append(response.html);
                            currentPage++;
                            hasMorePages = response.hasMorePages;

                            $('#explore-shorts-container .video-player').each(function () {
                                let poster = $(this).attr('poster');
                                let player = new Plyr(this);
                                if (poster) $(this).attr('poster', poster);
                            });
                        }
                    },
                    complete: function () {
                        isLoading = false;
                        $('#loading-indicator').addClass('d-none');
                    }
                });
            }

            $(window).on('scroll', function () {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    loadMoreShorts();
                }
            });

            $(document).on('click', '.menu-link', function (e) {
                e.preventDefault();
                let id = $(this).data('id');

                $('.menu-link').removeClass('active');
                $(this).addClass('active');

                $.ajax({
                    url: "{{ route('explore.shorts', ':id') }}".replace(':id', id),
                    type: 'GET',
                    beforeSend: function () {
                        $('.explore-shorts').html($('#skeleton-loader').html());
                    },
                    success: function (data) {
                        $('.explore-shorts').html(data);

                        $('.explore-shorts .video-player').each(function () {
                            let poster = $(this).attr('poster');
                            let player = new Plyr(this);
                            if (poster) {
                                $(this).attr('poster', poster);
                            }
                        });
                    }
                });
            });

        })(jQuery);

    </script>
@endpush