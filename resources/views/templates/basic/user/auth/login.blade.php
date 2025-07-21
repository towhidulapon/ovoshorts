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
                        <div class="account-form login-form">
                            <div class="login-form__wrapper">
                                <div class="account-form__content">
                                    <h3 class="account-form__title mb-2 text-center">@lang('Login to') {{ gs('site_name') }}</h3>
                                </div>
                                <ul class="nav nav-pills mb-3 custom--tab" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                            aria-selected="true">@lang('QR-code')</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">@lang('Email')</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                            aria-selected="false">@lang('Other')</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                        <div class="form-qr-code text-center">
                                            <img src="{{ asset($activeTemplateTrue . 'images/qr-code.png') }}" alt="img">
                                            <ul class="form-qr-code__list">
                                                <li class="form-qr-code__item">1. @lang('Scan with your mobile device’s camera')</li>
                                                <li class="form-qr-code__item">2. @lang('Confirm login or sign up')</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                        <form action="{{ route('user.login') }}" method="POST" class="verify-gcaptcha">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <div class="input-group-custom">
                                                        <span class="input-group-custom__icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M12 3.20455C7.1424 3.20455 3.20455 7.1424 3.20455 12C3.20455 16.8576 7.1424 20.7955 12 20.7955C16.8576 20.7955 20.7955 16.8576 20.7955 12C20.7955 7.1424 16.8576 3.20455 12 3.20455ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12Z"
                                                                    fill="Hsl(var(--primary))" />
                                                                <path d="M8.5 9.5C8.5 7.567 10.067 6 12 6C13.933 6 15.5 7.567 15.5 9.5C15.5 11.433 13.933 13 12 13C10.067 13 8.5 11.433 8.5 9.5Z" fill="Hsl(var(--primary))" />
                                                                <path
                                                                    d="M5.40873 17.6472C6.43247 15.8556 8.3377 14.75 10.4011 14.75H13.5979C15.6613 14.75 17.5666 15.8556 18.5903 17.6472L19.6094 19.5928C17.6634 21.5432 14.9724 22.7499 11.9996 22.7499C9.0267 22.7499 6.33569 21.5431 4.38965 19.5928L5.40873 17.6472Z"
                                                                    fill="Hsl(var(--primary))" />
                                                            </svg>
                                                        </span>
                                                        <input class="input-group-custom__input form-control form--control" type="text" placeholder="Someone@example.com" name="username" value="{{ old('username') }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 form-group">
                                                    <div class="input-group-custom">
                                                        <span class="input-group-custom__icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M12 3.25C10.067 3.25 8.5 4.817 8.5 6.75V8.31016C9.61773 8.27048 10.7654 8.25 12 8.25C13.2346 8.25 14.3823 8.27048 15.5 8.31016V6.75C15.5 4.817 13.933 3.25 12 3.25ZM6.5 6.75V8.52712C4.93233 9.00686 3.74925 10.3861 3.52452 12.0552C3.37636 13.1556 3.25 14.3118 3.25 15.5C3.25 16.6882 3.37637 17.8444 3.52452 18.9448C3.79609 20.9618 5.46716 22.5555 7.52522 22.6501C8.95365 22.7158 10.4042 22.75 12 22.75C13.5958 22.75 15.0464 22.7158 16.4748 22.6501C18.5328 22.5555 20.2039 20.9618 20.4755 18.9448C20.6236 17.8444 20.75 16.6882 20.75 15.5C20.75 14.3118 20.6236 13.1556 20.4755 12.0552C20.2507 10.3861 19.0677 9.00686 17.5 8.52712V6.75C17.5 3.71243 15.0376 1.25 12 1.25C8.96244 1.25 6.5 3.71243 6.5 6.75ZM13 14.5C13 13.9477 12.5523 13.5 12 13.5C11.4477 13.5 11 13.9477 11 14.5V16.5C11 17.0523 11.4477 17.5 12 17.5C12.5523 17.5 13 17.0523 13 16.5V14.5Z"
                                                                    fill="Hsl(var(--primary))" />
                                                            </svg>
                                                        </span>
                                                        <input class="input-group-custom__input form-control form--control" id="password" type="password" placeholder="Password" name="password" required>
                                                        <span class="password-show-hide fas toggle-password fa-eye-slash" id="#your-password"></span>
                                                    </div>
                                                </div>

                                                <x-captcha />

                                                <div class="col-sm-12 form-group">
                                                    <div class="d-flex flex-wrap justify-content-between">
                                                        <div class="form--check">
                                                            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="remember">@lang('Remember me')</label>
                                                        </div>
                                                        <a href="{{ route('user.password.request') }}" class="forgot-password have-account__link text-white fw-700 fs-14">@lang('Forgot Password?')</a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Sign In')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                        @include($activeTemplate . 'partials.social_login')
                                    </div>
                                </div>
                            </div>
                            <div class="have-account text-center">
                                <p class="have-account__text">@lang('Don’t have an Account?') <a href="{{ route('user.register') }}" class="have-account__link text--base fw-700">@lang('Sign Up')</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
