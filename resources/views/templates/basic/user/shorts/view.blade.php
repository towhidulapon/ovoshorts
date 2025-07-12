@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container text-center">
        <h2 class="mb-4">View Image</h2>
        <img src="{{ $url }}" class="img-fluid" style="max-width:600px;">
    </div>
@endsection
