@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">
        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>
            <div class="container py-3">
                <div class="row">
                    <div class="col-md-12">
                        @php
    echo $policy->data_values->details;
                        @endphp
                    </div>
                </div>
            </div>
    </section>
@endsection
