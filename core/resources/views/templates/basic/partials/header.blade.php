<div class="top-right-action-bar">
    <a href="{{ route('get.stars') }}" class="action-bar-btn" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path
                d="M12 2.5l2.494 5.053 5.571.81-4.035 3.941.953 5.551L12 15.77l-4.983 2.085.953-5.551L3.935 8.363l5.571-.81L12 2.5z"
                stroke="CurrentColor" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round" />
        </svg>
        <span class="text">@lang('Get Stars')</span>
    </a>
    <button class="action-bar-btn" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path
                d="M16.5 2H7.5C6.39543 2 5.5 2.89543 5.5 4V20C5.5 21.1046 6.39543 22 7.5 22H16.5C17.6046 22 18.5 21.1046 18.5 20V4C18.5 2.89543 17.6046 2 16.5 2Z"
                stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 19H12.01" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <span class="text">@lang('Get App')</span>
    </button>

    @if (auth()->check())
        <div class="user-info">
            <button class="user-info__button flex-align" tabindex="-1">
                <span class="user-info__thumb">
                    <img src="{{ auth()->user()->image ? getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}"
                        class="user-img fit-image" alt="img">
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
            <a class="btn btn--base btn--sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                href="{{ route('user.login') }}">
                <span class="icon"><i class="far fa-user-circle"></i></span>
                <span class="text">@lang('Login')</span>
            </a>
        </div>
    @endif
</div>







<div class="modal custom--modal fade login-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <div class="modal-body">
                <h3 class="title text-center mb-4">Log in to Tiktok</h3>
                <form action="#" method="POST">
                    <div class="social-login-btn">
                        <a href="#" class="btn social-login-link fs-18 w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <g clip-path="url(#clip0_2185_1311)">
                                    <path
                                        d="M24 12C24 17.9897 19.6116 22.9542 13.875 23.8542V15.4688H16.6711L17.2031 12H13.875V9.74906C13.875 8.79984 14.34 7.875 15.8306 7.875H17.3438V4.92188C17.3438 4.92188 15.9703 4.6875 14.6573 4.6875C11.9166 4.6875 10.125 6.34875 10.125 9.35625V12H7.07812V15.4688H10.125V23.8542C4.38844 22.9542 0 17.9897 0 12C0 5.37281 5.37281 0 12 0C18.6272 0 24 5.37281 24 12Z"
                                        fill="#1877F2"></path>
                                    <path
                                        d="M16.6711 15.4688L17.2031 12H13.875V9.74902C13.875 8.80003 14.3399 7.875 15.8306 7.875H17.3438V4.92188C17.3438 4.92188 15.9705 4.6875 14.6576 4.6875C11.9165 4.6875 10.125 6.34875 10.125 9.35625V12H7.07812V15.4688H10.125V23.8542C10.736 23.95 11.3621 24 12 24C12.6379 24 13.264 23.95 13.875 23.8542V15.4688H16.6711Z"
                                        fill="white"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2185_1311">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                            Continue with Facebook
                        </a>
                    </div>
                    <div class="social-login-btn">
                        <a href="#" class="btn social-login-link fs-18 w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <g clip-path="url(#clip0_2185_1326)">
                                    <path
                                        d="M5.31891 14.5034L4.4835 17.6221L1.43011 17.6867C0.517594 15.9942 0 14.0577 0 11.9999C0 10.01 0.483938 8.1335 1.34175 6.4812H1.34241L4.06078 6.97958L5.25159 9.68164C5.00236 10.4082 4.86652 11.1882 4.86652 11.9999C4.86661 12.8808 5.02617 13.7247 5.31891 14.5034Z"
                                        fill="#FBBB00"></path>
                                    <path
                                        d="M23.7902 9.7583C23.928 10.4842 23.9999 11.2339 23.9999 12.0001C23.9999 12.8592 23.9095 13.6972 23.7375 14.5056C23.1533 17.2563 21.6269 19.6583 19.5124 21.3581L19.5118 21.3574L16.0878 21.1827L15.6032 18.1576C17.0063 17.3348 18.1028 16.0471 18.6804 14.5056H12.2637V9.7583H18.774H23.7902Z"
                                        fill="#518EF8"></path>
                                    <path
                                        d="M19.5119 21.3575L19.5126 21.3581C17.4561 23.0111 14.8438 24.0001 12.0001 24.0001C7.43018 24.0001 3.457 21.4458 1.43018 17.6869L5.31897 14.5037C6.33236 17.2083 8.94138 19.1336 12.0001 19.1336C13.3148 19.1336 14.5465 18.7781 15.6033 18.1577L19.5119 21.3575Z"
                                        fill="#28B446"></path>
                                    <path
                                        d="M19.6596 2.76262L15.7721 5.94525C14.6783 5.26153 13.3853 4.86656 12 4.86656C8.87213 4.86656 6.21431 6.88017 5.25169 9.68175L1.34245 6.48131H1.3418C3.33895 2.63077 7.36223 0 12 0C14.9117 0 17.5814 1.03716 19.6596 2.76262Z"
                                        fill="#F14336"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2185_1326">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                            Continue with Google
                        </a>
                    </div>
                    <div class="social-login-btn">
                        <a href="#" class="btn social-login-link fs-18 w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                viewBox="0 0 25 24" fill="none">
                                <path
                                    d="M17.1187 0C17.1746 0 17.2304 0 17.2894 0C17.4264 1.69253 16.7804 2.95719 15.9953 3.87301C15.2249 4.78251 14.17 5.6646 12.4637 5.53076C12.3499 3.86247 12.997 2.69161 13.7811 1.77789C14.5083 0.92636 15.8414 0.168621 17.1187 0Z"
                                    fill="white"></path>
                                <path
                                    d="M22.2836 17.6166C22.2836 17.6335 22.2836 17.6482 22.2836 17.6641C21.8041 19.1163 21.1201 20.3609 20.2855 21.516C19.5235 22.5646 18.5898 23.9757 16.9225 23.9757C15.4819 23.9757 14.525 23.0494 13.0485 23.0241C11.4866 22.9988 10.6277 23.7987 9.1997 24C9.03635 24 8.873 24 8.71281 24C7.6642 23.8482 6.81793 23.0178 6.20141 22.2695C4.38347 20.0585 2.97865 17.2025 2.71729 13.5476C2.71729 13.1893 2.71729 12.832 2.71729 12.4737C2.82794 9.85797 4.09892 7.73124 5.78829 6.70054C6.67987 6.15253 7.90553 5.68566 9.27031 5.89432C9.85521 5.98496 10.4528 6.1852 10.9765 6.38333C11.4729 6.57408 12.0937 6.91237 12.6817 6.89446C13.0801 6.88286 13.4763 6.67525 13.8779 6.52876C15.054 6.10405 16.2069 5.61715 17.7266 5.84585C19.553 6.12196 20.8493 6.93345 21.6502 8.18546C20.1052 9.16873 18.8838 10.6505 19.0925 13.1808C19.278 15.4794 20.6143 16.8241 22.2836 17.6166Z"
                                    fill="white"></path>
                            </svg>
                            Continue with Apple</a>
                    </div>
                </form>
            </div>

            <div class="login-modal__footer mt-4">
                <div class="login-modal__footer__text">
                    <p class="fs-14">
                        By continuing with an account located in <a href="#" class="link fw-700">Bangladesh</a>,
                        you
                        agree to our <a href="#" class="link fw-700">Terms of Services</a> and acknowledge that
                        you
                        have read our <a href="#" class="link fw-700">Privacy Policy</a>.
                    </p>
                </div>
                <div class="login-have-account">
                    <p class="login-have-account__text">Don’t have an Account? <a href="registration.html"
                            class="login-have-account__link text--base fw-700">Sign Up</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
