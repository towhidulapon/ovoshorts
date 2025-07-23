@extends($activeTemplate . 'layouts.app')
@section('app-content')
    @stack('fbComment')

    <div class="home-fluid">
        <div class="home__inner">
            @include('Template::partials.sidebar')
            @yield('content')
        </div>
    </div>
@endsection