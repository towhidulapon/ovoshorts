@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container text-center">
        <h2 class="mb-4">View Image</h2>
        @if ($image->type == 1)
            <img src="{{ $url }}" class="img-fluid" style="max-width:300px;">
        @else
            <video src="{{ $url }}" class="img-fluid" style="max-width:300px;" controls></video>
        @endif
    </div>
@endsection
