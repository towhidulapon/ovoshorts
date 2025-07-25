@extends('admin.layouts.app')
@section('panel')
    <div class="row responsive-row">
        <div class="form-group col-md-12">
            <div class="alert alert--danger p-3">
                @lang('Please Remember, Be very careful about changing storage or changing FTP host, Because if you change setting, make sure you copy all image and file directory of uploaded photos to your new FTP or LOCAL storage. Otherwise photos won\'t be shown to the site. e.g: Change LOCAL To FTP, then copy all your directory of shorts ("images" and "videos") to your FTP directory and FTP to LOCAL ( assets/shorts)')
            </div>
        </div>
        @foreach ($storages as $storage)
            <div class="col-xxl-4  col-xl-6 col-md-6">
                <x-admin.ui.card class="h-100">
                    <x-admin.ui.card.body class="position-relative">
                        <div class="storage-status">
                            @php echo $storage->statusBadge; @endphp
                        </div>
                        <div class="flex-thumb-wrapper mb-3  align-items-center">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('storage') . '/' . $storage->image, getFileSize('storage')) }}" class="thumb-img">
                            </div>
                            <span class="ms-2">{{ __($storage->name) }}</span>
                        </div>
                        <div class="mb-3">
                            <p>{{ __($storage->info) }}</p>
                        </div>
                        <div class="btn--group">
                            <button type="button" class="flex-sm--fill btn  btn-outline--primary  editBtn" data-name="{{ __($storage->name) }}" data-parameters="{{ json_encode($storage->parameters) }}"
                                data-action="{{ route('admin.storage.update', $storage->id) }}">
                                <span class=" btn--icon"><i class="la la-tools"></i></span>@lang('Configure')
                            </button>
                            @if ($storage->status == Status::DISABLE)
                                <button type="button" class="flex-sm--fill btn  btn-outline--success  confirmationBtn" data-action="{{ route('admin.storage.status', $storage->id) }}" data-question="@lang('Are you sure to enable this storage?')">
                                    <span class="btn--icon"><i class="la la-eye"></i></span>@lang('Enable')
                                </button>
                            @else
                                <button type="button" class="flex-sm--fill btn  btn-outline--danger  confirmationBtn" data-action="{{ route('admin.storage.status', $storage->id) }}" data-question="@lang('Are you sure to disable this storage?')">
                                    <span class="btn--icon"><i class="la la-eye-slash"></i></span>@lang('Disable')
                                </button>
                            @endif
                        </div>
                    </x-admin.ui.card.body>
                </x-admin.ui.card>
            </div>
        @endforeach
    </div>

    <x-admin.ui.modal id="editModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Update Storage Setting'): <span class="storage-name"></span></h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form method="POST">
                @csrf
                <div class="ext-config">
                    <div class="form-group">
                        <label class="form-label">@lang('Script')</label>
                        <textarea name="script" class="form-control" required rows="8" placeholder="@lang('Paste your script with proper key')">{{ old('script') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>

    <x-admin.ui.modal id="helpModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Need Help')</h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>

    <x-confirmation-modal />
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.editBtn', function() {
                let modal = $('#editModal');
                let parameter = $(this).data('parameters');
                console.log(parameter);
                modal.find('.storage-name').text($(this).data('name'));
                modal.find('form').attr('action', $(this).data('action'));

                let html = '';
                $.each(parameter, function(key, item) {
                    html += `<div class="form-group">
                        <label class="form-label required">${item.title}</label>
                        <input name="${key}" class="form-control" placeholder="--" value="${item.value}" required>
                        </div>`;
                })
                modal.find('.ext-config').html(html);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .flex-thumb-wrapper .thumb {
            width: 50px;
            height: 50px;
        }

        .storage-status {
            position: absolute;
            right: 16px;
            top: 16px;
        }

        @media screen and (max-width: 375px) {
            .storage-status {
                right: 5px;
                top: 2px;
            }
        }
    </style>
@endpush
