@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="account-form__wrapper d-flex justify-content-center pb-4">
                <div class="account-form col-12 p-4">
                    <h3 class="text-center mb-4">@lang('Change Password')</h3>

                    <form method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">@lang('Current Password')</label>
                            <input type="password" class="form-control form--control" name="current_password" required autocomplete="current-password">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">@lang('Password')</label>
                            <input type="password" class="form-control form--control @gs('secure_password') secure-password @endgs" name="password" required autocomplete="current-password">
                            <x-strong-password />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">@lang('Confirm Password')</label>
                            <input type="password" class="form-control form--control" name="password_confirmation" required autocomplete="current-password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@push('style')
    <style>
        label.required:after {
            content: '*';
            color: hsl(var(--danger));
            margin-left: 2px;
        }
    </style>
@endpush

@gs('secure_password')
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@endgs