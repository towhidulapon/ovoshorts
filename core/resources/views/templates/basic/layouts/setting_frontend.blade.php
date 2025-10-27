@extends($activeTemplate . 'layouts.app')
@section('app-content')
    @include('Template::partials.setting_header')
    @yield('content')
@endsection