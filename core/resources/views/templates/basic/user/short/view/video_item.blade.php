<div class="video-item">
    <div class="video-item-wrapper">
        <video class="video-player" playsinline preload="metadata" data-video_id="{{ encrypt($short->id) }}" data-short-id="{{ $short->id }}" controls poster="{{ getImage(getFilePath('coverImage') . '/' . $short->cover_image) }}">
            <source src="{{ $short->fileUrl }}" type="video/{{ $short->extension }}">
        </video>
        <div class="video-item-content">
            <div class="video-item-content__title">
                <span class="name">
                    <a href="{{ route('user.profile', $short?->user?->username) }}">
                        {{ $short?->user?->username }}
                    </a>
                </span>
                @if ($short->user->is_verified == Status::VERIFICATION_SUCCESS)
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path d="M12.9841 22.5158C18.507 22.5158 22.9841 18.0386 22.9841 12.5158C22.9841 6.99293 18.507 2.51578 12.9841 2.51578C7.46128 2.51578 2.98413 6.99293 2.98413 12.5158C2.98413 18.0386 7.46128 22.5158 12.9841 22.5158Z" fill="hsl(var(--base-two))" />
                            <path d="M9.98413 12.5158L11.9841 14.5158L15.9841 10.5158" stroke="white" stroke-width="2.9921" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                @endif
                <span class="time">{{ diffForHumans($short?->post_at) }}</span>
            </div>
            <p class="video-item-content__desc">
                {!! $short->description !!}
            </p>
        </div>
        <div class="video-item__action">
            <div class="cmn-button-item profile-follow" data-user-id="{{ $short->user_id }}">
                <a href="{{ route('user.profile', $short->user->username) }}" class="profile-thumb">
                    <img src="{{ $short->user->image ? getImage(getFilePath('userProfile') . '/' . $short->user->image) : asset('assets/images/avatar.jpg') }}" class="fit-image" alt="img">

                </a>
                @if ($short->user->id !== auth()->id())
                    <button class="follower-btn follow-toggle-btn follow-btn" data-following="{{ in_array($short->user->id, $following) ? '1' : '0' }}" data-id="{{ $short->user->id }}" data-action="follow">
                        <i class="las {{ in_array($short->user->id, $following) ? 'la-check' : 'la-plus' }}"></i>
                    </button>
                @endif

            </div>
            <div class="cmn-button-item">
                @php
                    $isLiked =
                        auth()->check() &&
                        App\Models\UserReaction::where('shorts_id', $short->id)
                            ->where('user_id', auth()->id())
                            ->exists();
                    $isSaved =
                        auth()->check() &&
                        App\Models\SavedShort::where('shorts_id', $short->id)
                            ->where('user_id', auth()->id())
                            ->exists();
                @endphp
                <button class="like-button button-item like-btn {{ $isLiked ? 'liked' : '' }}" data-shorts-id="{{ $short->id }}" data-shorts-owner-id="{{ $short->user_id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                        <path d="M19.1799 3.61667C17.0683 3.61667 15.1783 4.64334 13.9999 6.21834C12.8216 4.64334 10.9316 3.61667 8.81992 3.61667C5.23825 3.61667 2.33325 6.53334 2.33325 10.1383C2.33325 11.5267 2.55492 12.81 2.93992 14C4.78325 19.8333 10.4649 23.3217 13.2766 24.2783C13.6733 24.4183 14.3266 24.4183 14.7233 24.2783C17.5349 23.3217 23.2166 19.8333 25.0599 14C25.4449 12.81 25.6666 11.5267 25.6666 10.1383C25.6666 6.53334 22.7616 3.61667 19.1799 3.61667Z" fill="CurrentColor" />
                    </svg>
                </button>
                <span class="button-text likeCount like-count">{{ showFormatCount($short->likes_count) }}</span>
            </div>
            @if ($short->allow_comments === Status::YES)
                <div class="cmn-button-item button-comment">
                    <button class="like-button  button-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                            <path d="M18.6666 2.33333H9.33325C4.66659 2.33333 2.33325 4.66667 2.33325 9.33333V24.5C2.33325 25.1417 2.85825 25.6667 3.49992 25.6667H18.6666C23.3333 25.6667 25.6666 23.3333 25.6666 18.6667V9.33333C25.6666 4.66667 23.3333 2.33333 18.6666 2.33333ZM16.3333 17.7917H8.16659C7.68825 17.7917 7.29159 17.395 7.29159 16.9167C7.29159 16.4383 7.68825 16.0417 8.16659 16.0417H16.3333C16.8116 16.0417 17.2083 16.4383 17.2083 16.9167C17.2083 17.395 16.8116 17.7917 16.3333 17.7917ZM19.8333 11.9583H8.16659C7.68825 11.9583 7.29159 11.5617 7.29159 11.0833C7.29159 10.605 7.68825 10.2083 8.16659 10.2083H19.8333C20.3116 10.2083 20.7083 10.605 20.7083 11.0833C20.7083 11.5617 20.3116 11.9583 19.8333 11.9583Z" fill="CurrentColor" />
                        </svg>
                    </button>
                    <span class="button-text likeCount comment-count">{{ showFormatCount($short->comments->count()) }}</span>
                </div>
            @endif
            <div class="cmn-button-item save-button">
                <button class="like-button button-item save-btn {{ $isSaved ? 'saved' : '' }}" data-shorts-id="{{ $short->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                        <path d="M19.6233 2.33333H8.37662C5.89162 2.33333 3.87329 4.36333 3.87329 6.83667V23.275C3.87329 25.375 5.37829 26.2617 7.22162 25.2467L12.915 22.085C13.5216 21.7467 14.5016 21.7467 15.0966 22.085L20.79 25.2467C22.6333 26.2733 24.1383 25.3867 24.1383 23.275V6.83667C24.1266 4.36333 22.1083 2.33333 19.6233 2.33333ZM17.5116 11.375C16.38 11.7833 15.19 11.9933 14 11.9933C12.81 11.9933 11.62 11.7833 10.4883 11.375C10.0333 11.2117 9.79996 10.71 9.96329 10.255C10.1383 9.8 10.64 9.56667 11.095 9.73C12.9733 10.4067 15.0383 10.4067 16.9166 9.73C17.3716 9.56667 17.8733 9.8 18.0366 10.255C18.2 10.71 17.9666 11.2117 17.5116 11.375Z" fill="CurrentColor" />
                    </svg>
                </button>
                <span class="button-text likeCount save-count">{{ showFormatCount($short->savedShorts->count()) }}</span>
            </div>

            <div class="cmn-button-item star-button">
                <button class="like-button button-item send-stars-btn " data-receiver-id="{{ $short->user_id }}" data-short-id="{{ $short->id }}" @if ($short->user_id == auth()->id()) disabled @endif>
                    ⭐
                </button>
                <span class="button-text likeCount star-count">{{ $short->stars_sum_stars ?? 0 }}</span>
            </div>

            <div class="cmn-button-item share-button">
                <button class="like-button button-item share-btn" data-shorts-id="{{ $short->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
                        <path d="M18.8299 3.45334L8.29489 6.95334C1.21323 9.32167 1.21323 13.1833 8.29489 15.54L11.4216 16.5783L12.4599 19.705C14.8166 26.7867 18.6899 26.7867 21.0466 19.705L24.5582 9.18167C26.1216 4.45667 23.5549 1.87834 18.8299 3.45334ZM19.2032 9.73L14.7699 14.1867C14.5949 14.3617 14.3732 14.4433 14.1516 14.4433C13.9299 14.4433 13.7082 14.3617 13.5332 14.1867C13.1949 13.8483 13.1949 13.2883 13.5332 12.95L17.9666 8.49334C18.3049 8.155 18.8649 8.155 19.2032 8.49334C19.5416 8.83167 19.5416 9.39167 19.2032 9.73Z" fill="CurrentColor" />
                    </svg>
                </button>
                <span class="button-text likeCount share-count">{{ showFormatCount($short->shares_count) }}</span>
            </div>

        </div>
    </div>
</div>