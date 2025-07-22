@extends($activeTemplate . 'layouts.app')
@section('app-content')
    @stack('fbComment')

    @if (Route::is('user.short.upload.*'))
        <div class="dashboard position-relative">
            <div class="dashboard__inner flex-wrap">
                @include('Template::partials.dashboard_sidebar')
                <div class="dashboard__right">
                    @include('Template::partials.dashboard_header')
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <div class="home-fluid">
            <div class="home__inner">
                @include('Template::partials.sidebar')
                @yield('content')
            </div>
        </div>
    @endif
@endsection