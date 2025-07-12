@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <h2 class="mb-4">Upload Image or video</h2>

        @if (session('success') && session('filename'))
            <div class="alert alert-success">
                File uploaded successfully.
            </div>

            @php
                $fileUrl = getS3FileUri(session('filename'));
                $extension = pathinfo(session('filename'), PATHINFO_EXTENSION);
                $isVideo = in_array(strtolower($extension), ['mp4', 'webm', 'mov']);
            @endphp

            @if ($fileUrl)
                <div class="mb-3">
                    <a href="{{ route('user.short.index') }}" target="_blank">View all files</a>
                </div>

                @if ($isVideo)
                    <video width="320" height="240" controls>
                        <source src="{{ $fileUrl }}" type="video/{{ $extension }}">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ $fileUrl }}" class="img-thumbnail" width="300">
                @endif
            @else
                <p class="text-danger">Could not generate file link.</p>
            @endif
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('user.short.upload') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Select File:</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection
