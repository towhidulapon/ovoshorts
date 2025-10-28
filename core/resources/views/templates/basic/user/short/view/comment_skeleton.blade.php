<div class="comment-item skeleton-comment">
    <div class="comment-item__thumb">
        <div class="skeleton-avatar"></div>
    </div>
    <div class="comment-item__content">
        <div class="comment-item__author">
            <div class="skeleton-text skeleton-name"></div>
            <div class="skeleton-text skeleton-desc"></div>
        </div>
        <div class="comment-item__action">
            <div class="skeleton-text skeleton-date"></div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .skeleton-comment {
            opacity: 0.8;
            margin-bottom: 15px;
            display: flex;
        }

        .skeleton-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(90deg, #3a3a3a 25%, #4a4a4a 50%, #3a3a3a 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            flex-shrink: 0;
        }

        .skeleton-text {
            height: 16px;
            border-radius: 4px;
            background: linear-gradient(90deg, #3a3a3a 25%, #4a4a4a 50%, #3a3a3a 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            margin-bottom: 8px;
        }

        .skeleton-name {
            width: 120px;
        }

        .skeleton-desc {
            width: 100%;
        }

        .skeleton-date {
            width: 80px;
        }

        @keyframes skeleton-loading {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>
@endpush