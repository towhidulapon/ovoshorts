@extends('admin.layouts.app')
@section('panel')
    @if (request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.method'))
        @include('admin.deposit.widget')
    @endif
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card class="table-has-filter">
                <x-admin.ui.card.body :paddingZero="true">
                    <x-admin.ui.table.layout searchPlaceholder="Username / TRX" filterBoxLocation="deposit.filter_form" :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Gateway | Transaction')</th>
                                    <th>@lang('Initiated')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Conversion')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($recharges as $recharge)
                                    <tr>
                                        <td>
                                            <x-admin.other.user_info :user="$recharge->user" />
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold">
                                                    <a href="{{ appendQuery('method', $recharge->method_code < 5000 ? @$recharge->gateway->alias : $recharge->method_code) }}">
                                                        @if ($recharge->method_code < 5000)
                                                            {{ __(@$recharge->gateway->name) }}
                                                        @else
                                                            @lang('Google Pay')
                                                        @endif
                                                    </a>
                                                </span>
                                                <br>
                                                <small> {{ $recharge->trx }} </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ showDateTime($recharge->created_at) }}<br>{{ diffForHumans($recharge->created_at) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ showAmount($recharge->amount) }} + <span class="text--danger" title="@lang('charge')">{{ showAmount($recharge->charge) }} </span>
                                                <br>
                                                <strong title="@lang('Amount with charge')">
                                                    {{ showAmount($recharge->amount + $recharge->charge) }}
                                                </strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ showAmount(1) }} =
                                                {{ showAmount($recharge->rate, currencyFormat: false) }}
                                                {{ __($recharge->method_currency) }}
                                                <br>
                                                <strong>{{ showAmount($recharge->final_amount, currencyFormat: false) }}
                                                    {{ __($recharge->method_currency) }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @php echo $recharge->statusBadge @endphp
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.star.recharge.details', $recharge->id) }}" class="btn  btn-outline--primary ms-1 table-action-btn">
                                                <i class="las la-info-circle"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($recharges->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($recharges) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection