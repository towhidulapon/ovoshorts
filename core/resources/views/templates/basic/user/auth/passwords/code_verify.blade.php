@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">
        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 align-items-center justify-content-center">
                    <div class="account-form__wrapper d-flex justify-content-center pb-4">
                        <div class="account-form col-6">
                            <h3 class="mt-4 text-center">@lang('Verify Email Address')</h3>
                            <div class="login-form__wrapper">
                                <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                    @csrf
                                    <p class="verification-text text-center mb-3">
                                        @lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}
                                    </p>
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    @include($activeTemplate . 'partials.verification_code')
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
                                    <div class="form-group text-center">
                                        @lang('Please check including your Junk/Spam Folder. If not found, you can')
                                        <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                    </div>
                                </form>
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
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on("input", "input[name='code']", function () {
                    let otp = $(this).val();
                    if (otp.length === 6) {
                        $(this).closest("form").submit();
                    }
                });
            });
        })(jQuery);
    </script>
@endpush