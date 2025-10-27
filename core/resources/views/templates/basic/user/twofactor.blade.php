@extends($activeTemplate . 'layouts.app')
@section('app-content')

    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">

        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>

        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-center gy-4">

                    @if(!auth()->user()->ts)

                        <div class="col-md-6">
                            <div class="account-form__wrapper d-flex justify-content-center pb-4">
                                <div class="account-form col-12 p-4">
                                    <h3 class="text-center mb-4">@lang('Add Your Account')</h3>

                                    <h6 class="mb-3 text-center">
                                        @lang('Use the QR code or setup key on your Google Authenticator app to add your account.')
                                    </h6>

                                    <div class="form-group text-center mb-4">
                                        <img class="mx-auto" src="{{ $qrCodeUrl }}" alt="QR">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">@lang('Setup Key')</label>
                                        <div class="input-group">
                                            <input type="text" name="key" value="{{ $secret }}" class="form-control form--control referralURL" readonly>
                                            <button type="button" class="input-group-text copytext" id="copyBoard">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="d-block"><i class="fas fa-info-circle"></i> @lang('Help')</label>
                                        <p class="small text-muted">
                                            @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                                            <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('Download')</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">

                        @if(auth()->user()->ts)

                            <div class="account-form__wrapper d-flex justify-content-center pb-4">
                                <div class="account-form col-8 p-4">
                                    <h3 class="text-center mb-4">@lang('Disable 2FA Security')</h3>

                                    <form action="{{ route('user.twofactor.disable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $secret }}">

                                        <div class="form-group mb-3">
                                            <label class="form-label">@lang('Google Authenticator OTP')</label>
                                            <input type="text" class="form-control form--control" name="code" required>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else

                            <div class="account-form__wrapper d-flex justify-content-center pb-4">
                                <div class="account-form col-8 p-4">
                                    <h3 class="text-center mb-4">@lang('Enable 2FA Security')</h3>

                                    <form action="{{ route('user.twofactor.enable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $secret }}">

                                        <div class="form-group mb-3">
                                            <label class="form-label">@lang('Google Authenticator OTP')</label>
                                            <input type="text" class="form-control form--control" name="code" required>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('style')
    <style>
        .copied::after {
            background-color: #{{ gs('base_color') }};
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#copyBoard').on('click', function () {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush