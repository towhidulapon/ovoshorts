<div class="top-right-action-bar">
    <a href="{{ route('get.stars') }}" class="action-bar-btn" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 2.5l2.494 5.053 5.571.81-4.035 3.941.953 5.551L12 15.77l-4.983 2.085.953-5.551L3.935 8.363l5.571-.81L12 2.5z" stroke="CurrentColor" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round" />
        </svg>
        <span class="text">@lang('Get Stars')</span>
    </a>
    <button class="action-bar-btn" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M16.5 2H7.5C6.39543 2 5.5 2.89543 5.5 4V20C5.5 21.1046 6.39543 22 7.5 22H16.5C17.6046 22 18.5 21.1046 18.5 20V4C18.5 2.89543 17.6046 2 16.5 2Z" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 19H12.01" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span class="text">@lang('Get App')</span>
    </button>

    @if (auth()->check())
        <div class="user-info">
            <button class="user-info__button flex-align" tabindex="-1">
                <span class="user-info__thumb">
                    <img src="{{ auth()->user()->image ? getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" class="user-img" alt="img">
                </span>
            </button>
            <ul class="user-info-dropdown">
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.profile.setting') }}">
                        <span class="icon"><i class="far fa-user-circle"></i></span>
                        <span class="text">@lang('Profile View')</span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.verification.index') }}">
                        <span class="icon"><i class="fa-regular fa-circle-check"></i></span>
                        <span class="text">@lang('Get Verified')</span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.twofactor') }}">
                        <span class="icon">
                        <i class="fa-solid fa-user-shield"></i>
                        </span>
                        <span class="text">@lang('Two Factor')</span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.logout') }}">
                        <span class="icon"><i class="fas fa-cog"></i></span>
                        <span class="text">@lang('Log Out')</span>
                    </a>
                </li>
            </ul>
        </div>
    @else
        <div class="user-info">
            <a class="btn btn--base" href="{{ route('user.login') }}">
                <span class="icon"><i class="far fa-user-circle"></i></span>
                <span class="text">@lang('Login')</span>
            </a>
        </div>
    @endif
</div>