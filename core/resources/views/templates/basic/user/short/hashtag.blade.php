@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="body__wrapper py-5">
        <div class="body__wrapper-container">
            <div class="explore-section">
                <div class="explore-item-wrapper">
                    @forelse ($shorts as $userShort)

                        @php
                            $isLiked = auth()->check() && App\Models\UserReaction::where('shorts_id', $userShort->id)
                                ->where('user_id', auth()->id())
                                ->exists();
                        @endphp

                        <div class="explore-item">
                            <a href="{{ route('user.short.view', $userShort->id) }}" class="explore-item__link">
                                <div class="explore-item__video">
                                    <video class="video-player" playsinline preload="metadata" controls poster="{{ getImage(getFilePath('coverImage') . '/' . $userShort->cover_image, getFileSize('coverImage')) }}">
                                        <source src="{{ $userShort->fileUrl }}" type="video/{{ $userShort->extension }}">
                                    </video>
                                    <button class="explore-action like-btn {{ $userShort->isLiked ? 'liked' : '' }}" data-shorts-id="{{ $userShort->id }}" data-shorts-owner-id="{{ $userShort->user_id }}">
                                        <span class="icon {{ $isLiked ? 'liked' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M9.99984 17.0833C9.99984 17.0833 1.6665 12.0833 1.6665 7.24536C1.6665 4.85468 3.42089 2.91666 5.83317 2.91666C7.08317 2.91666 8.33317 3.33332 9.99984 4.99999C11.6665 3.33332 12.9165 2.91666 14.1665 2.91666C16.5788 2.91666 18.3332 4.85468 18.3332 7.24536C18.3332 12.0833 9.99984 17.0833 9.99984 17.0833Z" stroke="CurrentColor" stroke-width="2" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="text like-count">{{ showFormatCount($userShort->likes_count) }}</span>
                                    </button>
                                </div>
                            </a>
                            <a href="{{ route('user.profile', $userShort?->user?->username) }}" class="explore-item__author">
                                <div class="explore-item__author__thumb">
                                    <img src="{{ $userShort?->user?->image ? getImage(getFilePath('userProfile') . '/' . $userShort?->user?->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" class="fit-image" alt="avatar">
                                </div>
                                <span class="explore-item__author__name fw-bold">
                                    {{ $userShort?->user?->username }}
                                </span>
                            </a>

                            <p class="video-item-content__desc">
                                {!! $userShort->description !!}
                            </p>
                        </div>
                    @empty
                        <x-empty-message message="No shorts found" />
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection