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
                            <h3 class="mt-4 text-center">@lang('Verify email address')</h3>
                            <div class="login-form__wrapper">
                                <form action="{{route('user.verify.email')}}" method="POST" class="submit-form">
                                    @csrf
                                    <p class="verification-text">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}</p>

                                    @include($activeTemplate . 'partials.verification_code')

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>

                                    <div class="mb-3">
                                        <p>
                                            @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a href="{{route('user.send.verify.code', 'email')}}" class="try-again-link d-none"> @lang('Try again')</a>
                                        </p>
                                        <a href="{{ route('user.logout') }}">@lang('Logout')</a>
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
        var distance = Number("{{@$user->ver_code_send_at->addMinutes(2)->timestamp - time()}}");
        var x = setInterval(function () {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush