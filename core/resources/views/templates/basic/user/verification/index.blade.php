@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')
    <div class="dashboard-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h4 class="card-title">@lang('Verification Form')</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.verification.apply') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <x-ovo-form identifier="act" identifierValue="verification" />

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                            </form>


                                <form action="{{ route('user.verification.purchase') }}" class="no-submit-loader" method="POST">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ gs('verification_price') }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        @lang('Get Verified Now for') {{ showAmount(gs('verification_price')) }}
                                    </button>
                                </form>
=========
                            <div class="text-center my-4">
                                <span class="text-muted">@lang('OR')</span>

                            </div>

                            <form action="{{ route('user.verification.purchase') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ gs('verification_price') }}">
                                <button type="submit" class="btn btn-success w-100">
                                    @lang('Get Verified Now for') {{ showAmount(gs('verification_price')) }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
