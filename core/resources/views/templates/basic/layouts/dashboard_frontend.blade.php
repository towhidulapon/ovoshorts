@extends($activeTemplate . 'layouts.app')
@section('app-content')
    @stack('fbComment')

    <div class="dashboard position-relative">
        <div class="dashboard__inner flex-wrap">
            @include('Template::partials.dashboard_sidebar')
            <div class="dashboard__right">
                @include('Template::partials.dashboard_header')
                @yield('content')
            </div>
        </div>
    </div>

@endsection