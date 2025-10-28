@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')

    <div class="dashboard-body">
        @include('Template::user.dashboard.home')
    </div>

@endsection