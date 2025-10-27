@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card class="table-has-filter">
                <x-admin.ui.card.body :paddingZero="true">
                    <x-admin.ui.table.layout renderTableFilter="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('Stars')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($stars as $star)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $star->stars }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($star->price) }}</span>
                                        </td>
                                        <td>
                                            <x-admin.other.status_switch :status="$star->status" :action="route('admin.star.status', $star->id)" title="Star" />
                                        </td>
                                        <td>
                                            <x-admin.ui.btn.edit tag="btn" data-star="{{ json_encode($star) }}" :href="route('admin.star.save', $star->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($stars->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($stars) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>

    <x-admin.ui.modal id="starModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Add New Star')</h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Stars')</label>
                    <input type="number" name="stars" class="form-control" required placeholder="@lang('Enter number of stars')">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Price')</label>
                    <input type="number" step="any" name="price" class="form-control" required placeholder="@lang('Enter price')">
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button type="button" data-bs-toggle="modal" data-bs-target="#starModal" class="btn btn--primary addStarBtn">
        <i class="las la-plus"></i> @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            const $modal = $('#starModal');
            const $form = $modal.find('form');

            $('.addStarBtn').on('click', function () {
                $modal.find('.modal-title').text('@lang('Add New Star Package')');
                $form.trigger('reset');
                $form.attr('action', "{{ route('admin.star.save') }}");
                $modal.modal('show');
            })

            $('.edit-btn').on('click', function () {
                const star = $(this).data('star');
                const action = "{{route('admin.star.save', ':id')}}";

                $modal.find('.modal-title').text('@lang('Edit Star Packages')');
                $form.trigger('reset');
                $modal.find('input[name="stars"]').val(star.stars);
                $modal.find('input[name="price"]').val(star.price);
                $form.attr('action', action.replace(':id', star.id));
                $modal.modal('show');
            })

        })(jQuery);
    </script>
@endpush