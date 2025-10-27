@extends('admin.layouts.app')
@section('panel')
    <div class="row  gy-4 justify-content-center">
        <div class="col-xl-4 col-md-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">
                        @lang('Paid Via') @if ($recharge->method_code < 5000)
                            {{ __(@$recharge->gateway->name) }}
                        @else
                            @lang('Google Pay')
                        @endif
                    </h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Date')</span>
                            <span class="fs-14">{{ showDateTime($recharge->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Transaction Number')</span>
                            <span class="fs-14">{{ $recharge->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Username')</span>
                            <span class="fs-14">
                                <a
                                    href="{{ route('admin.users.detail', $recharge->user_id) }}"><span>@</span>{{ @$recharge->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Method')</span>
                            <span class="fs-14">
                                @if ($recharge->method_code < 5000)
                                    {{ __(@$recharge->gateway->name) }}
                                @else
                                    @lang('Google Pay')
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Amount')</span>
                            <span class="text--info">{{ showAmount($recharge->amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Charge')</span>
                            <span class="text--warning">{{ showAmount($recharge->charge) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('After Charge')</span>
                            <span class="text--success">{{ showAmount($recharge->amount + $recharge->charge) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Rate')</span>
                            <span class="fs-14">1 {{ __(gs('cur_text')) }}
                                = {{ showAmount($recharge->rate, currencyFormat: false) }}
                                {{ __($recharge->baseCurrency()) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class=" text-muted">@lang('After Rate Conversion')</span>
                            <span class="fs-14">{{ showAmount($recharge->final_amount, currencyFormat: false) }}
                                {{ __($recharge->method_currency) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                            <span class="text-muted fs-14">@lang('Status')</span>
                            <span class="text-end">
                                @php echo $recharge->statusBadge @endphp
                            </span>
                        </li>
                        @if ($recharge->admin_feedback)
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0 flex-wrap">
                                <span class="fw-500">@lang('Admin Response')</span>
                                <span>{{ __($recharge->admin_feedback) }}</span>
                            </li>
                        @endif
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>

        </div>
        @if ($details || $recharge->status == Status::PAYMENT_PENDING)
            <div class="col-xl-8 col-md-6">
                <x-admin.ui.card class="h-100">
                    <x-admin.ui.card.header>
                        <h4 class="card-title">@lang('User Payment Information')</h4>
                    </x-admin.ui.card.header>
                    <x-admin.ui.card.body>
                        @if ($details != null)
                            @foreach (json_decode($details) as $val)
                                @if ($recharge->method_code >= 1000)
                                    <div class="mb-3">
                                        <span class="fs-13 text-muted mb-1">{{ __($val->name) }}</span>
                                        @if ($val->type == 'checkbox')
                                            {{ implode(',', $val->value) }}
                                        @elseif($val->type == 'file')
                                            @if ($val->value)
                                                <br>
                                                <a
                                                    href="{{ route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}">
                                                    <i class="fa-regular fa-file fs-16"></i> @lang('Attachment')
                                                </a>
                                            @else
                                                @lang('No File')
                                            @endif
                                        @else
                                            <p class="fs-16">{{ __($val->value) }}</p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            @if ($recharge->method_code < 1000)
                                @include('admin.deposit.gateway_data', [
                                    'details' => json_decode($details),
                                ])
                            @endif
                        @endif
                        @if ($recharge->status == Status::PAYMENT_PENDING)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button class="btn btn-outline--success   confirmationBtn"
                                        data-action="{{ route('admin.star.recharge.approve', $recharge->id) }}"
                                        data-question="@lang('Are you sure to approve this transaction?')"><i class="las la-check-double"></i>
                                        @lang('Approve')
                                    </button>
                                    <button class="btn btn-outline--danger  " data-bs-toggle="modal"
                                        data-bs-target="#rejectModal"><i class="las la-ban"></i> @lang('Reject')
                                    </button>
                                </div>
                            </div>
                        @endif
                    </x-admin.ui.card.body>
                </x-admin.ui.card>

            </div>
        @endif
    </div>

    <x-admin.ui.modal id="rejectModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Reject Payment Confirmation')</h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form action="{{ route('admin.star.recharge.reject') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $recharge->id }}">
                <p>
                    @lang('Are you sure to') <span class="fs-14">@lang('reject')</span> <span
                        class="fw-bold text--success">{{ showAmount($recharge->amount) }}</span> @lang('payment of')
                    <span class="fs-14">{{ @$recharge->user->username }}</span>?
                </p>
                <div class="form-group">
                    <label class="mt-2">@lang('Reason for Rejection')</label>
                    <textarea name="message" maxlength="255" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>

    <x-confirmation-modal />
@endsection
