@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">
        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>
        <div class="account-inner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="account-form__wrapper d-flex justify-content-center pb-4">
                            <div class="account-form col-12 p-4 text-center">
                                <h3 class="text--danger mb-3">@lang('You are banned')</h3>

                                <div class="ban-reason mt-3">
                                    <p class="fw-bold mb-1">@lang('Reason'):</p>
                                    <p class="text-muted">{{ $user->ban_reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection