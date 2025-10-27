@extends($activeTemplate . 'layouts.setting_frontend')
@section('content')

    <section class="scrollspy-example bg-body-tertiary" data-bs-offset="80" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" data-bs-spy="scroll" data-bs-target="#navbar-example2" tabindex="0">
        <div class="setting-page-body">
            <div class="container">
                <span class="sidebar-trigger d-lg-none d-inline-flex"><i class="las la-list"></i></span>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="setting-menu">
                            <span class="sidebar-menu__close d-lg-none d-inline-flex"><i class="las la-times"></i></span>
                            <ul class="setting-menu-list">
                                <li class="setting-menu-list__item">
                                    <a href="#manage-account" class="setting-menu-list__item__link active">
                                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                                <path d="M15 9.5C15 7.84315 13.6569 6.5 12 6.5C10.3431 6.5 9 7.84315 9 9.5C9 11.1569 10.3431 12.5 12 12.5C13.6569 12.5 15 11.1569 15 9.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M22 12.5C22 6.97715 17.5228 2.5 12 2.5C6.47715 2.5 2 6.97715 2 12.5C2 18.0228 6.47715 22.5 12 22.5C17.5228 22.5 22 18.0228 22 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M17 17.5C17 14.7386 14.7614 12.5 12 12.5C9.23858 12.5 7 14.7386 7 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg></span>
                                        <span class="text">Manage account </span>
                                    </a>
                                </li>
                                <li class="setting-menu-list__item">
                                    <a href="#privacy" class="setting-menu-list__item__link active">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                                <path d="M12 17V15" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" />
                                                <path d="M4.26781 19.3447C4.49269 21.015 5.87613 22.3235 7.55966 22.4009C8.97627 22.466 10.4153 22.5 12 22.5C13.5847 22.5 15.0237 22.466 16.4403 22.4009C18.1239 22.3235 19.5073 21.015 19.7322 19.3447C19.8789 18.2547 20 17.1376 20 16C20 14.8624 19.8789 13.7453 19.7322 12.6553C19.5073 10.985 18.1239 9.67649 16.4403 9.59909C15.0237 9.53397 13.5847 9.5 12 9.5C10.4153 9.5 8.97627 9.53397 7.55966 9.59909C5.87613 9.67649 4.49269 10.985 4.26781 12.6553C4.12105 13.7453 4 14.8624 4 16C4 17.1376 4.12105 18.2547 4.26781 19.3447Z" stroke="CurrentColor" stroke-width="1.5" />
                                                <path d="M7.5 9.5V7C7.5 4.51472 9.51472 2.5 12 2.5C14.4853 2.5 16.5 4.51472 16.5 7V9.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="text">Privacy </span>
                                    </a>
                                </li>
                                <li class="setting-menu-list__item">
                                    <a href="#push-notification" class="setting-menu-list__item__link active">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                                <path d="M15.5 18.5C15.5 20.433 13.933 22 12 22C10.067 22 8.5 20.433 8.5 18.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M19.2311 18.5H4.76887C3.79195 18.5 3 17.708 3 16.7311C3 16.262 3.18636 15.8121 3.51809 15.4803L4.12132 14.8771C4.68393 14.3145 5 13.5514 5 12.7558V10C5 6.13401 8.13401 3 12 3C15.866 3 19 6.134 19 10V12.7558C19 13.5514 19.3161 14.3145 19.8787 14.8771L20.4819 15.4803C20.8136 15.8121 21 16.262 21 16.7311C21 17.708 20.208 18.5 19.2311 18.5Z" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="text">Push Notifications</span>
                                    </a>
                                </li>
                                <li class="setting-menu-list__item">
                                    <a href="#ads" class="setting-menu-list__item__link active">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                                <path d="M7 9.5V15.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M7 9.5H6C5.06812 9.5 4.60218 9.5 4.23463 9.65224C3.74458 9.85523 3.35523 10.2446 3.15224 10.7346C3 11.1022 3 11.5681 3 12.5C3 13.4319 3 13.8978 3.15224 14.2654C3.35523 14.7554 3.74458 15.1448 4.23463 15.3478C4.60218 15.5 5.06812 15.5 6 15.5H7L15.0796 17.9239C16.0291 18.2087 16.5039 18.3512 16.9257 18.6014L16.9459 18.6135C17.3663 18.8663 17.7167 19.2167 18.4177 19.9177L18.5858 20.0858C18.7051 20.2051 18.7647 20.2647 18.831 20.3123C18.9561 20.4021 19.1003 20.4619 19.2523 20.4868C19.3327 20.5 19.4171 20.5 19.5858 20.5C19.9713 20.5 20.1641 20.5 20.3196 20.4475C20.6155 20.3477 20.8477 20.1155 20.9475 19.8196C21 19.6641 21 19.4713 21 19.0858V5.91421C21 5.52866 21 5.33589 20.9475 5.18039C20.8477 4.88452 20.6155 4.65225 20.3196 4.55245C20.1641 4.5 19.9713 4.5 19.5858 4.5C19.4171 4.5 19.3327 4.5 19.2523 4.5132C19.1003 4.53815 18.9561 4.59787 18.831 4.68771C18.7647 4.73526 18.7051 4.79491 18.5858 4.91421L18.4177 5.0823C17.7167 5.78326 17.3663 6.13374 16.9459 6.38649L16.9257 6.39856C16.5039 6.64884 16.0291 6.79126 15.0796 7.07611L7 9.5Z" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M8 16V18.5458C8 19.6251 8.87491 20.5 9.95416 20.5C10.6075 20.5 11.2177 20.1735 11.5801 19.6298L13 17.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg></span>
                                        <span class="text">Ads </span>
                                    </a>
                                </li>
                                <li class="setting-menu-list__item">
                                    <a href="#screen-time" class="setting-menu-list__item__link active">
                                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                                <path d="M4 3.5H20" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M5.5 3.5V5.53039C5.5 6.77227 6.07682 7.9437 7.06116 8.70089L12 12.5L16.9388 8.70089C17.9232 7.94371 18.5 6.77227 18.5 5.53039V3.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M5.5 21.5V19.4696C5.5 18.2277 6.07682 17.0563 7.06116 16.2991L12 12.5L16.9388 16.2991C17.9232 17.0563 18.5 18.2277 18.5 19.4696V21.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M4 21.5H20" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg> </span>
                                        <span class="text">Screen time </span>
                                    </a>
                                </li>
                                <li class="setting-menu-list__item">
                                    <a href="#content-preferences" class="setting-menu-list__item__link active">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                                <path d="M11 8.5H13" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" />
                                                <path d="M2 11.5C2 8.20017 2 6.55025 3.02513 5.52513C4.05025 4.5 5.70017 4.5 9 4.5H10C13.2998 4.5 14.9497 4.5 15.9749 5.52513C17 6.55025 17 8.20017 17 11.5V13.5C17 16.7998 17 18.4497 15.9749 19.4749C14.9497 20.5 13.2998 20.5 10 20.5H9C5.70017 20.5 4.05025 20.5 3.02513 19.4749C2 18.4497 2 16.7998 2 13.5V11.5Z" stroke="CurrentColor" stroke-width="1.5" />
                                                <path d="M17 9.40585L17.1259 9.30196C19.2417 7.55623 20.2996 6.68336 21.1498 7.10482C22 7.52628 22 8.92355 22 11.7181V13.2819C22 16.0765 22 17.4737 21.1498 17.8952C20.2996 18.3166 19.2417 17.4438 17.1259 15.698L17 15.5941" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        <span class="text">Content Preference </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="setting-body-content">
                            <div class="setting-option space-item" id="manage-account">
                                <div class="setting-option__header">
                                    <h4>Manage account</h4>
                                </div>
                                <div class="setting-option__wrapper">
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Account control</h6>
                                                <p class="desc">Delete account</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="delete-btn" type="button">Delete Account</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Account Information</h6>
                                                <p class="desc">Account region</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn" type="button">Bangladesh <i class="las la-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-option space-item" id="privacy">
                                <div class="setting-option__header">
                                    <h4>Privacy</h4>
                                </div>
                                <div class="setting-option__wrapper">

                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Discoverability</h6>
                                                <h6 class="sub-title fw-400">Privet account</h6>
                                                <p class="desc">With a private account, only users you approve can follow
                                                    you
                                                    and watch your videos. Your existing followers won’t be affected.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <div class="form-check form--switch">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Data</h6>
                                                <h6 class="sub-title fw-400">Download your data</h6>
                                                <p class="desc">Get a copy of your OvoShorts data.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn arrow-btn" type="button"><i class="las la-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-option space-item" id="push-notification">
                                <div class="setting-option__header">
                                    <h4>Push Notifications</h4>
                                </div>
                                <div class="setting-option__wrapper">
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Desktop notifications</h6>
                                                <h6 class="sub-title fw-400">Allow in browser</h6>
                                                <p class="desc">Stay on top of notifications for likes, comments, the latest
                                                    videos, and more on desktop. You can turn them off anytime.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <div class="form-check form--switch">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Interactions</h6>
                                                <p class="desc">Likes, comments, new followers, mentions and tags</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn arrow-btn" type="button">
                                                    <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">In-app notifications</h6>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn arrow-btn" type="button">
                                                    <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-option space-item" id="ads">
                                <div class="setting-option__header">
                                    <h4>Ads</h4>
                                </div>
                                <div class="setting-option__wrapper">
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Manage the ads you see</h6>
                                                <h6 class="sub-title fw-400">Manage ad topics</h6>
                                                <p class="desc">change factors used to tailor the ads you see</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn arrow-btn" type="button">
                                                    <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Mute advertisers</h6>
                                                <p class="desc">Mute ads from specific advertisers who showed you ads
                                                    recently
                                                    on OvoShorts.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn arrow-btn" type="button">
                                                    <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Edit personal details</h6>
                                                <p class="desc">select the gender which may be used to tailor the ads you
                                                    see.
                                                </p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="language-btn arrow-btn" type="button">
                                                    <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-option space-item" id="screen-time">
                                <div class="setting-option__header">
                                    <h4>Screen time</h4>
                                </div>
                                <div class="setting-option__wrapper">
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Manage ad topics</h6>
                                                <p class="desc">Get notified if you reach your time on OvoShorts.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="setting-common-btn" type="button">
                                                    Off <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Screen time breaks</h6>
                                                <p class="desc">Get reminded to take breaks from scrolling.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="setting-common-btn" type="button">
                                                    Off <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Sleep reminders</h6>
                                                <p class="desc">Get reminded about your sleep time.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="setting-common-btn" type="button">
                                                    Off <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Weekly screen time updates</h6>
                                                <p class="desc">Stay updated on your time from your Inbox.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <div class="form-check form--switch">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Summary</h6>
                                                <p class="desc">Your weekly metrics include your time on the app and on
                                                    tiktok.com.</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <button class="setting-common-btn" type="button">
                                                    <i class="las la-caret-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting-option__item-wrapper">
                                        <div class="setting-option__item">
                                            <div class="setting-option__item__left">
                                                <h6 class="title">Help and resources</h6>
                                                <p class="desc">Digital wellbeing tips</p>
                                            </div>
                                            <div class="setting-option__item__right">
                                                <a href="#" target="_blank" class="setting-common-btn text--base">
                                                    <i class="las la-external-link-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-option space-item" id="content-preferences">
                                <div class="setting-option__header">
                                    <h4>Content preferences</h4>
                                </div>
                                <div class="setting-option__wrapper">
                                    <div class="setting-option__item">
                                        <div class="setting-option__item__left">
                                            <h6 class="title">Filter keywords</h6>
                                            <p class="desc">When you filter a keyword, you won’t see posts in your
                                                selected feeds that contain that word in any titles, descriptions, or
                                                stickers. Certain keywords can’t be filtered.</p>
                                        </div>
                                        <div class="setting-option__item__right">
                                            <button class="language-btn arrow-btn" type="button">
                                                <i class="las la-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection