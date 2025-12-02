<div class="dashboard-header__right flex-align ms-auto">
    <div class="user-info">
        <button class="user-info__button flex-align" tabindex="-1">
            <span class="user-info__thumb">
                <img src="{{ auth()->user()->image ? getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" class="user-img fit-image" alt="img">
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
                <a class="user-info-dropdown__link" href="{{ route('user.home') }}">
                    <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="text">@lang('Dashboard')</span>
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


</div>