@extends($activeTemplate . 'layouts.app')

@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">

        <div class="account__header">
            <a href="{{ route('home') }}">
                <img src="{{ siteLogo() }}" alt="img">
            </a>
        </div>

        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 align-items-center justify-content-center">
                    <div class="account-form__wrapper d-flex justify-content-center pb-4">
                        <div class="account-form col-8">
                            <h3 class="mt-4 text-center">@lang('Verification Form')</h3>

                            <div class="login-form__wrapper mt-4">
                                <form action="{{ route('user.verification.apply') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <x-ovo-form identifier="act" identifierValue="verification" />

                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
                                </form>

                                <div class="text-center my-4">
                                    <span class="text-muted">@lang('OR')</span>
                                </div>

                                <form action="{{ route('user.verification.purchase') }}" class="no-submit-loader" method="POST">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ gs('verification_price') }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        @lang('Get Verified Now for') {{ showAmount(gs('verification_price')) }}
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection