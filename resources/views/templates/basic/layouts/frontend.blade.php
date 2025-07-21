@extends($activeTemplate . 'layouts.app')
@section('app-content')
    @stack('fbComment')
    {{-- @include('Template::partials.header') --}}

    <div class="home-fluid">
        <div class="home__inner">
            @include('Template::partials.sidebar')
            @yield('content')
        </div>
    </div>

    {{-- @include('Template::partials.footer') --}}
@endsection
