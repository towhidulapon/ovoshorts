@extends($activeTemplate . 'layouts.app')
@section('app-content')
    <div class="home-fluid message-pages">
        <div class="home__inner">
            @include('Template::partials.sidebar')
            <div class="message-wrapper">
                @include('Template::partials.message_sidebar')
                @yield('content')
            </div>
        </div>
    </div>
@endsection