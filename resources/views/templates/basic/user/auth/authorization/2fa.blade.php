@extends($activeTemplate . 'layouts.frontend')
@section('content')
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
                                <form action="{{route('user.2fa.verify')}}" method="POST" class="submit-form">
                                    @csrf

                                    @include($activeTemplate . 'partials.verification_code')

                                    <div class="form--group">
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