<div class="comment-item reply-item" data-comment-id="{{ $reply->id }}">
    <div class="comment-item__thumb">
        <img class="fit-image" src="{{ getImage(getFilePath('userProfile') . '/' . $reply?->user?->image) }}" alt="image">
    </div>
    <div class="comment-item__content">
        <div class="comment-item__author">
            <h6 class="comment-item__author__name">{{ $reply?->user?->username }}</h6>
            <span class="comment-item__author__desc">{{ $reply->message }}</span>
        </div>
        <div class="comment-item__action">
            <div class="comment-item__action__top">
                <div class="comment-item__action__left">
                    <span>{{ diffForHumans($reply->created_at) }}</span>
                </div>
                <div class="comment-item__action__right">
                    <button type="button" class="common-action-btn comment-reaction-btn {{ $reply->is_liked ? 'liked' : '' }}" data-comment-id="{{ $reply->id }}">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M17.1584 4.14165C17.8917 4.96665 18.3334 6.04998 18.3334 7.24165C18.3334 13.075 12.9334 16.5166 10.5167 17.35C10.2334 17.45 9.76675 17.45 9.48341 17.35C7.06675 16.5166 1.66675 13.075 1.66675 7.24165C1.66675 4.66665 3.74175 2.58331 6.30008 2.58331C7.81675 2.58331 9.15841 3.31665 10.0001 4.44998C10.8417 3.31665 12.1917 2.58331 13.7001 2.58331" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text likes-count">{{ $reply->likes_count }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>