@foreach($following as $user)
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <span class="user-info__thumb">
                <img src="{{ $user->image ? getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" class="user-img fit-image">
            </span>
            <span class="ms-2">{{ $user->username }}</span>
        </div>
        <a href="{{ route('user.profile', $user->username) }}" class="btn btn--sm btn--base">@lang('View')</a>
    </div>
@endforeach

@if($following->hasMorePages())
    <div class="load-more text-center py-2" data-next-page="{{ $following->nextPageUrl() }}">
        <small class="text-muted">@lang('Scroll to load more...')</small>
    </div>
@endif

