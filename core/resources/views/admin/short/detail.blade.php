@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-lg-4 col-md-6">
            <x-admin.ui.card>
                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Shorts Information')</h4>
                </x-admin.ui.card.header>
                <x-admin.ui.card.body>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Date')</span>
                            <span class="fs-14">{{ showDateTime($short->created_at) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Username')</span>
                            <span class="fs-14">
                                <a href="{{ route('admin.users.detail', $short->user_id) }}"><span>@</span>{{ @$short->user->username }}</a>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Name')</span>
                            <span class="fs-14 text--primary">{{ ($short->name) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Description')</span>
                            <span class="fs-14 text--primary">{{ ($short->description) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Category')</span>
                            <span class="fs-14 text--primary">{{ ($short->category->name) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Storage')</span>
                            <span class="fs-14 text--warning">{{ ($short->storage_driver) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Comment Allow')</span>
                            <span class="fs-14 text--success">{{ ($short->allow_comments == Status::YES ? 'Yes' : 'No') }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Privacy')</span>
                            @if ($short->is_visible == Status::EVERYONE)
                                <span class="fs-14 text--success">@lang('Everyone')</span>
                            @else
                                <span class="fs-14 text--danger">@lang('Only Me')</span>
                            @endif
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            <span class="fs-14 text-muted">@lang('Status')</span>
                            <span class="text-end">
                                @php echo $short->statusBadge @endphp
                            </span>
                        </li>

                        @if ($short->admin_feedback)
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                <span class="fs-14 fw-500">@lang('Admin Response')</span>
                                <p class="fs-14">{{ $short->admin_feedback }}</p>
                            </li>
                        @endif
                    </ul>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>

        @if ($short->is_approved !== Status::SHORT_REJECT)
            <div class="col-lg-8 col-md-6">
                <x-admin.ui.card>
                    <x-admin.ui.card.header>
                        <h4 class="card-title">@lang('Uploaded Short')</h4>
                    </x-admin.ui.card.header>
                    <x-admin.ui.card.body>
                        @if ($url != null)
                            <div class="mt-3">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $url }}" allowfullscreen></iframe>
                                </div>
                            </div>
                        @endif
                        @if ($short->status == Status::SHORT_PENDING)
                            <div class="mt-3 d-flex gap-2 flex-wrap">
                                <button class="btn btn-outline--success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="las la-check-double"></i> @lang('Approve')
                                </button>
                                <button class="btn btn-outline--danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="las la-ban"></i> @lang('Reject')
                                </button>
                            </div>
                        @endif
                    </x-admin.ui.card.body>
                </x-admin.ui.card>

            </div>
        @endif
    </div>


    <x-admin.ui.modal id="approveModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Short Approval Confirmation')</h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form action="{{ route('admin.short.approve', $short->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="details" class="form-control" value="{{ old('details') }}" rows="3" placeholder="@lang('Type your message here ...')" required></textarea>
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>

    <x-admin.ui.modal id="rejectModal">
        <x-admin.ui.modal.header>
            <h1 class="modal-title">@lang('Short Rejection Confirmation')</h1>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-admin.ui.modal.header>
        <x-admin.ui.modal.body>
            <form action="{{ route('admin.short.reject', $short->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>@lang('Reason of Rejection')</label>
                    <textarea name="details" class="form-control" rows="3" value="{{ old('details') }}" required></textarea>
                </div>
                <div class="form-group">
                    <x-admin.ui.btn.modal />
                </div>
            </form>
        </x-admin.ui.modal.body>
    </x-admin.ui.modal>
@endsection