<div class="setting-header">
    <div class="setting-header-left">
        <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
    </div>
    <div class="setting-header-right">
        @auth
            <a href="{{ route('user.message.index') }}" class="message-btn-trigger">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none">
                        <path d="M18.8935 27.1874C24.4708 26.8167 28.9135 22.311 29.2791 16.6546C29.3505 15.5476 29.3505 14.4012 29.2791 13.2943C28.9135 7.63786 24.4708 3.13219 18.8935 2.76145C16.9907 2.63497 15.0041 2.63523 13.1052 2.76145C7.52787 3.13219 3.08523 7.63786 2.71967 13.2943C2.64813 14.4012 2.64813 15.5476 2.71967 16.6546C2.85281 18.7147 3.76392 20.6222 4.83656 22.2328C5.45936 23.3604 5.04833 24.7678 4.39963 25.9971C3.93189 26.8835 3.69803 27.3267 3.8858 27.6468C4.07359 27.967 4.49303 27.9772 5.33192 27.9976C6.99091 28.038 8.10959 27.5676 8.99759 26.9128C9.50121 26.5415 9.75304 26.3558 9.9266 26.3344C10.1001 26.3131 10.4417 26.4538 11.1247 26.7351C11.7385 26.9879 12.4513 27.1439 13.1052 27.1874C15.0041 27.3136 16.9907 27.3139 18.8935 27.1874Z" stroke="CurrentColor" stroke-width="2" stroke-linejoin="round" />
                        <path d="M11.334 18.6667H20.6673M11.334 12H16.0007" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>


            <div class="user-info">
                <button class="user-info__button flex-align" tabindex="-1">
                    <span class="user-info__thumb">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user?->image, getFileSize('userProfile')) }}" class="user-img fit-image" alt="User Image">
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
        @endauth
    </div>
</div>