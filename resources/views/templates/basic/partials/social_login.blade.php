@if (@gs('socialite_credentials')->linkedin->status || @gs('socialite_credentials')->facebook->status == Status::ENABLE || @gs('socialite_credentials')->google->status == Status::ENABLE)
    <div class="social-login">
        @if (@gs('socialite_credentials')->google->status == Status::ENABLE)
            <div class="social-login-btn">
                <a href="{{ route('user.social.login', 'google') }}" class="btn social-login-link fs-18 w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <g clip-path="url(#clip0_2185_1326)">
                            <path
                                d="M5.31891 14.5034L4.4835 17.6221L1.43011 17.6867C0.517594 15.9942 0 14.0577 0 11.9999C0 10.01 0.483938 8.1335 1.34175 6.4812H1.34241L4.06078 6.97958L5.25159 9.68164C5.00236 10.4082 4.86652 11.1882 4.86652 11.9999C4.86661 12.8808 5.02617 13.7247 5.31891 14.5034Z"
                                fill="#FBBB00" />
                            <path
                                d="M23.7902 9.7583C23.928 10.4842 23.9999 11.2339 23.9999 12.0001C23.9999 12.8592 23.9095 13.6972 23.7375 14.5056C23.1533 17.2563 21.6269 19.6583 19.5124 21.3581L19.5118 21.3574L16.0878 21.1827L15.6032 18.1576C17.0063 17.3348 18.1028 16.0471 18.6804 14.5056H12.2637V9.7583H18.774H23.7902Z"
                                fill="#518EF8" />
                            <path
                                d="M19.5119 21.3575L19.5126 21.3581C17.4561 23.0111 14.8438 24.0001 12.0001 24.0001C7.43018 24.0001 3.457 21.4458 1.43018 17.6869L5.31897 14.5037C6.33236 17.2083 8.94138 19.1336 12.0001 19.1336C13.3148 19.1336 14.5465 18.7781 15.6033 18.1577L19.5119 21.3575Z"
                                fill="#28B446" />
                            <path
                                d="M19.6596 2.76262L15.7721 5.94525C14.6783 5.26153 13.3853 4.86656 12 4.86656C8.87213 4.86656 6.21431 6.88017 5.25169 9.68175L1.34245 6.48131H1.3418C3.33895 2.63077 7.36223 0 12 0C14.9117 0 17.5814 1.03716 19.6596 2.76262Z"
                                fill="#F14336" />
                        </g>
                        <defs>
                            <clipPath id="clip0_2185_1326">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    @lang('Continue with Google')
                </a>
            </div>
        @endif

        @if (@gs('socialite_credentials')->facebook->status == Status::ENABLE)
            <div class="social-login-btn">
                <a href="{{ route('user.social.login', 'facebook') }}" class="btn social-login-link fs-18 w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <g clip-path="url(#clip0_2185_1311)">
                            <path
                                d="M24 12C24 17.9897 19.6116 22.9542 13.875 23.8542V15.4688H16.6711L17.2031 12H13.875V9.74906C13.875 8.79984 14.34 7.875 15.8306 7.875H17.3438V4.92188C17.3438 4.92188 15.9703 4.6875 14.6573 4.6875C11.9166 4.6875 10.125 6.34875 10.125 9.35625V12H7.07812V15.4688H10.125V23.8542C4.38844 22.9542 0 17.9897 0 12C0 5.37281 5.37281 0 12 0C18.6272 0 24 5.37281 24 12Z"
                                fill="#1877F2" />
                            <path
                                d="M16.6711 15.4688L17.2031 12H13.875V9.74902C13.875 8.80003 14.3399 7.875 15.8306 7.875H17.3438V4.92188C17.3438 4.92188 15.9705 4.6875 14.6576 4.6875C11.9165 4.6875 10.125 6.34875 10.125 9.35625V12H7.07812V15.4688H10.125V23.8542C10.736 23.95 11.3621 24 12 24C12.6379 24 13.264 23.95 13.875 23.8542V15.4688H16.6711Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_2185_1311">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    @lang('Continue with Facebook')
                </a>
            </div>
        @endif
        @if (@gs('socialite_credentials')->linkedin->status == Status::ENABLE)
            <div class="social-login-btn">
                <a href="{{ route('user.social.login', 'linkedin') }}" class="btn social-login-link fs-18 w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 152 152"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <g data-name="Layer 2">
                                <g data-name="10.linkedin">
                                    <circle cx="76" cy="76" r="76" fill="#0b69c7" opacity="1" data-original="#0b69c7" class=""></circle>
                                    <g fill="#fff">
                                        <path d="M59 48.37A10.38 10.38 0 1 1 48.63 38 10.38 10.38 0 0 1 59 48.37z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path>
                                        <rect width="16.06" height="50.93" x="40.6" y="63.07" rx="2.57" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></rect>
                                        <path
                                            d="M113.75 89.47v22.17a2.36 2.36 0 0 1-2.36 2.36H99.67a2.36 2.36 0 0 1-2.36-2.36V90.16c0-3.21.93-14-8.38-14-7.22 0-8.69 7.42-9 10.75v24.78a2.36 2.36 0 0 1-2.34 2.31H66.25a2.35 2.35 0 0 1-2.36-2.36v-46.2a2.36 2.36 0 0 1 2.36-2.37h11.34A2.37 2.37 0 0 1 80 65.44v4c2.68-4 6.66-7.12 15.13-7.12 18.73-.01 18.62 17.52 18.62 27.15z"
                                            fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                    @lang('Continue with LinkedIn')
                </a>
            </div>
        @endif
    </div>
@endif
