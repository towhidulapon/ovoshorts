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
                        <h3 class="mt-4 text-center">@lang('Reset Password')</h3>
                        <div class="login-form__wrapper">
                            <div class="mb-4 text-center">
                                <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.update') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="form-label">@lang('Password')</label>
                                        <input type="password" class="form-control form--control @gs('secure_password') secure-password @endgs" name="password" required>
                                        <x-strong-password />
                                    </div>
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="form-label">@lang('Confirm Password')</label>
                                        <input type="password" class="form-control form--control" name="password_confirmation" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
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

@gs('secure_password')
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@endgs