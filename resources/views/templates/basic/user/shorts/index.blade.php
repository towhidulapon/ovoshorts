@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <h2 class="mb-4">All Images</h2>
        <div class="row">
            @forelse ($images->where('type','!=',2) as $image)
                @php
                    $fileUrl = $image->storage_driver === 'wasabi' ? getS3FileUri($image->image_name) : route('user.short.file', $image->image_name);
                @endphp
                <div class="col-md-3 mb-4">
                    <a href="{{ route('user.short.view', $image->id) }}">
                        <img src="{{ $fileUrl }}" class="img-thumbnail" style="width:100%;height:200px;object-fit:cover;">
                    </a>
                    <button type="submit" class="btn btn-danger mt-2 confirmationBtn" data-question="@lang('Are you sure to delete this image?')" data-action="{{ route('user.short.delete', $image->id) }}">Delete</button>
                </div>
            @empty
                <p class="text-danger">No images found.</p>
            @endforelse
        </div>

        @if ($images->where('type', 2)->count() > 0)
            <h2 class="mb-4">All Videos</h2>
            <div class="row">
                @forelse ($images->where('type', 2) as $image)
                    @php
                        $fileUrl = $image->storage_driver === 'wasabi' ? getS3FileUri($image->image_name) : route('user.short.file', $image->image_name);
                        $extension = pathinfo($image->image_name, PATHINFO_EXTENSION);
                    @endphp
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('user.short.view', $image->id) }}">
                            <video width="320" height="240" controls muted class="hoverPlayVideo">
                                <source src="{{ $fileUrl }}" type="video/{{ $extension }}">
                                Your browser does not support the video tag.
                            </video>
                        </a>
                        <button type="submit" class="btn btn-danger mt-2 confirmationBtn" data-question="@lang('Are you sure to delete this video?')" data-action="{{ route('user.short.delete', $image->id) }}">Delete</button>
                    </div>
                @empty
                    <p class="text-danger">No videos found.</p>
                @endforelse
            </div>
        @endif
    </div>

    <x-confirmation-modal />
@endsection


@push('script')
    <script>
        "use strict";
        const videos = document.querySelectorAll('.hoverPlayVideo');
        videos.forEach(function(video) {
            video.addEventListener('mouseenter', function() {
                video.play();
            });
            video.addEventListener('mouseleave', function() {
                video.pause();
            });
        });
    </script>
@endpush
