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
                        <div class="account-form">
                            <h3 class="mt-4 text-center">@lang('Recover Account')</h3>
                            <div class="login-form__wrapper">
                                <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
                                    @csrf
                                    <div class="mb-4 text-center">
                                        <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">@lang('Email or Username')</label>
                                        <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                                    </div>
                                    <x-captcha />
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
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