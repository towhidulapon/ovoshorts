<div class="modal custom--modal fade  fade-in-scale login-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-end p-3 p-lg-4">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body p-4 p-lg-5 ">
                <h3 class="title text-center mb-4">@lang('Log in to') {{ gs('site_name') }}</h3>
                <form action="#" method="POST">
                    <div class="social-login-btn">
                        <a href="{{ route('user.login') }}" class="btn social-login-link fs-18 w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M260.52 329.539a24 24 0 0 0 33.941 33.941l90.51-90.51a24 24 0 0 0 0-33.941l-90.51-90.509a24 24 0 0 0-33.941 0 24 24 0 0 0 0 33.941L310.059 232H48a24 24 0 0 0-24 24 24 24 0 0 0 24 24h262.059z" fill="CurrentColor" opacity="1" data-original="CurrentColor" class=""></path>
                                    <path d="M448 24H224a40 40 0 0 0-40 40v32a24 24 0 0 0 48 0V72h208v368H232v-24a24 24 0 0 0-48 0v32a40 40 0 0 0 40 40h224a40 40 0 0 0 40-40V64a40 40 0 0 0-40-40z" fill="CurrentColor" opacity="1" data-original="CurrentColor" class=""></path>
                                </g>
                            </svg>
                            @lang('Go to Login Page')
                        </a>
                    </div>
                    <div class="d-flex align-items-center my-2">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-muted fw-semibold">@lang('OR')</span>
                        <hr class="flex-grow-1">
                    </div>
                    <div class="social-login-btn">
                        @include($activeTemplate . 'partials.social_login')
                    </div>
                </form>
            </div>

            <div class="login-modal__footer">
                <div class="login-modal__footer__text">
                    <p class="fs-14">
                        @lang('By continuing with an account located in') <a href="#" class="link fw-700">Bangladesh</a>,
                        @lang('you agree to our') <a href="#" class="link fw-700">Terms of Services</a> @lang('and acknowledge that
                        you have read our') <a href="#" class="link fw-700">Privacy Policy</a>.
                    </p>
                </div>
                <div class="login-have-account">
                    <p class="login-have-account__text">@lang('Don’t have an Account?') <a href="{{ route('user.register') }}" class="login-have-account__link text--base fw-700">@lang('Sign Up')</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>