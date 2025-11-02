@extends($activeTemplate . 'layouts.dashboard_frontend')

@section('content')
<div class="dashboard-body">

    <section class="account position-relative bg-img" >
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 align-items-center justify-content-center">
                    <div class="col-lg-8">
                        <div class="card custom--card">
                            <div class="card-body">
                                <h3 class="text-center">@lang('KYC Form')</h3>
                                <div class="login-form__wrapper">
                                    <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                                        @csrf
        
                                        <x-ovo-form identifier="act" identifierValue="kyc" />
        
                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>

    </section>



</div>
@endsection