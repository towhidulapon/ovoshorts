<span class="sidebar-menu__following__title fs-14 fw-700 mb-3">
    @lang('Following Accounts')
</span>
@forelse ($followings as $following)
    <a href="{{ route('user.profile', $following->username) }}" class="following__author">
        <div class="following__thumb">
            <img class="fit-image" src="{{ getImage(getFilePath('userProfile') . '/' . $following->image, getFileSize('userProfile')) }}" alt="author">
        </div>
        <div class="following__content">
            <h6 class="following__content__title">
                {{ $following->firstname }}
            </h6>
            <span class="following__content__meta">{{ $following->username }}</span>
        </div>
    </a>
@empty
    <p class="text-muted text-center">@lang('Accounts you follow will appear here')</p>
@endforelse