@php
$isOwnMessage = $message->from_id == $currentUserId;
@endphp

<div class="single-message {{ $isOwnMessage ? 'message--right' : 'message--left' }}">
    <div class="message-content-outer">
        <div class="message-content-author">
            <div class="thumb">
                <img src="{{ $message?->sender?->image ? getImage(getFilePath('userProfile') . '/' . $message?->sender?->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" class="user-img fit-image" alt="img">
            </div>
            <div class="message-content {{ $message->images->isNotEmpty() ? 'has-image' : '' }}">
                @if($message->message)
                    <p class="message-text">{{ $message->message }}</p>
                @endif
                @if($message->images->isNotEmpty())
                    @foreach($message->images as $media)
                        @if ($media->is_video)
                            <a href="{{ route('user.message.media.download', $media->id) }}" class="popup-image">
                                <video class="img-fluid rounded message-image" controls muted>
                                    <source src="{{ getImage(getFilePath('messageImage') . '/' . $media->image) }}" type="video/{{ strtolower(pathinfo($media->image, PATHINFO_EXTENSION)) }}">
                                </video>
                            </a>
                        @else
                            <a href="{{ route('user.message.media.download', $media->id) }}" class="popup-image">
                                <img src="{{ getImage(getFilePath('messageImage') . '/' . $media->image) }}" alt="Message Image" class="img-fluid rounded message-image">
                            </a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .message-image {
            max-width: 100px;
            margin: 5px;
        }
    </style>
@endpush