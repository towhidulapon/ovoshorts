@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">
        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>
        <div class="container py-3">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-7 text-center">
                        <img class="img-fluid mx-auto mb-3" src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}" alt="image">
                        <div>@php echo $maintenance->data_values->description @endphp</div>
                    </div>
                </div>
            </div>
        </section>
@endsection
