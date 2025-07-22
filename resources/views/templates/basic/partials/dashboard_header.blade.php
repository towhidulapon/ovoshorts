<div class="dashboard-header">
    <div class="dashboard-header__inner flex-between">
        <div class="dashboard-header__left">
            <h4 class="dashboard-header__grettings mb-0">@lang('Hello!') {{ auth()->user()->username }} </h4>
        </div>
        <div class="dashboard-header__right flex-align">
            <div class="user-info">
                <button class="user-info__button flex-align" tabindex="-1">
                    <span class="user-info__thumb">
                        <img src="assets/images/thumbs/5.png" class="fit-image" alt="">
                    </span>
                </button>
                <ul class="user-info-dropdown">
                    <li class="user-info-dropdown__item"><a class="user-info-dropdown__link" href="profile.html">
                            <span class="icon"><i class="far fa-user-circle"></i></span>
                            <span class="text">Profile View</span>
                        </a></li>
                    <li class="user-info-dropdown__item"><a class="user-info-dropdown__link" href="#">
                            <span class="icon"><i class="fas fa-cog"></i></span>
                            <span class="text">Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>