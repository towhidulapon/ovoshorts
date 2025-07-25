@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')

    <div class="dashboard-body upload-step1">
        <div class="dashboard-body__bar d-lg-none d-block">
            <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
        </div>

        <div class="video-upload-card">
            <div class="video-upload-card__wrapper">
                <div class="video-upload-card__icon flex-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
                        <path d="M32.6666 42.6667C32.6666 40.0893 34.756 38 37.3333 38H48C50.5773 38 52.6666 40.0893 52.6666 42.6667V44L57.7722 40.8779C58.3922 40.5677 59.1285 40.6011 59.7181 40.9653C60.3077 41.3299 60.6666 41.9736 60.6666 42.6667V53.3333C60.6666 54.0264 60.3077 54.6701 59.7181 55.0347C59.1285 55.3989 58.3922 55.4323 57.7722 55.1221L52.6666 52V53.3333C52.6666 55.9107 50.5773 58 48 58H37.3333C34.756 58 32.6666 55.9107 32.6666 53.3333V42.6667Z" fill="#6F56FC" />
                        <path d="M33.0435 16.6519L26.396 7.85352C25.514 6.68616 24.1357 6 22.6726 6H8.00004C5.42271 6 3.33337 8.08933 3.33337 10.6667V50.6667C3.33337 54.7168 6.61663 58 10.6667 58H30.8347C29.8899 56.6864 29.3334 55.0749 29.3334 53.3333V42.6667C29.3334 38.2483 32.915 34.6667 37.3334 34.6667H48C50.9739 34.6667 53.5691 36.2896 54.9478 38.6979L56.2816 37.8963C57.663 37.2056 59.2611 37.1539 60.6667 37.7224V23.9852C60.6667 19.9351 57.3835 16.6519 53.3334 16.6519H33.0435Z" fill="#6F56FC" />
                    </svg>
                </div>
                <div class="video-upload-card__content text-center">
                    <h5 class="video-upload-card__title">@lang('Select video to upload')</h5>
                    <p class="video-upload-card__desc">@lang('or drag and drop it here')</p>
                    <div class="avatar-edit seller-cover-photo">
                        <input class="profilePicUpload" id="profilePicUpload1" name="video" accept="video/*" type="file" required>
                        <label class="btn mb-0 btn--base" for="profilePicUpload1">@lang('Select video')</label>
                    </div>
                </div>
            </div>
            <div class="video-upload-card__list">
                <div class="video-upload-card__item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17.9933 9.38334C17.9826 8.47732 17.9515 7.69419 17.8619 7.02777C17.8573 6.99366 17.8526 6.95971 17.8477 6.92591C18.3059 6.56563 18.7204 6.26203 19.0944 6.03609C19.7947 5.61301 20.6822 5.25874 21.5929 5.71019C22.4895 6.15463 22.7673 7.06553 22.8829 7.88282C22.9991 8.70445 22.9991 9.81011 22.999 11.1382V12.8645C22.9991 14.1926 22.9991 15.2982 22.8829 16.1198C22.7673 16.9371 22.4895 17.848 21.5929 18.2925C20.6822 18.7439 19.7947 18.3896 19.0944 17.9666C18.7204 17.7406 18.3059 17.437 17.8477 17.0768C17.8526 17.0431 17.8574 17.0092 17.8619 16.9752C17.9515 16.3087 17.9826 15.5255 17.9933 14.6193C18.951 15.4085 19.6124 15.9429 20.1285 16.2547C20.3999 16.4186 20.5637 16.4778 20.6531 16.4955C20.6728 16.4994 20.6863 16.5007 20.6942 16.5012C20.6982 16.5014 20.7027 16.5013 20.7027 16.5013L20.7047 16.5005C20.709 16.4984 20.7108 16.4966 20.7108 16.4966C20.7136 16.4936 20.7286 16.4774 20.7499 16.4358C20.7977 16.3422 20.8567 16.1641 20.9026 15.8397C20.9966 15.1754 20.999 14.2135 20.999 12.7832V11.2194C20.999 9.78915 20.9966 8.82725 20.9026 8.16294C20.8567 7.83855 20.7977 7.66044 20.7499 7.56691C20.7286 7.52522 20.714 7.50949 20.7112 7.50653C20.7112 7.50653 20.709 7.50427 20.7047 7.50211L20.7032 7.50139C20.7032 7.50139 20.6982 7.5013 20.6942 7.5015C20.6863 7.50191 20.6728 7.50322 20.6531 7.50713C20.5637 7.52483 20.3999 7.58402 20.1285 7.74796C19.6124 8.05977 18.951 8.59417 17.9933 9.38334Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.92797 3H10.072C11.6606 2.99997 12.9539 2.99995 13.9737 3.13706C15.0377 3.28011 15.9527 3.58869 16.682 4.31802C17.4113 5.04736 17.7199 5.96232 17.8629 7.0263C18.0001 8.04616 18 9.33933 18 10.928V13.072C18 14.6607 18.0001 15.9538 17.8629 16.9737C17.7199 18.0377 17.4113 18.9527 16.682 19.682C15.9527 20.4113 15.0377 20.7199 13.9737 20.8629C12.9538 21.0001 11.6607 21 10.072 21H8.928C7.33933 21 6.04616 21.0001 5.0263 20.8629C3.96232 20.7199 3.04736 20.4113 2.31802 19.682C1.58869 18.9527 1.28011 18.0377 1.13706 16.9737C0.999949 15.9539 0.999973 14.6607 1 13.0721V10.9279C0.999973 9.33929 0.999949 8.04614 1.13706 7.0263C1.28011 5.96232 1.58869 5.04736 2.31802 4.31802C3.04736 3.58869 3.96232 3.28011 5.0263 3.13706C6.04614 2.99995 7.33933 2.99997 8.92797 3ZM11 7C10.4477 7 10 7.44772 10 8C10 8.55229 10.4477 9 11 9H13C13.5523 9 14 8.55229 14 8C14 7.44772 13.5523 7 13 7H11Z" fill="white" />
                    </svg>
                    <div class="content">
                        <h4>@lang('Size and duration')</h4>
                        <p>@lang('Maximum size'): 30 @lang('GB'), @lang('video duration'): 60 @lang('minutes.')</p>
                    </div>
                </div>

                <div class="video-upload-card__item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M7.14203 2.25C8.02697 2.25 8.86433 2.64949 9.41958 3.33658L10.8985 5.16666H15.9142C16.5634 5.16665 17.1089 5.16664 17.5553 5.20301C18.0221 5.24103 18.4657 5.32361 18.8867 5.53754C19.5288 5.86378 20.0509 6.38434 20.3781 7.02461C20.5926 7.44447 20.6754 7.8868 20.7136 8.35222C20.75 8.79736 20.75 9.34133 20.75 9.98868V11C20.75 11.537 20.3135 11.9722 19.775 11.9722C19.2365 11.9722 18.8 11.537 18.8 11V10.0278C18.8 9.33111 18.7992 8.86709 18.77 8.51056C18.7417 8.16538 18.6917 8.00743 18.6406 7.90737C18.5004 7.63297 18.2766 7.40987 18.0015 7.27006C17.9011 7.21907 17.7427 7.16919 17.3966 7.14099C17.039 7.11186 16.5737 7.11111 15.875 7.11111H10.432C10.1371 7.11111 9.85794 6.97794 9.67286 6.74891L7.90122 4.55663C7.71613 4.3276 7.43701 4.19444 7.14203 4.19444H6.6603C5.93904 4.19444 5.45137 4.19501 5.07353 4.2216C4.7056 4.24749 4.51521 4.29457 4.38071 4.35215C3.9214 4.54878 3.55536 4.91379 3.35816 5.37178C3.30066 5.50534 3.25328 5.69648 3.22725 6.06509C3.20056 6.44282 3.2 6.92925 3.2 7.64488V18.7778C3.2 19.3148 2.76348 19.75 2.225 19.75C1.68652 19.75 1.25 19.3148 1.25 18.7778V7.61045C1.24999 6.93783 1.24998 6.38263 1.28207 5.92846C1.31534 5.45744 1.38658 5.02214 1.56632 4.60468C1.96071 3.68869 2.6928 2.95868 3.61141 2.56542C4.02949 2.38643 4.46387 2.31523 4.93624 2.28198C5.39091 2.24998 5.94775 2.24999 6.62538 2.25H7.14203Z" fill="white" />
                        <path d="M20.3201 10.3679C21.1491 10.4898 21.8892 10.7615 22.3622 11.4571C22.8359 12.1536 22.8144 12.9409 22.6198 13.7542C22.432 14.5395 22.0405 15.5138 21.5612 16.7069C21.2077 17.587 20.582 19.1443 20.2833 19.702C19.9714 20.2844 19.6166 20.7557 19.0967 21.1061C18.577 21.4565 18.0065 21.6092 17.3484 21.6811C16.7179 21.7501 15.9426 21.7501 14.9903 21.75H6.82564C5.53439 21.7501 4.48102 21.7501 3.67955 21.6322C2.85055 21.5103 2.11046 21.2386 1.63746 20.543C1.16382 19.8465 1.18526 19.0592 1.37984 18.2459C1.56772 17.4605 2.29668 15.6461 2.77606 14.453C3.12961 13.5729 3.41769 12.8558 3.71637 12.2981C4.02829 11.7157 4.38309 11.2444 4.90302 10.8939C5.42272 10.5436 5.99323 10.3909 6.65124 10.319C7.28177 10.25 8.05707 10.25 9.00939 10.25H17.174C18.4652 10.25 19.5187 10.25 20.3201 10.3679Z" fill="white" />
                    </svg>
                    <div class="content">
                        <h4>@lang('File formats')</h4>
                        <p>@lang('Recommended: “.mp4”. Other major formats are supported.')</p>
                    </div>
                </div>

                <div class="video-upload-card__item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.5513 2.25C13.466 2.24999 14.9981 2.24998 16.2284 2.37265C16.1184 2.66396 16.0393 2.86304 15.9856 2.97967C15.8249 3.05365 15.502 3.18172 15.003 3.36637L14.3059 3.6243C13.5211 3.91473 13 4.66312 13 5.5C13 6.33688 13.5211 7.08528 14.3059 7.3757L15.003 7.63363C15.502 7.81828 15.8237 7.94554 15.9844 8.01953C16.0584 8.18016 16.1817 8.49803 16.3664 8.99705L16.6243 9.69407C16.9147 10.4789 17.6631 11 18.5 11C19.3369 11 20.0853 10.4789 20.3757 9.69407L20.6336 8.99705C20.8183 8.49803 20.9455 8.18016 21.0195 8.01953C21.1362 7.96581 21.3357 7.884 21.6273 7.77253C21.75 9.017 21.75 10.6421 21.75 12.5572C21.75 14.7479 21.75 16.4686 21.5694 17.812C21.3843 19.1886 20.9973 20.2809 20.1391 21.1391C19.2809 21.9973 18.1886 22.3843 16.812 22.5694C15.4686 22.75 13.6335 22.75 11.4428 22.75C9.2521 22.75 7.53144 22.75 6.18802 22.5694C4.81137 22.3843 3.71911 21.9973 2.86091 21.1391C2.00272 20.2809 1.61568 19.1886 1.43059 17.812C1.24998 16.4686 1.24999 14.7479 1.25 12.5572C1.24999 10.3665 1.24998 8.53144 1.43059 7.18802C1.61568 5.81137 2.00272 4.71911 2.86091 3.86091C3.71911 3.00272 4.81137 2.61568 6.18802 2.43059C7.53144 2.24998 9.36061 2.24999 11.5513 2.25ZM12.7629 15.2288C14.4333 14.2165 15.2686 13.7104 15.4453 12.9941C15.5182 12.6984 15.5182 12.3874 15.4453 12.0917C15.2686 11.3754 14.4333 10.8693 12.7629 9.85699C11.148 8.8784 10.3406 8.3891 9.68992 8.58578C9.4209 8.6671 9.1758 8.82153 8.97812 9.03426C8.5 9.54881 8.5 10.5468 8.5 12.5429C8.5 14.5389 8.5 15.537 8.97812 16.0515C9.1758 16.2643 9.4209 16.4187 9.68992 16.5C10.3406 16.6967 11.148 16.2074 12.7629 15.2288Z" fill="white" />
                        <path d="M18.5 1.25C18.8138 1.25 19.0945 1.4454 19.2034 1.73972L19.4613 2.43675C19.8233 3.4151 19.9388 3.68091 20.1289 3.87106C20.3191 4.06121 20.5849 4.17667 21.5633 4.53869L22.2603 4.79661C22.5546 4.90552 22.75 5.18617 22.75 5.5C22.75 5.81383 22.5546 6.09448 22.2603 6.20339L21.5633 6.46131C20.5849 6.82333 20.3191 6.93879 20.1289 7.12894C19.9388 7.31909 19.8233 7.5849 19.4613 8.56325L19.2034 9.26028C19.0945 9.5546 18.8138 9.75 18.5 9.75C18.1862 9.75 17.9055 9.5546 17.7966 9.26028L17.5387 8.56325C17.1767 7.5849 17.0612 7.31909 16.8711 7.12894C16.6809 6.93879 16.4151 6.82333 15.4367 6.46131L14.7397 6.20339C14.4454 6.09448 14.25 5.81383 14.25 5.5C14.25 5.18617 14.4454 4.90552 14.7397 4.79661L15.4367 4.53869C16.4151 4.17667 16.6809 4.06121 16.8711 3.87106C17.0612 3.68091 17.1767 3.4151 17.5387 2.43675L17.7966 1.73972C17.9055 1.4454 18.1862 1.25 18.5 1.25Z" fill="white" />
                    </svg>
                    <div class="content">
                        <h4>@lang('Video resolution')</h4>
                        <p>@lang('High-resolution recommended: 1080p, 1440p, 4K.')</p>
                    </div>
                </div>

                <div class="video-upload-card__item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2975 16.0039H8.70099C8.59113 16.0039 8.47711 16.0039 8.38011 16.0099C8.27651 16.0163 8.12848 16.032 7.97269 16.0952C7.49843 16.2878 7.20125 16.7416 7.17886 17.2308C7.17154 17.3908 7.20121 17.5311 7.22718 17.6322C7.25169 17.7276 7.2869 17.8382 7.32204 17.9486C7.44422 18.3335 7.57107 18.7331 7.73075 18.9966C7.97324 19.3967 8.31935 19.7194 8.72961 19.9277L8.81818 20.3719C8.90919 20.8314 8.99149 21.2469 9.18893 21.5958C9.49156 22.1305 9.98794 22.5433 10.5904 22.7423C10.9856 22.8728 11.5348 22.872 11.9977 22.8712C12.4607 22.872 13.0099 22.8728 13.405 22.7423C14.0075 22.5433 14.5039 22.1305 14.8065 21.5958C15.004 21.2469 15.0863 20.8314 15.1773 20.3719L15.2655 19.9293C15.6772 19.7211 16.0244 19.3977 16.2676 18.9966C16.4272 18.7331 16.5541 18.3335 16.6763 17.9486C16.7114 17.8382 16.7466 17.7276 16.7711 17.6322C16.7971 17.5311 16.8268 17.3908 16.8194 17.2308C16.7971 16.7416 16.4999 16.2878 16.0256 16.0952C15.8698 16.032 15.7218 16.0163 15.6182 16.0099C15.5212 16.0039 15.4073 16.0039 15.2975 16.0039ZM13.3201 20.1881H10.6753C10.7593 20.594 10.7885 20.6837 10.8225 20.7439C10.9103 20.8989 11.0464 21.0057 11.1954 21.0549C11.2554 21.0747 11.3516 21.0866 11.9977 21.0866C12.6438 21.0866 12.7401 21.0747 12.8 21.0549C12.9491 21.0057 13.0852 20.8989 13.1729 20.7439C13.207 20.6837 13.2362 20.594 13.3201 20.1881Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.625C8.9916 6.625 6.5 9.14999 6.5 12.3309C6.5 13.186 6.68072 13.994 7.00304 14.7185C7.22753 15.2231 7.00045 15.8142 6.49585 16.0387C5.99124 16.2632 5.4002 16.0361 5.17571 15.5315C4.74122 14.5548 4.5 13.4701 4.5 12.3309C4.5 8.10466 7.8287 4.625 12 4.625C16.1713 4.625 19.5 8.10466 19.5 12.3309C19.5 13.4701 19.2588 14.5548 18.8243 15.5315C18.5998 16.0361 18.0088 16.2632 17.5042 16.0387C16.9996 15.8142 16.7725 15.2231 16.997 14.7185C17.3193 13.994 17.5 13.186 17.5 12.3309C17.5 9.14999 15.0084 6.625 12 6.625Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.125C12.5523 1.125 13 1.57272 13 2.125V3.125C13 3.67728 12.5523 4.125 12 4.125C11.4477 4.125 11 3.67728 11 3.125V2.125C11 1.57272 11.4477 1.125 12 1.125ZM19.7774 4.34685C20.1679 4.73737 20.1679 5.37054 19.7774 5.76106L19.0703 6.46817C18.6798 6.85869 18.0466 6.85869 17.6561 6.46817C17.2656 6.07764 17.2656 5.44448 17.6561 5.05395L18.3632 4.34685C18.7537 3.95632 19.3869 3.95632 19.7774 4.34685ZM4.22251 4.34726C4.61303 3.95674 5.24619 3.95674 5.63672 4.34726L6.34383 5.05437C6.73435 5.44489 6.73435 6.07806 6.34383 6.46858C5.9533 6.85911 5.32014 6.85911 4.92961 6.46858L4.22251 5.76147C3.83198 5.37095 3.83198 4.73779 4.22251 4.34726ZM1 12.125C1 11.5727 1.44772 11.125 2 11.125H3C3.55228 11.125 4 11.5727 4 12.125C4 12.6773 3.55228 13.125 3 13.125H2C1.44772 13.125 1 12.6773 1 12.125ZM20 12.125C20 11.5727 20.4477 11.125 21 11.125H22C22.5523 11.125 23 11.5727 23 12.125C23 12.6773 22.5523 13.125 22 13.125H21C20.4477 13.125 20 12.6773 20 12.125Z" fill="white" />
                    </svg>
                    <div class="content">
                        <h4>@lang('Video resolution')</h4>
                        <p>@lang('Recommended: 16:9 for landscape, 9:16 for vertical.')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-body d-none upload-step2">
        <div class="dashboard-body__bar d-lg-none d-block">
            <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
        </div>
        <div class="video-upload__item">
            <div class="video-upload__item__inner">
                <div class="video-upload__content">
                    <div class="d-flex gap-2 align-items-start">
                        <div class="">
                            <span class="video-upload__filename">
                            </span>
                            <div class="video-upload__status">
                                <span class="video-upload__uploaded">

                                </span>
                            </div>
                        </div>
                        <span class="video-upload__badge"></span>
                    </div>
                    <button class="video-upload__replace">
                        <i class="fas fa-sync-alt"></i>@lang('Replace')
                    </button>
                </div>

            </div>
            <div class="video-upload__progress">
                <div class="video-upload__progress-bar" style="width: 80%;"></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="video-upload-edit">
                <div class="video-edit-card__wrapper">
                    <div class="video-edit-card">
                        <div class="video-edit-card-tabs">
                            <ul class="nav nav-pills custom--tab" id="pills-tab" role="tablist">
                                <li class="nav-item flex-grow-1" role="presentation">
                                    <button class="nav-link active w-100" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">@lang('Feed')</button>
                                </li>
                                <li class="nav-item flex-grow-1 " role="presentation">
                                    <button class="nav-link w-100" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">@lang('Web/TV')</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                    <div class="explore-item">
                                        <div class="explore-item__video">
                                            <video class="video-player" playsinline preload="metadata" data-video_id="223" controls poster="assets/images/thumbs/edit-preview.png">
                                                <source src="assets/images/video/v2.mp4" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                    <div class="explore-item">
                                        <div class="explore-item__video">
                                            <video class="video-player" playsinline preload="metadata" data-video_id="223" controls poster="assets/images/thumbs/edit-preview.png">
                                                <source src="assets/images/video/v2.mp4" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn video-edit-card__button w-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <g clip-path="url(#clip0_2203_2461)">
                                <path d="M24 5.52855C22.891 3.94478 20.6861 3.5274 19.1021 4.63637L10.9572 10.3394L7.99548 8.26539C9.09826 6.36142 8.57954 3.89762 6.74345 2.61212C4.80451 1.25491 2.13306 1.72591 0.775274 3.66447C-0.581898 5.60312 -0.111273 8.27514 1.82771 9.63292C3.15821 10.5645 4.83413 10.6344 6.19313 9.9602L9.8207 12.5001L6.19346 15.0398C4.83446 14.3659 3.15863 14.4358 1.82804 15.367C-0.110851 16.7248 -0.581523 19.3966 0.775602 21.3352C2.13338 23.2741 4.80512 23.7451 6.74373 22.3878C8.57959 21.1023 9.09821 18.6385 7.99576 16.7346L10.9575 14.6605L19.102 20.3633C20.6861 21.4726 22.891 21.0549 24 19.4711L14.0432 12.5001L24 5.52855ZM4.29502 8.35342C3.06816 8.35342 2.07352 7.35878 2.07352 6.13192C2.07352 4.90506 3.06821 3.91042 4.29502 3.91042C5.52216 3.91042 6.51652 4.90506 6.51652 6.13192C6.51652 7.35878 5.52216 8.35342 4.29502 8.35342ZM4.29502 21.09C3.06816 21.09 2.07352 20.0954 2.07352 18.8685C2.07352 17.6417 3.06816 16.647 4.29502 16.647C5.52216 16.647 6.51652 17.6417 6.51652 18.8685C6.51652 20.0953 5.52216 21.09 4.29502 21.09Z" fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2203_2461">
                                    <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                                </clipPath>
                            </defs>
                        </svg> Edit Video</button>
                </div>
                <div class="video-upload-edit__details">
                    <div class="video-upload-edit__item mb-4">
                        <h4 class="title-heading">Details</h4>
                        <div class="video-upload-edit__item-card">
                            <h6 class="title">Description</h6>
                            <div class="video-upload-form">
                                <textarea class="form-control form--control" placeholder="Description"></textarea>
                                <div class="video-upload-tags">
                                    <div class="video-upload-tags__left">
                                        <button class="btn video-upload-tags__button">#Hashtags</button>
                                        <button class="btn video-upload-tags__button">@Mention</button>
                                    </div>
                                    <div class="video-upload-tags__right">
                                        <span>49/4000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="video-edit-cover">
                                <h6 class="video-edit-cover__title">
                                    Cover <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <g clip-path="url(#clip0_2101_1027)">
                                            <path d="M10.0001 18.3333C14.6025 18.3333 18.3334 14.6023 18.3334 9.99996C18.3334 5.39759 14.6025 1.66663 10.0001 1.66663C5.39771 1.66663 1.66675 5.39759 1.66675 9.99996C1.66675 14.6023 5.39771 18.3333 10.0001 18.3333Z" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10 13.3333V10" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10 6.66663H10.0083" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2101_1027">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </h6>
                                <div class="video-edit-cover__thumb">
                                    <img class="fit-image" src="assets/images/thumbs/cover.png" alt="image">
                                    <button class="video-edit-cover__edit ">
                                        @lang('Edit cover')
                                    </button>
                                </div>
                            </div>
                            <div class="video-edit-location">
                                <h6 class="video-edit-location__title">
                                    Location <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <g clip-path="url(#clip0_2101_1027)">
                                            <path d="M10.0001 18.3333C14.6025 18.3333 18.3334 14.6023 18.3334 9.99996C18.3334 5.39759 14.6025 1.66663 10.0001 1.66663C5.39771 1.66663 1.66675 5.39759 1.66675 9.99996C1.66675 14.6023 5.39771 18.3333 10.0001 18.3333Z" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10 13.3333V10" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M10 6.66663H10.0083" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2101_1027">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </h6>
                                <div class="video-edit-location__form common-form-wrapper">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M14.5 9C14.5 10.3807 13.3807 11.5 12 11.5C10.6193 11.5 9.5 10.3807 9.5 9C9.5 7.61929 10.6193 6.5 12 6.5C13.3807 6.5 14.5 7.61929 14.5 9Z" stroke="#9DA4AF" stroke-width="1.5" />
                                            <path d="M13.2574 17.4936C12.9201 17.8184 12.4693 18 12.0002 18C11.531 18 11.0802 17.8184 10.7429 17.4936C7.6543 14.5008 3.51519 11.1575 5.53371 6.30373C6.6251 3.67932 9.24494 2 12.0002 2C14.7554 2 17.3752 3.67933 18.4666 6.30373C20.4826 11.1514 16.3536 14.5111 13.2574 17.4936Z" stroke="#9DA4AF" stroke-width="1.5" />
                                            <path d="M18 20C18 21.1046 15.3137 22 12 22C8.68629 22 6 21.1046 6 20" stroke="#9DA4AF" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <select name="location" id="" class="form--control form--select select2">
                                        <option value="">Search Locations</option>
                                        <option value="">Select Location</option>
                                        <option value="">Select Location</option>
                                        <option value="">Select Location</option>
                                        <option value="">Select Location</option>
                                    </select>
                                </div>
                            </div>
                            <div class="video-edit-tags">
                                <button class="btn video-edit-tags__button">The Bubbles</button>
                                <button class="btn video-edit-tags__button">Welcome To Bangladesh</button>
                                <button class="btn video-edit-tags__button">Ok Bangladesh</button>
                                <button class="btn video-edit-tags__button">24k</button>
                                <button class="btn video-edit-tags__button">Dhaka a Capital City</button>
                                <button class="btn video-edit-tags__button">Dhakaiya</button>
                                <button class="btn video-edit-tags__button">My Home</button>
                                <button class="btn video-edit-tags__button">Cox’s Bazazar</button>
                                <button class="btn video-edit-tags__button">100 Miles</button>
                            </div>
                        </div>
                    </div>

                    <div class="video-upload-edit__item">
                        <h4 class="title-heading">Settings</h4>
                        <div class="video-upload-edit__item-card">
                            <h6 class="title">When to post</h6>
                            <div class="post-schedule">
                                <div class="form-check form--radio">
                                    <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault1">
                                    <label class="form-check-label" for="radioDefault1">
                                        Now
                                    </label>
                                </div>
                                <div class="form-check form--radio">
                                    <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault2">
                                    <label class="form-check-label" for="radioDefault2">
                                        Schedule
                                    </label>
                                </div>
                            </div>
                            <div class="video-edit-watch-video">
                                <h6 class="video-edit-location__title">
                                    Who can watch this video
                                </h6>
                                <div class="common-form-wrapper">
                                    <select name="location" id="" class="form--control form--select common-form-wrapper select2">
                                        <option value="">Everyone</option>
                                        <option value="">Friends</option>
                                        <option value="">Only Me</option>
                                    </select>
                                </div>
                            </div>
                            <div class="video-edit-user">
                                <h6 class="video-edit-location__title">
                                    Allow users to:
                                </h6>

                                <div class="video-edit-user__check">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" value="" id="comment">
                                        <label class="form-check-label" for="comment">Comment</label>
                                    </div>
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" value="" id="Duet">
                                        <label class="form-check-label" for="Duet">Duet</label>
                                    </div>
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" value="" id="Stitch">
                                        <label class="form-check-label" for="Stitch">Stitch</label>
                                    </div>
                                </div>
                            </div>
                            <div class="video-edit-switch">
                                <div class="video-edit-switch__item">
                                    <div class="video-edit-switch__item-heading">
                                        <h6 class="title">
                                            Disclose post content
                                        </h6>
                                        <div class="form-check form--switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                                        </div>
                                    </div>
                                    <p class="desc">
                                        Let others know this post promotes a brand, product or service.
                                    </p>
                                </div>
                                <div class="video-edit-switch__item">
                                    <div class="video-edit-switch__item-heading">
                                        <h6 class="title">
                                            AI-generated content
                                        </h6>
                                        <div class="form-check form--switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                                        </div>
                                    </div>
                                    <p class="desc">
                                        Add this label for aigc. <a href="#" class="link-text"> Learn more</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="video-edit-btn-group mt-4 flex-wrap gap-2">
                        <button class="btn btn--base btn-post">Post</button>
                        <button class="btn btn-dark">Discard</button>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@push('script')

    <script>
        (function ($) {
            "use strict";

            const $uploadStep1 = $('.upload-step1');
            const $uploadStep2 = $('.upload-step2');
            const $fileInput = $('.profilePicUpload');
            const $filenameSpan = $uploadStep2.find('.video-upload__filename');
            const $uploadedSpan = $uploadStep2.find('.video-upload__uploaded');
            const $qualitySpan = $uploadStep2.find('.video-upload__badge');
            const $progressBar = $uploadStep2.find('.video-upload__progress-bar');
            const $replaceBtn = $uploadStep2.find('.video-upload__replace');
            const $videoPlayers = $('.video-player');
            let uploadedVideoUrl = '';

            const CHUNK_SIZE = 5 * 1024 * 1024;

            $fileInput.on('change', function () {
                const file = this.files[0];
                if (!file) return;

                $uploadStep1.addClass('d-none');
                $uploadStep2.removeClass('d-none');
                $filenameSpan.text(file.name);
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                $uploadedSpan.text('Uploading...');
                $qualitySpan.text(getVideoQuality(file.name));
                $progressBar.css('width', '0%');

                const extension = file.name.split('.').pop().toLowerCase();
                const uniqueId = Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                const totalChunks = Math.ceil(file.size / CHUNK_SIZE);

                function uploadChunk(index) {
                    const start = index * CHUNK_SIZE;
                    const end = Math.min(start + CHUNK_SIZE, file.size);
                    const chunk = file.slice(start, end);

                    const formData = new FormData();
                    formData.append('extension', extension);
                    formData.append('fileName', file.name);
                    formData.append('index', index);
                    formData.append('uniqueId', uniqueId);
                    formData.append('chunk', chunk);

                    $.ajax({
                        url: '{{ route("user.short.upload.file") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            const percent = Math.round(((index + 1) / totalChunks) * 100);
                            $progressBar.css('width', percent + '%');
                            if (index + 1 < totalChunks) {
                                uploadChunk(index + 1);
                            } else {
                                assembleChunks(uniqueId, file.name, extension);
                            }
                        },
                        error: function (xhr) {
                            $uploadedSpan.text('Upload failed!');
                            console.log(xhr.responseText);
                        }
                    });
                }

                function assembleChunks(uniqueId, fileName, extension) {
                    $.ajax({
                        url: '{{ route("user.short.upload.assemble.file") }}',
                        type: 'POST',
                        data: {
                            uniqueId: uniqueId,
                            fileName: fileName,
                            extension: extension,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            if (res.status === 'success') {
                                $uploadedSpan.text('✔ Uploaded (' + sizeMB + 'MB)');
                                uploadedVideoUrl = res.video_url;
                                $('.video-url-input').val(uploadedVideoUrl);
                                $videoPlayers.each(function () {
                                    $(this).find('source').attr('src', uploadedVideoUrl);
                                    this.load();
                                });
                            } else {
                                $uploadedSpan.text('Assembly failed!');
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            $uploadedSpan.text('Assembly failed!');
                        }
                    });
                }

                uploadChunk(0);
            });

            $replaceBtn.on('click', function () {
                $fileInput.val('');
                $uploadStep2.addClass('d-none');
                $uploadStep1.removeClass('d-none');
                $filenameSpan.text('');
                $uploadedSpan.text('');
                $qualitySpan.text('');
                $progressBar.css('width', '0%');
                uploadedVideoUrl = '';
                $('.video-url-input').val('');
                $videoPlayers.each(function () {
                    $(this).find('source').attr('src', '');
                    this.load();
                });
            });

            function getVideoQuality(filename) {
                filename = filename.toLowerCase();
                if (filename.includes('4k')) return '4K';
                if (filename.includes('1440')) return '1440P';
                if (filename.includes('1080')) return '1080P';
                return 'HD';
            }

            $('.video-edit-cover__edit').on('click', function () {
                const video = $videoPlayers[0];
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataURL = canvas.toDataURL('image/png');
                $('.video-edit-cover__thumb .fit-image').attr('src', dataURL);
                $('.cover-image-input').val(dataURL);
            });

        })(jQuery);
    </script>


@endpush