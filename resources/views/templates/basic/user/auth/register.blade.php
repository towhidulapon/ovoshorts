@extends($activeTemplate . 'layouts.app')
@section('app-content')
    @if (gs('registration'))
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
                                        <h3 class="account-form__title mb-2 text-center">@lang('Register to') {{ gs('site_name') }}</h3>
                                    </div>
                                    <ul class="nav nav-pills mb-3 custom--tab" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                                aria-selected="false">@lang('Information')</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                                aria-selected="false">@lang('Other')</button>
                                        </li>
                                    </ul>
                                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                        <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                                            @csrf
                                            <div class="row">
                                                @if (session()->get('reference') != null)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                                            <input type="text" name="referBy" id="referenceBy" class="form-control form--control" value="{{ session()->get('reference') }}" readonly>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-md-6 form-group">
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
                                                        <input class="input-group-custom__input form-control form--control" type="text" placeholder="First Name" name="firstname" value="{{ old('firstname') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
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
                                                        <input class="input-group-custom__input form-control form--control" type="text" placeholder="Last Name" name="lastname" value="{{ old('lastname') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <div class="input-group-custom">
                                                        <span class="input-group-custom__icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M3.25 6.75C3.25 5.09315 4.59315 3.75 6.25 3.75H17.75C19.4069 3.75 20.75 5.09315 20.75 6.75V17.25C20.75 18.9069 19.4069 20.25 17.75 20.25H6.25C4.59315 20.25 3.25 18.9069 3.25 17.25V6.75ZM6.25 5.25C5.42157 5.25 4.75 5.92157 4.75 6.75V17.25C4.75 18.0784 5.42157 18.75 6.25 18.75H17.75C18.5784 18.75 19.25 18.0784 19.25 17.25V6.75C19.25 5.92157 18.5784 5.25 17.75 5.25H6.25ZM6.25 7.5L12 11.25L17.75 7.5L16.75 6L12 9.75L7.25 6L6.25 7.5Z"
                                                                    fill="Hsl(var(--primary))" />
                                                            </svg>
                                                        </span>
                                                        <input class="input-group-custom__input form-control form--control checkUser" type="email" placeholder="someone@example.com" name="email"
                                                            value="{{ old('email') }}" required>
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
                                                        <x-strong-password />
                                                        <span class="password-show-hide fas toggle-password fa-eye-slash" id="#password"></span>
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
                                                        <input class="input-group-custom__input form-control form--control" type="password" placeholder="Confirm Password" name="password_confirmation" required>
                                                        <span class="password-show-hide fas toggle-password fa-eye-slash" id="#password_confirmation"></span>
                                                    </div>
                                                </div>
                                                <x-captcha />


                                                @if (gs('agree'))
                                                    @php
                                                        $policyPages = getContent('policy_pages.element', false, orderById: true);
                                                    @endphp
                                                    <div class="form-group">
                                                        <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                                        <label for="agree">@lang('I agree with')</label> <span>
                                                            @foreach ($policyPages as $policy)
                                                                <a href="{{ route('policy.pages', $policy->slug) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                @endif

                                                <div class="col-sm-12">
                                                    <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Sign Up')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                        @include($activeTemplate . 'partials.social_login')
                                    </div>
                                </div>
                                <div class="have-account text-center">
                                    <p class="have-account__text">@lang('Already have an Account?') <a href="{{ route('user.login') }}" class="have-account__link text--base fw-700">@lang('Sign In')</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        @include($activeTemplate . 'partials.registration_disabled')
    @endif

@endsection
@if (gs('registration'))
    @push('script')
        <script>
            "use strict";
            (function($) {

                $('.checkUser').on('focusout', function(e) {
                    var url = "{{ route('user.checkUser') }}";
                    var value = $(this).val();
                    var token = '{{ csrf_token() }}';

                    var data = {
                        email: value,
                        _token: token
                    }

                    $.post(url, data, function(response) {
                        if (response.data == true) {
                            $(".exists-error").html(`
                                @lang('You’re already part of our community!')
                                <a class="ms-1" href="{{ route('user.login') }}">@lang('Login now')</a>
                            `).removeClass('d-none').addClass("text-danger mt-1 d-block");
                            $(`button[type=submit]`).attr('disabled', true).addClass('disabled');
                        } else {
                            $(".exists-error").empty().addClass('d-none').removeClass(
                                "text-danger mt-1 d-block");
                            $(`button[type=submit]`).attr('disabled', false).removeClass('disabled');
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endif
