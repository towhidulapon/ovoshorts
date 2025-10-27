@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">

        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>

        <div class="account-inner">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="account-form__wrapper">
                            <div class="account-form p-4">

                                <h5 class="text-center mb-3">@lang('Withdraw Via') {{ $withdraw->method->name }}</h5>

                                <div class="alert alert--primary">
                                    <p class="mb-0">
                                        <i class="las la-info-circle"></i>
                                        @lang('You are requesting') <b>{{ showAmount($withdraw->amount) }}</b> @lang('for withdraw.')
                                        @lang('The admin will send you')
                                        <b class="text--success">{{ showAmount($withdraw->final_amount, currencyFormat: false) . ' ' . $withdraw->currency }}</b>
                                        @lang('to your account.')
                                    </p>
                                </div>

                                <form action="{{ route('user.withdraw.submit') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        @php
                                            echo $withdraw->method->description;
                                        @endphp
                                    </div>

                                    <x-ovo-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}" />

                                    @if(auth()->user()->ts)
                                        <div class="form-group mb-3">
                                            <label class="form-label">@lang('Google Authenticator Code')</label>
                                            <input type="text" name="authenticator_code" class="form-control form--control" required>
                                        </div>
                                    @endif

                                    <div class="form-group">
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