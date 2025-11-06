@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')
    <div class="dashboard-body">

        <div class="dashboard-action-header flex-wrap gap-2">

            <div class="input-group custom--search">
                <input type="search" name="search" class="form-control form--control" value="{{ request()->search }}"
                    placeholder="@lang('Search for post description')">
                <button class="input-group-text">
                    <i class="las la-search"></i>
                </button>
            </div>


            <div class="filters-wrapper">
                <div class="common-filter">
                    <button class="filter-btn">
                        <!-- SVG unchanged -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <g clip-path="url(#clip0_2116_1041)">
                                <path d="M3.3335 5H16.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5.8335 10H14.1668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.3335 15H11.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2116_1041">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg> @lang('Views')
                    </button>
                    <div class="common-filter__dropdown">
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" id="views-1k" type="radio" name="views-sort"
                                    value="views-desc">
                                <label class="form-check-label" for="views-1k">@lang('Most > Least')</label>
                            </div>
                        </div>
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="views-sort"
                                    value="views-asc" id="views-1k-10k">
                                <label class="form-check-label" for="views-1k-10k">@lang('Least > Most')</label>
                            </div>
                        </div>
                        <div class="privacy-actions">
                            <button class="clear-btn btn btn--danger btn--sm w-100">@lang('Clear')</button>
                        </div>
                    </div>
                </div>

                <div class="common-filter">
                    <button class="filter-btn">
                        <!-- SVG unchanged -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <g clip-path="url(#clip0_2116_1041)">
                                <path d="M3.3335 5H16.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5.8335 10H14.1668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.3335 15H11.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2116_1041">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg> @lang('Likes')
                    </button>
                    <div class="common-filter__dropdown">
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="likes-sort"
                                    value="likes-desc" id="likes-1k">
                                <label class="form-check-label" for="likes-1k">@lang('Most > Least')</label>
                            </div>
                        </div>
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="likes-sort"
                                    value="likes-asc" id="likes-1">
                                <label class="form-check-label" for="likes-1">@lang('Least > Most')</label>
                            </div>
                        </div>
                        <div class="privacy-actions">
                            <button class="clear-btn btn btn--danger btn--sm w-100">@lang('Clear')</button>
                        </div>
                    </div>
                </div>

                <div class="common-filter">
                    <button class="filter-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <g clip-path="url(#clip0_2116_1041)">
                                <path d="M3.3335 5H16.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5.8335 10H14.1668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.3335 15H11.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2116_1041">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg> @lang('Comments')
                    </button>
                    <div class="common-filter__dropdown">
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="comments-sort"
                                    value="comments-desc" id="comments-views">
                                <label class="form-check-label" for="comments-views">@lang('Most > Least')</label>
                            </div>
                        </div>
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="comments-sort"
                                    value="comments-asc" id="comments-comment1">
                                <label class="form-check-label" for="comments-comment1">@lang('Least > Most')</label>
                            </div>
                        </div>
                        <div class="privacy-actions">
                            <button class="clear-btn btn btn--danger btn--sm w-100">@lang('Clear')</button>
                        </div>
                    </div>
                </div>

                <div class="common-filter">
                    <button class="filter-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <g clip-path="url(#clip0_2116_1041)">
                                <path d="M3.3335 5H16.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5.8335 10H14.1668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.3335 15H11.6668" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2116_1041">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg> @lang('Privacy')
                    </button>
                    <div class="common-filter__dropdown">
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="privacy-sort"
                                    value="privacy-asc" id="privacy-views">
                                <label class="form-check-label" for="privacy-views">@lang('Everyone')</label>
                            </div>
                        </div>
                        <div class="common-filter__dropdown-item">
                            <div class="form--check">
                                <input class="form-check-input sort-filter" type="radio" name="privacy-sort"
                                    value="privacy-desc" id="privacy-comment2">
                                <label class="form-check-label" for="privacy-comment2">@lang('Only Me')</label>
                            </div>
                        </div>
                        <div class="privacy-actions">
                            <button class="clear-btn btn btn--danger btn--sm w-100">@lang('Clear')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom--card mt-4">
            <div class="card-body">
                <table class="table table--responsive--xl post-table">
                    <thead>
                        <tr>
                            <th>@lang('Post (Created on)')</th>
                            <th>@lang('Privacy')</th>
                            <th>@lang('Views')</th>
                            <th>@lang('Likes')</th>
                            <th>@lang('Comments')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('Template::user.dashboard.post_table', ['shorts' => $shorts])
                    </tbody>
                </table>
            </div>
            @if($shorts->hasPages())
                <div class="card-footer">
                    {{ paginateLinks($shorts) }}
                </div>
            @endif
        </div>
    </div>
    <x-confirmation-modal isFrontend="true" />
@endsection



@push('script')
    <script>
        (function($) {
            "use strict";

            $('.sort-filter').on('change', function() {
                var value = $(this).val();
                var data = {};

                if (value === 'privacy-2') {
                    data = {
                        privacy: 2
                    };
                } else {
                    var [sort, order] = value.split('-');
                    data = {
                        sort: sort,
                        order: order
                    };
                }

                $.ajax({
                    url: '{{ route('user.dashboard.post') }}',
                    type: 'GET',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            $('.post-table tbody').html(response.data);
                        }
                    }
                });
            });

            $('.clear-btn').on('click', function() {
                $('.sort-filter').prop('checked', false);
                $.ajax({
                    url: '{{ route('user.dashboard.post') }}',
                    type: 'GET',
                    data: {
                        sort: 'id',
                        order: 'desc'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.post-table tbody').html(response.data);
                            $('.common-filter__dropdown').removeClass('active');
                        }
                    }
                });
            });

            $(document).on('click', '.pin-btn', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var dataUrl = $btn.data('action');
                $.ajax({
                    url: dataUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.post-table tbody').html(response.view);
                            notify('success', response.message);
                        }
                    }
                });
            });

            $(document).on('click', '.unpin-btn', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var dataUrl = $btn.data('action');
                $.ajax({
                    url: dataUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.post-table tbody').html(response.view);
                            notify('success', response.message);
                        }
                    }
                });
            });


            $(document).on('click', '.dropdown-item[data-value]', function() {
                var postId = $(this).closest('tr').data('post-id');
                var privacy = $(this).data('value');
                var $dropdownBtn = $(this).closest('.message-item__dropdown').find('.dropdown-btn');

                $.ajax({
                    url: '{{ route('user.dashboard.update.privacy') }}',
                    type: 'POST',
                    data: {
                        post_id: postId,
                        privacy: privacy,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.data.success) {
                            $dropdownBtn.html(`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.06444 17.0712C8.68094 17.2395 9.32994 17.3294 9.99985 17.3294C10.5759 17.3294 11.1364 17.2629 11.6742 17.1372C11.9421 16.6337 12.0645 16.2357 12.1084 15.9183C12.1679 15.4878 12.0899 15.1595 11.9654 14.8545C11.9027 14.7012 11.8167 14.5312 11.7349 14.3693C11.6524 14.2063 11.5554 14.0134 11.4834 13.8111C11.3243 13.3643 11.2827 12.8569 11.5812 12.2849C11.7986 11.8682 12.1138 11.626 12.4914 11.5068C12.7811 11.4155 13.1834 11.3985 13.4388 11.3877C14.0009 11.3621 14.6126 11.3157 15.3634 10.7761C16.0338 10.2943 16.7078 10.159 17.326 10.2231C17.3283 10.1489 17.3294 10.0745 17.3294 9.99982C17.3294 8.33048 16.7713 6.79146 15.8315 5.55919C15.4158 5.71309 15.0114 5.97196 14.6927 6.3844C14.0154 7.26105 13.2891 7.80035 12.5524 8.01716C11.8014 8.23814 11.0927 8.10666 10.5264 7.7402C9.68802 7.19757 9.57969 6.43919 9.50877 5.94259C9.4701 5.6831 9.42327 5.44019 9.35352 5.31115C9.29535 5.20364 9.18977 5.0749 8.9271 4.94738C8.26663 4.62681 7.89234 4.04056 7.7625 3.40897C7.73719 3.2858 7.72091 3.16045 7.71327 3.034C5.04164 3.91045 3.04724 6.28102 2.71815 9.15765C3.16838 9.42074 3.68385 9.59824 4.24045 9.59824C4.79555 9.59824 5.2739 9.62424 5.67569 9.69949C6.07839 9.7749 6.4483 9.90765 6.74868 10.1537C7.37386 10.6656 7.46515 11.4677 7.46515 12.2929C7.46515 13.1421 7.46684 13.4996 7.51243 13.8045C7.55611 14.0966 7.64105 14.3469 7.86354 14.9846C7.99197 15.3527 8.1703 15.8752 8.16011 16.4386C8.1563 16.6492 8.12655 16.8612 8.06444 17.0712ZM1.04246 9.86732C1.04182 9.9114 1.0415 9.95557 1.0415 9.99982C1.0415 14.9474 5.05229 18.9582 9.99985 18.9582C10.6586 18.9582 11.3007 18.8871 11.9189 18.7522L11.9344 18.749C15.554 17.9522 18.352 14.9682 18.8719 11.2517C18.8733 11.2424 18.8744 11.2332 18.8752 11.224C18.9299 10.8237 18.9582 10.4151 18.9582 9.99982C18.9582 5.05229 14.9474 1.0415 9.99985 1.0415C9.96227 1.0415 9.92469 1.04174 9.88727 1.0422C5.03571 1.10194 1.11277 5.01832 1.04246 9.86732Z" fill="CurrentColor" /></svg>
                            ${response.data.new_privacy_label}
                            <i class="las la-angle-down"></i>`);
                            $('input[name="privacy-sort"]').prop('checked', false);

                            var $dropdownMenu = $dropdownBtn.siblings('.dropdown-menu');
                            $dropdownMenu.empty();

                            if (response.data.new_privacy_value == 1) {
                                $dropdownMenu.append(
                                    `<button class="dropdown-item" data-value="2">Only Me</button>`
                                );
                            } else {
                                $dropdownMenu.append(
                                    `<button class="dropdown-item" data-value="1">Everyone</button>`
                                );
                            }
                            notify('success', 'Privacy updated successfully');
                        }
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
