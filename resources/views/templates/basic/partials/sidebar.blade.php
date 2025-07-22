<div class="sidebar-menu">
    <div class="sidebar-menu__inner">
        <span class="sidebar-menu__close d-md-none d-flex"><i class="fas fa-times"></i></span>
        <!-- Sidebar Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>
        <div class="sidebar-search">
            <div class="input-group-custom">
                <span class="input-group-custom__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11.5 2C16.75 2 21 6.25 21 11.5C21 16.75 16.75 21 11.5 21C6.25 21 2 16.75 2 11.5C2 7.8 4.11 4.6 7.2 3.03" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 22L20 20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <input class="input-group-custom__input form-control form--control" type="text" placeholder="Search">
            </div>
        </div>

        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item">
                <a href="{{ route('home') }}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                            <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
                            </path>
                        </svg>
                    </span>
                    <span class="text">@lang('Home')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="explore.html" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M15.654 8.59888L7.54107 10.9169C7.3601 10.9686 7.34424 11.2189 7.51724 11.293L11.3168 12.9212C11.4349 12.9718 11.5289 13.0658 11.5795 13.1838L13.2079 16.9829C13.282 17.1559 13.5323 17.14 13.584 16.9591L15.9012 8.84611C15.9443 8.69525 15.8048 8.55578 15.654 8.59888Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            <path d="M22 12.5C22 18.0228 17.5228 22.5 12 22.5C6.47715 22.5 2 18.0228 2 12.5C2 6.97715 6.47715 2.5 12 2.5C17.5228 2.5 22 6.97715 22 12.5Z" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>
                    <span class="text">@lang('Explore')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="#" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M12.75 17.139C12.75 15.6053 13.8687 14.2501 15.5 14.2501C16.0855 14.2501 16.6247 14.3787 17.0953 14.6732C17.2418 14.7649 17.3764 14.8694 17.5 14.9851C17.6236 14.8694 17.7582 14.7649 17.9047 14.6732C18.3753 14.3787 18.9145 14.2501 19.5 14.2501C21.1313 14.2501 22.25 15.6053 22.25 17.139C22.25 18.9837 21.0327 20.3905 19.9821 21.2721C19.4504 21.7184 18.254 22.4224 17.835 22.669L17.8152 22.6807C17.6153 22.7733 17.3843 22.7731 17.1843 22.6804L17.165 22.6691C16.7464 22.4228 15.5498 21.7185 15.0179 21.2721C13.9673 20.3905 12.75 18.9837 12.75 17.139Z" fill="currentColor" />
                            <path d="M11.5 17.1389C11.5 15.6298 12.3021 14.1646 13.6455 13.4508C12.9212 12.9913 12.1155 12.6488 11.2549 12.4495C13.2914 11.7274 14.75 9.78405 14.75 7.5C14.75 4.60051 12.3995 2.25 9.5 2.25C6.6005 2.25 4.25 4.60051 4.25 7.5C4.25 9.78405 5.70857 11.7274 7.7451 12.4495C4.31022 13.2447 1.75 16.3234 1.75 20C1.75 20.4142 2.08579 20.75 2.5 20.75H12.7905C12.0806 19.8117 11.5 18.6015 11.5 17.1389Z" fill="currentColor" />
                        </svg>
                    </span>
                    <span class="text">@lang('Following')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="#" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M15.5 11.5C15.5 9.567 13.933 8 12 8C10.067 8 8.5 9.567 8.5 11.5C8.5 13.433 10.067 15 12 15C13.933 15 15.5 13.433 15.5 11.5Z" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15.4825 11.8499C15.8045 11.9475 16.146 12 16.4998 12C18.4328 12 19.9998 10.433 19.9998 8.5C19.9998 6.567 18.4328 5 16.4998 5C14.6849 5 13.1926 6.3814 13.0171 8.15013" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10.9827 8.15013C10.8072 6.3814 9.31492 5 7.5 5C5.567 5 4 6.567 4 8.5C4 10.433 5.567 12 7.5 12C7.85381 12 8.19535 11.9475 8.51727 11.8499" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 17C22 14.2386 19.5376 12 16.5 12" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17.5 20C17.5 17.2386 15.0376 15 12 15C8.96243 15 6.5 17.2386 6.5 20" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.5 12C4.46243 12 2 14.2386 2 17" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Friends')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="{{route('user.short.upload.index')}}" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M19.5 3H4.5C3.39543 3 2.5 3.89543 2.5 5V20C2.5 21.1046 3.39543 22 4.5 22H19.5C20.6046 22 21.5 21.1046 21.5 20V5C21.5 3.89543 20.6046 3 19.5 3Z" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 8.5V16.5M16 12.5H8" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Upload')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item has-sidebar">
                <a href="#" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M7 14.5L9.79289 11.7071C10.1834 11.3166 10.8166 11.3166 11.2071 11.7071L12.7929 13.2929C13.1834 13.6834 13.8166 13.6834 14.2071 13.2929L17 10.5" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21.5 5V20C21.5 21.1046 20.6046 22 19.5 22H4.5C3.39543 22 2.5 21.1046 2.5 20V5C2.5 3.89543 3.39543 3 4.5 3H19.5C20.6046 3 21.5 3.89543 21.5 5Z" stroke="CurrentColor" stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Activity')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="message.html" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M14.1706 20.8905C18.3536 20.6125 21.6856 17.2332 21.9598 12.9909C22.0134 12.1607 22.0134 11.3009 21.9598 10.4707C21.6856 6.22838 18.3536 2.84913 14.1706 2.57107C12.7435 2.47621 11.2536 2.47641 9.8294 2.57107C5.64639 2.84913 2.31441 6.22838 2.04024 10.4707C1.98659 11.3009 1.98659 12.1607 2.04024 12.9909C2.1401 14.536 2.82343 15.9666 3.62791 17.1746C4.09501 18.0203 3.78674 19.0758 3.30021 19.9978C2.94941 20.6626 2.77401 20.995 2.91484 21.2351C3.05568 21.4752 3.37026 21.4829 3.99943 21.4982C5.24367 21.5285 6.08268 21.1757 6.74868 20.6846C7.1264 20.4061 7.31527 20.2668 7.44544 20.2508C7.5756 20.2348 7.83177 20.3403 8.34401 20.5513C8.8044 20.7409 9.33896 20.8579 9.8294 20.8905C11.2536 20.9852 12.7435 20.9854 14.1706 20.8905Z" stroke="CurrentColor" stroke-width="2" stroke-linejoin="round" />
                            <path d="M8.5 14.5H15.5M8.5 9.5H12" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Messages')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item">
                <a href="#" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M20 21.5C21.1046 21.5 22 20.6046 22 19.5V13.5C22 12.3954 21.1046 11.5 20 11.5H4C2.89543 11.5 2 12.3954 2 13.5V19.5C2 20.6046 2.89543 21.5 4 21.5H20Z" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16 6.5C15.0227 5.27354 13.5929 4.5 12 4.5C10.4071 4.5 8.97726 5.27354 8 6.5" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M14 8.5C13.5114 7.88677 12.7965 7.5 12 7.5C11.2035 7.5 10.4886 7.88677 10 8.5" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M5 14.5V18.5H6.5M19 18.5H17V16.5M17 16.5V14.5H19M17 16.5H18.5M9 14.5V18.5M11.5 14.5L13 18.5L14.5 14.5" stroke="CurrentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Live')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__profile sidebar-menu-list__item">
                <a href="profile.html" class="sidebar-menu-list__link">
                    <div class="profile__thumb">
                        <img src="assets/images/thumbs/5.png" alt="">
                    </div>
                    <h6 class="profile__content__title">
                        Jessica Harper
                    </h6>
                </a>
            </li>
            <li class="sidebar-menu-list__item has-sidebar">
                <a href="#" class="sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path d="M17 12.5C17 13.8807 18.1193 15 19.5 15C20.8807 15 22 13.8807 22 12.5C22 11.1193 20.8807 10 19.5 10C18.1193 10 17 11.1193 17 12.5Z" fill="CurrentColor" />
                            <path d="M9.5 12.5C9.5 13.8807 10.6193 15 12 15C13.3807 15 14.5 13.8807 14.5 12.5C14.5 11.1193 13.3807 10 12 10C10.6193 10 9.5 11.1193 9.5 12.5Z" fill="CurrentColor" />
                            <path d="M2 12.5C2 13.8807 3.11929 15 4.5 15C5.88071 15 7 13.8807 7 12.5C7 11.1193 5.88071 10 4.5 10C3.11929 10 2 11.1193 2 12.5Z" fill="CurrentColor" />
                        </svg>
                    </span>
                    <span class="text">@lang('More')</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-menu__following">
            <span class="sidebar-menu__following__title fs-14 fw-700 mb-3">
                @lang('Following Accounts')
            </span>
            <a href="#" class="following__author">
                <div class="following__thumb">
                    <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                </div>
                <div class="following__content">
                    <h6 class="following__content__title">
                        Jessica Harper
                    </h6>
                    <span class="following__content__meta"> harper_jessica</span>
                </div>
            </a>
            <a href="#" class="following__author">
                <div class="following__thumb">
                    <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                </div>
                <div class="following__content">
                    <h6 class="following__content__title">
                        Jessica Harper
                    </h6>
                    <span class="following__content__meta"> harper_jessica</span>
                </div>
            </a>
            <a href="#" class="following__author">
                <div class="following__thumb">
                    <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                </div>
                <div class="following__content">
                    <h6 class="following__content__title">
                        Jessica Harper
                    </h6>
                    <span class="following__content__meta"> harper_jessica</span>
                </div>
            </a>
        </div>
    </div>

    <div class="sidebar-left">
        <div class="sidebar-left__header">
            <div class="sidebar-left__header-top">
                <h4 class="titel">Notifications</h4>
                <button class="sidebar_left-close">
                    <i class="las la-arrow-left"></i>
                </button>
            </div>
            <div class="tag-wrapper">
                <a href="#" class="tag-link">All Activity</a>
                <a href="#" class="tag-link">Likes</a>
                <a href="#" class="tag-link">Comments</a>
                <a href="#" class="tag-link">Mentions and tags</a>
                <a href="#" class="tag-link">Followers</a>
            </div>
        </div>

        <div class="sidebar-left__body">
            <span class="sidebar-left__title">Today</span>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <span class="sidebar-left__title">This Month</span>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <span class="sidebar-left__title">Previous</span>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>
            <div class="notification-item">
                <a href="#" class="notification-item__link"></a>
                <div class="notification-item__left">
                    <div class="notification-item__thumb">
                        <img class="fit-image" src="assets/images/thumbs/5.png" alt="author">
                    </div>
                    <div class="notification-item__content">
                        <h6 class="name">
                            Jessica Harper
                        </h6>
                        <span class="desc"> Liked your video • 4h</span>
                    </div>
                </div>
                <div class="notification-item__right">
                    <div class="thumb">
                        <img src="assets/images/thumbs/notification-img.png" alt="img">
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>