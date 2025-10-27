@foreach($followers as $follower)
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <span class="user-info__thumb">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . $follower->image, getFileSize('userProfile')) }}" class="user-img fit-image">
            </span>
            <span class="ms-2">{{ $follower->username }}</span>
        </div>
        <a href="{{ route('user.profile', $follower->username) }}" class="btn btn--sm btn--base">@lang('View')</a>
    </div>
@endforeach

@if($followers->hasMorePages())
    <div class="load-more text-center py-2" data-next-page="{{ $followers->nextPageUrl() }}">
        <small class="text-muted">@lang('Scroll to load more...')</small>
    </div>
@endif

