@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')
    <div class="dashboard-body">
        <div class="notice"></div>
        <div>
            @php
                $kyc = getContent('kyc.content', true);
            @endphp
            @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                <div class="alert alert--danger mb-3" role="alert">
                    <div class="alert__icon"><i class="fas fa-times-circle"></i>
                    </div>
                    <div class="alert__content">
                        <h6 class="alert__title">@lang('KYC Documents Rejected')</h6>
                        <p class="alert__desc" class="alert__desc">
                            {{ __(@$kyc->data_values->reject) }}
                            <a href="javascript::void(0)" class="alert__link" data-bs-toggle="modal"
                                data-bs-target="#kycRejectionReason">@lang('Click here')</a> @lang('to show the reason').

                            <a href="{{ route('user.kyc.form') }}" class="alert__link">@lang('Click Here')</a>
                            @lang('to Re-submit Documents').
                            <a href="{{ route('user.kyc.data') }}" class="alert__link">@lang('See KYC Data')</a>
                        </p>
                    </div>
                </div>
            @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                <div class="alert alert--info mb-3" role="alert">
                    <div class="alert__icon"><i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="alert__content">
                        <h6 class="alert__title">@lang('KYC Verification Required')</h6>
                        <p class="alert__desc">{{ __(@$kyc->data_values->required) }} <a
                                href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a>
                        </p>
                    </div>
                </div>
            @elseif(auth()->user()->kv == Status::KYC_PENDING)
                <div class="alert alert--warning mb-3" role="alert">
                    <div class="alert__icon"><i class="las la-hourglass-half"></i>
                    </div>
                    <div class="alert__content">
                        <h6 class="alert__title">@lang('KYC Verification Pending')</h6>
                        <p class="alert__desc">{{ __(@$kyc->data_values->pending) }} <a
                                href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                        </p>
                    </div>

                </div>
            @endif
        </div>
        @include('Template::user.dashboard.home')
    </div>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal custom--modal fade" id="kycRejectionReason">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
