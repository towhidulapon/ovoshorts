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
                            <h3 class="mt-4 text-center">@lang('KYC Documents')</h3>
                            <div class="login-form__wrapper">
                                @if($user->kyc_data)
                                    <ul class="list-group">
                                        @foreach($user->kyc_data as $val)
                                            @continue(!$val->value)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ __($val->name) }}
                                                <span>
                                                    @if($val->type == 'checkbox')
                                                        {{ implode(',', $val->value) }}
                                                    @elseif($val->type == 'file')
                                                        <a href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}">
                                                            <i class="fa-regular fa-file"></i> @lang('Attachment')
                                                        </a>
                                                    @else
                                                        <p>{{ __($val->value) }}</p>
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <x-empty-message message="KYC data not found" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
