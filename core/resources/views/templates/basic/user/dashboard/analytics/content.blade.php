@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')

    <div class="dashboard-body">
        <div class="dashboard-body__bar d-lg-none d-block">
            <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
        </div>
        <div class="dashboard-action-header flex-wrap gap-2 mb-4">
            <h5 class="card-header__title mb-0 text-white flex-align gap-2">@lang('Your top posts')<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                        <path d="M10.0003 18.8333C14.6027 18.8333 18.3337 15.1023 18.3337 10.5C18.3337 5.89759 14.6027 2.16663 10.0003 2.16663C5.39795 2.16663 1.66699 5.89759 1.66699 10.5C1.66699 15.1023 5.39795 18.8333 10.0003 18.8333Z" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10 13.8333V10.5" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10 7.16663H10.0083" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </h5>
        </div>

        <div class="card custom--card ">
            <div class="card-header">
                <div class="post__menu">
                    <a href="#" class="post__menu-btn active" data-sort="views">@lang('Most Views')</a>
                    <a href="#" class="post__menu-btn" data-sort="likes">@lang('Most Likes')</a>
                </div>
            </div>
            <div class="card-body p-3 pt-0">
                <table class="table table--responsive--xl">
                    <thead>
                        <tr>
                            <th>@lang('Posts')</th>
                            <th class="metric-heading metric-7days">@lang('Views in the last 7 days')</th>
                            <th class="metric-heading metric-total">@lang('All views') </th>
                            <th>@lang('Posted on')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody class="shorts-table-body">
                        @forelse ($shorts as $short)
                            <tr>
                                <td data-label="Posts">
                                    <div class="customer">
                                        <div class="customer__thumb">
                                            <img src="{{ getImage(getFilePath('coverImage') . '/' . $short->cover_image), getFileSize('coverImage') }}" alt="img">
                                        </div>
                                        <div class="customer__content">
                                            <a href="#" class="customer__name">{{ __(strLimit($short->description, 20)) }}</a>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Views 7 Days">
                                    {{ showFormatCount($short->views_last_7_days) }}
                                </td>
                                <td data-label="All Views">{{ showFormatCount($short->views_count) }}</td>
                                <td data-label="Posted on">{{ diffForHumans($short->created_at) }}</td>
                                <td data-label="Actions">
                                    <div class="action-buttons">
                                        <a href="{{ route('user.dashboard.analytics.post', $short->name) }}" class="btn btn--base view-btn">@lang('View Data ')</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">
                                <x-empty-message message="No shorts found" />
                                <td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.post__menu-btn').on('click', function (e) {
                e.preventDefault();
                var sort = $(this).data('sort');

                $('.post__menu-btn').removeClass('active');
                $(this).addClass('active');

                if (sort === 'likes') {
                    $('.metric-7days').text('@lang("Likes in the last 7 days")');
                    $('.metric-total').text('@lang("All Likes")');
                } else {
                    $('.metric-7days').text('@lang("Views in the last 7 days")');
                    $('.metric-total').text('@lang("All Views")');
                }

                $.ajax({
                    url: "{{ route('user.dashboard.analytics.content') }}",
                    method: "GET",
                    data: { sort: sort },
                    beforeSend: function () {
                        $('.shorts-table-body').html('<tr><td colspan="100%" class="text-center">Loading...</td></tr>');
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.shorts-table-body').empty();

                            if (response.shorts.length === 0) {
                                $('.shorts-table-body').append(
                                    '<tr><td colspan="100%" class="text-center">@lang("No posts found")</td></tr>'
                                );
                            } else {
                                response.shorts.forEach(function (short) {
                                    var row = `
                                        <tr>
                                            <td data-label="Posts">
                                                <div class="customer">
                                                    <div class="customer__thumb">
                                                        <img src="${short.cover_image}" alt="img">
                                                    </div>
                                                    <div class="customer__content">
                                                        <h6 class="title">${short.description}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="${sort === 'likes' ? 'Likes 7 Days' : 'Views 7 Days'}">
                                                ${sort === 'likes' ? short.likes_last_7_days : short.views_last_7_days}
                                            </td>
                                            <td data-label="${sort === 'likes' ? 'All Likes' : 'All Views'}">
                                                ${sort === 'likes' ? short.likes_count : short.views_count}
                                            </td>
                                            <td data-label="Posted on">${short.created_at}</td>
                                            <td data-label="Actions">
                                                <div class="action-buttons">
                                                    <a href="${short.analytics_url}" class="btn btn--base view-btn">@lang('View Data')</a>
                                                </div>
                                            </td>
                                        </tr>
                                    `;
                                    $('.shorts-table-body').append(row);
                                });
                            }
                        } else {
                            notify('error', 'Failed to load posts');
                        }
                    }
                });
            })
        })(jQuery);
    </script>
@endpush