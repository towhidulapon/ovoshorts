@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-admin.ui.card class="table-has-filter">
                <x-admin.ui.card.body :paddingZero="true">
                    <x-admin.ui.table.layout :renderExportButton="false">
                        <x-admin.ui.table>
                            <x-admin.ui.table.header>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-admin.ui.table.header>
                            <x-admin.ui.table.body>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + $categories->firstItem() }}</td>
                                        <td>
                                            <span>{{ __($category->name) }}</span>
                                        </td>
                                        <td>
                                            <x-admin.other.status_switch :status="$category->status" :action="route('admin.category.status', $category->id)" title="Category" />
                                        </td>
                                        <td>
                                            <x-admin.ui.btn.edit tag="btn" data-category="{{ json_encode($category) }}" />
                                        </td>
                                    </tr>
                                @empty
                                    <x-admin.ui.table.empty_message />
                                @endforelse
                            </x-admin.ui.table.body>
                        </x-admin.ui.table>
                        @if ($categories->hasPages())
                            <x-admin.ui.table.footer>
                                {{ paginateLinks($categories) }}
                            </x-admin.ui.table.footer>
                        @endif
                    </x-admin.ui.table.layout>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>

    <x-admin.ui.modal id="categoryModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Add New Category')</h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Category Name')</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="@lang('Enter category name')" required>
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
    <button type="button" data-bs-toggle="modal" data-bs-target="#categoryModal" class="btn btn--primary addCategoryBtn">
        <i class="las la-plus"></i> @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            const $modal = $('#categoryModal');
            const $form = $modal.find('form');

            $('.addCategoryBtn').on('click', function () {
                $modal.find('.modal-title').text("@lang('Add New Category')");
                $form.trigger('reset');
                $form.attr('action', "{{ route('admin.category.save') }}");
                $modal.modal('show');
            })

            $('.edit-btn').on('click', function () {
                const category = $(this).data('category');
                const action = "{{route('admin.category.save', ':id')}}";

                $modal.find('.modal-title').text("@lang('Edit Category')");
                $form.trigger('reset');
                $modal.find('input[name="name"]').val(category.name);
                $form.attr('action', action.replace(':id', category.id));
                $modal.modal('show');
            })

        })(jQuery);
    </script>
@endpush