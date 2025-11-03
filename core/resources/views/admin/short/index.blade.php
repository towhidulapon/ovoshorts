@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card class="table-has-filter">
                <x-admin.ui.card.body :paddingZero="true">
                    <x-admin.ui.table.layout searchPlaceholder="" :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Description')</th>
                                    <th>@lang('Posted')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($shorts as $short)
                                    <tr>
                                        <td>
                                            <x-admin.other.user_info :user="$short->user" />
                                        </td>
                                        <td>
                                            {{ __($short->name) }}
                                        </td>

                                        <td>
                                            {{ __(strLimit($short->description, 20)) }}
                                        </td>

                                        <td>
                                            <div>
                                                {{ showDateTime($short->created_at) }}<br>{{ diffForHumans($short->created_at) }}
                                            </div>
                                        </td>

                                        <td>
                                            @php echo $short->statusBadge @endphp
                                        </td>
                                        <td>
                                            @if ($short->status !== Status::REJECTED)
                                                @if ($short->status == Status::PUBLISHED)
                                                    <button type="button" class="btn btn-outline--danger table-action-btn confirmationBtn" data-action="{{ route('admin.short.status', $short->id) }}" data-question="@lang('Are you sure to unpublish this short?')">
                                                        <i class="la la-eye-slash"></i> @lang('Unpublish')
                                                    </button>
                                                @elseif ($short->status == Status::UNPUBLISHED)
                                                    <button type="button" class="btn btn-outline--success table-action-btn confirmationBtn" data-action="{{ route('admin.short.status', $short->id) }}" data-question="@lang('Are you sure to publish this short?')">
                                                        <i class="la la-eye"></i> @lang('Publish')
                                                    </button>
                                                @endif
                                            @endif
                                            <a href="{{ route('admin.short.details', $short->id) }}" class="btn  btn-outline--primary ms-1 table-action-btn">
                                                <i class="las la-info-circle"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($shorts->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($shorts) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>

    <x-confirmation-modal />
@endsection