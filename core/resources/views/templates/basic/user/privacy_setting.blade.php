@extends($activeTemplate . 'layouts.setting_frontend')
@section('content')

<section class="scrollspy-example bg-body-tertiary" data-bs-offset="80" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" data-bs-spy="scroll" data-bs-target="#navbar-example2" tabindex="0">
    <div class="setting-page-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="setting-body-content">
                        <div class="setting-option space-item" id="push-notification">
                            <div class="setting-option__header">
                                <h4>@lang('Push Notifications')</h4>
                            </div>
                            <div class="setting-option__wrapper">
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="sub-title fw-400">@lang('Like')</h6>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <div class="form-check form--switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="notify_likes" {{ $user->notify_likes ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="sub-title fw-400">@lang('Comments')</h6>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <div class="form-check form--switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="notify_comments" {{ $user->notify_comments ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="sub-title fw-400">@lang('New Followers')</h6>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <div class="form-check form--switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="notify_followers" {{ $user->notify_followers ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="sub-title fw-400">@lang('Stars')</h6>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <div class="form-check form--switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="notify_stars" {{ $user->notify_stars ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting-option space-item" id="push-notification">
                            <div class="setting-option__header">
                                <h4>@lang('Activity')</h4>
                            </div>
                            <div class="setting-option__wrapper">
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="sub-title fw-400">@lang('Activity Status')</h6>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <div class="form-check form--switch">
                                                <input class="form-check-input" type="checkbox" role="switch" name="show_activity_status" {{ $user->show_activity_status ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting-option space-item" id="ads">
                            <div class="setting-option__header">
                                <h4>Ads</h4>
                            </div>
                            <div class="setting-option__wrapper">
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="title">Manage the ads you see</h6>
                                            <h6 class="sub-title fw-400">Manage ad topics</h6>
                                            <p class="desc">change factors used to tailor the ads you see</p>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <button class="language-btn arrow-btn" type="button">
                                                <i class="las la-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="title">Mute advertisers</h6>
                                            <p class="desc">Mute ads from specific advertisers who showed you ads
                                                recently
                                                on OvoShorts.</p>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <button class="language-btn arrow-btn" type="button">
                                                <i class="las la-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-option__item-wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="title">Edit personal details</h6>
                                            <p class="desc">select the gender which may be used to tailor the ads you
                                                see.
                                            </p>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <button class="language-btn arrow-btn" type="button">
                                                <i class="las la-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
<script>
    (function($) {
        "use strict";
        $('.form-check-input').on('change', function() {
            var name = $(this).attr('name');
            var value = $(this).is(':checked') ? 1 : 0;
            var data = {
                [name]: value,
                _token: '{{ csrf_token() }}'
            };
            $.ajax({
                url: "{{ route('user.notification.save.settings') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    if (response.status == 'success') {
                        notify('success', response.message);
                    } else {
                        notify('error', response.message);
                    }
                }
            });
        });
    })(jQuery);
</script>
@endpush