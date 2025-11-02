@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')
    <div class="dashboard-body">
        <div class="dashboard-body__bar d-lg-none d-block mb-3">
            <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
        </div>

        <div class="post-react mb-4">
            <div class="post-react__left">
                <div class="post-react__thumb">
                    <img class="fit-image" src="{{ getImage(getFilePath('coverImage') . '/' . $short->cover_image, getFileSize('coverImage')) }}" alt="img">
                </div>
                <div class="post-react__content">
                    <h6 class="title">{{ __(strLimit($short->description, 20)) }}</h6>
                    <p class="date">{{ showDateTime($short->post_at) }}</p>
                </div>
            </div>
            <div class="post-react__right">
                <ul class="post-react__social">
                    <li class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M11.6174 5.78089C12.9782 6.55395 14.0476 7.16146 14.8094 7.71795C15.5764 8.27827 16.1437 8.86389 16.3469 9.63605C16.4959 10.2022 16.4959 10.7979 16.3469 11.3641C16.1437 12.1362 15.5764 12.7218 14.8094 13.2821C14.0476 13.8386 12.9782 14.4461 11.6175 15.2192C10.303 15.966 9.19449 16.5957 8.35299 16.9537C7.50474 17.3145 6.7314 17.4974 5.97979 17.2844C5.42743 17.1278 4.92483 16.8307 4.51996 16.4222C3.97048 15.8679 3.74992 15.1016 3.64557 14.1796C3.54198 13.2641 3.54198 12.0659 3.54199 10.5418V10.4583C3.54198 8.93422 3.54198 7.73596 3.64557 6.82059C3.74992 5.89847 3.97048 5.13223 4.51996 4.57784C4.92483 4.16936 5.42743 3.87227 5.97979 3.71574C6.7314 3.50276 7.50474 3.68563 8.35299 4.04643C9.19449 4.40435 10.303 5.03409 11.6174 5.78089Z" fill="#9DA4AF" />
                        </svg>
                        <span>{{ showFormatCount($short->views_count) }}</span>
                    </li>
                    <li class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M16.1827 13.5501C17.6586 11.8533 18.9587 9.79413 18.9587 7.74524C18.9586 5.04331 16.9573 2.79163 14.167 2.79163C12.8405 2.79163 11.5555 3.21886 10.0003 4.63733C8.44516 3.21886 7.16019 2.79163 5.83366 2.79163C3.04329 2.79163 1.04203 5.04331 1.04199 7.74524C1.04199 9.79413 2.34208 11.8533 3.81787 13.5501C5.31661 15.2732 7.10791 16.7474 8.30192 17.6403L8.49557 17.7737C9.48466 18.395 10.7491 18.3503 11.6987 17.6403L12.1732 17.279C13.3363 16.375 14.8714 15.0578 16.1827 13.5501Z" fill="#9DA4AF" />
                        </svg>
                        <span> {{ showFormatCount($short->likes_count) }}</span>
                    </li>
                    <li class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.95057 3.625H7.85407C8.32017 3.625 8.69802 3.98773 8.69802 4.43518C8.69802 4.88264 8.32017 5.24538 7.85407 5.24538H7.01013C5.79277 5.24538 4.96463 5.24709 4.34449 5.32713C3.74862 5.40404 3.47263 5.53964 3.2848 5.71997C3.09696 5.90029 2.95571 6.16524 2.8756 6.73728C2.79221 7.33262 2.79042 8.12762 2.79042 9.29633V12.537C2.79042 13.7058 2.79221 14.5008 2.8756 15.0961C2.95571 15.6681 3.09696 15.9331 3.2848 16.1133C3.47263 16.2937 3.74862 16.4293 4.34449 16.5062C4.96463 16.5863 5.79277 16.588 7.01013 16.588H10.4183C11.6356 16.588 12.4638 16.5863 13.0839 16.5062C13.6798 16.4293 13.9558 16.2937 14.1436 16.1133C14.3886 15.8782 14.5492 15.5048 14.6069 14.5171C14.633 14.0703 15.0314 13.7285 15.4969 13.7536C15.9622 13.7787 16.3183 14.1612 16.2922 14.6079C16.2308 15.6585 16.053 16.5718 15.3371 17.2592C14.7834 17.7908 14.0919 18.0111 13.3089 18.1121C12.5629 18.2084 11.6206 18.2083 10.4778 18.2083H6.9506C5.80779 18.2083 4.86542 18.2084 4.11958 18.1121C3.33655 18.0111 2.645 17.7908 2.09128 17.2592C1.53756 16.7276 1.30804 16.0637 1.20276 15.312C1.10249 14.596 1.10251 13.6913 1.10254 12.5943V9.23908C1.10251 8.14203 1.10249 7.23737 1.20276 6.52136C1.30804 5.76965 1.53756 5.10576 2.09128 4.57419C2.645 4.04263 3.33655 3.82228 4.11958 3.72122C4.86542 3.62495 5.80777 3.62498 6.95057 3.625Z" fill="#9DA4AF" />
                            <path d="M13.7788 2.79163C13.2498 2.79163 12.8209 3.20336 12.8209 3.71125V5.70829H10.4337C7.67707 5.70829 5.44238 7.85359 5.44238 10.5V12.5833C5.44238 12.88 5.65973 13.1359 5.96252 13.1955C6.26453 13.255 6.56849 13.103 6.69088 12.8316C6.72601 12.7657 6.82678 12.5782 6.90482 12.4578C7.06147 12.2162 7.30416 11.8923 7.64423 11.5691C8.31835 10.9285 9.37061 10.2916 10.9294 10.2916H12.8209V12.2886C12.8209 12.7965 13.2498 13.2083 13.7788 13.2083C14.0329 13.2083 14.2765 13.1114 14.4562 12.939L18.3997 9.15321C18.7183 8.84738 18.8973 8.43251 18.8973 7.99996C18.8973 7.56741 18.7183 7.15258 18.3997 6.84673L14.4562 3.06098C14.2765 2.88852 14.0329 2.79163 13.7788 2.79163Z" fill="#9DA4AF" />
                        </svg>
                        <span> {{ showFormatCount($short->shares_count) }}</span>
                    </li>
                    <li class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.792 1.95837H8.20866C4.83026 1.95837 3.14106 1.95837 2.09153 3.01177C1.04199 4.06515 1.04199 5.76055 1.04199 9.15137V9.60096C1.04199 12.9917 1.04199 14.6871 2.09153 15.7405C2.57564 16.2264 3.25646 16.5506 4.1367 16.7132C4.40706 16.7632 4.54223 16.7881 4.60094 16.8729C4.65966 16.9577 4.63554 17.0927 4.58733 17.3626C4.47058 18.0162 4.48903 18.6071 4.90813 18.9205C5.34737 19.2411 6.04727 18.8985 7.44708 18.2135C7.60213 18.1376 7.75773 18.0599 7.91363 17.982L7.916 17.9807C8.74708 17.5653 9.59399 17.142 10.4972 16.9333C10.89 16.8435 11.2899 16.8051 11.792 16.7939C15.1704 16.7939 16.8596 16.7939 17.9092 15.7405C18.9587 14.6871 18.9587 12.9917 18.9587 9.60096V9.15137C18.9587 5.76055 18.9587 4.06515 17.9092 3.01177C16.8596 1.95837 15.1704 1.95837 11.792 1.95837ZM13.9587 11.75C13.9587 12.0952 13.6788 12.375 13.3337 12.375H6.66699C6.32182 12.375 6.04199 12.0952 6.04199 11.75C6.04199 11.4049 6.32182 11.125 6.66699 11.125H13.3337C13.6788 11.125 13.9587 11.4049 13.9587 11.75ZM10.6253 7.58337C10.6253 7.92855 10.3455 8.20837 10.0003 8.20837H6.66699C6.32182 8.20837 6.04199 7.92855 6.04199 7.58337C6.04199 7.2382 6.32182 6.95837 6.66699 6.95837H10.0003C10.3455 6.95837 10.6253 7.2382 10.6253 7.58337Z" fill="#9DA4AF" />
                        </svg>
                        <span>{{ showFormatCount($short->comments_count) }}</span>
                    </li>
                    <li class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M10.0452 1.54163C11.5779 1.54162 12.7897 1.5416 13.7375 1.66438C14.7104 1.7904 15.4993 2.05556 16.1237 2.65715C16.7513 3.26188 17.031 4.03115 17.1633 4.97933C17.2913 5.89704 17.2913 7.06835 17.2913 8.54117V15.5381C17.2913 16.4528 17.2914 17.2127 17.2036 17.7837C17.1127 18.3745 16.9008 18.9495 16.3167 19.2615C15.7958 19.5397 15.2227 19.4831 14.7368 19.3356C14.2454 19.1865 13.7459 18.9157 13.2886 18.6267C12.8268 18.335 12.3278 17.9681 11.9343 17.6772C11.5486 17.3921 11.2388 17.1631 11.0023 17.0207C10.6693 16.8202 10.4591 16.6945 10.2886 16.6142C10.1313 16.5401 10.0549 16.5283 9.99968 16.5283C9.94443 16.5283 9.86801 16.5401 9.71076 16.6142C9.54034 16.6945 9.33009 16.8202 8.99709 17.0207C8.76059 17.1631 8.45084 17.3921 8.06513 17.6772C7.67151 17.9681 7.1725 18.335 6.7108 18.6267C6.25346 18.9157 5.75396 19.1865 5.26254 19.3356C4.77668 19.4831 4.20364 19.5397 3.68266 19.2615C3.09848 18.9495 2.88666 18.3745 2.79578 17.7837C2.70795 17.2127 2.70798 16.4528 2.70801 15.5382V8.54115C2.708 7.06834 2.70798 5.89704 2.83605 4.97933C2.96837 4.03115 3.24801 3.26188 3.87568 2.65715C4.5001 2.05556 5.28894 1.7904 6.26182 1.66438C7.20968 1.5416 8.42143 1.54162 9.95418 1.54163H10.0452Z" fill="#9DA4AF" />
                        </svg>
                        <span> {{ showFormatCount($short->saved_shorts_count) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="dashboard-card mb-4">
            <div class="dashboard-card-wrapper">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('Video views')</span>
                        <h4 class="dashboard-widget__number">{{ showFormatCount($short->views_count)  }}</h4>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('Total play time')</span>
                        <h4 class="dashboard-widget__number">{{ formatPlayTime($short->total_play_time) }}</h4>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('Average watch time')</span>
                        <h4 class="dashboard-widget__number">{{ formatPlayTime($short->views_count > 0 ? $short->total_play_time / $short->views_count : 0) }}</h4>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('Watched full video')</span>
                        <h4 class="dashboard-widget__number">{{ showFormatCount($short->views_count) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-header__title mb-0 text-white">@lang('Most Viewed Countries') <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                    <path d="M10.0003 18.8333C14.6027 18.8333 18.3337 15.1023 18.3337 10.5C18.3337 5.89759 14.6027 2.16663 10.0003 2.16663C5.39795 2.16663 1.66699 5.89759 1.66699 10.5C1.66699 15.1023 5.39795 18.8333 10.0003 18.8333Z" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10 13.8333V10.5" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10 7.16663H10.0083" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="skills-progress-wrapper">
                            <div class="skills">
                                @forelse ($trafficSources as $source)
                                    <div class="skill-item">
                                        <div class="skill-text d-flex justify-content-between">
                                            <p>{{ $source['country'] ?? 'Unknown' }}</p>
                                            <p><span>{{ $source['percentage'] }}</span>%</p>
                                        </div>
                                        <div class="progress-bg-line">
                                            <div class="progress-animated-line" data-progress="{{ $source['percentage'] }}"></div>
                                        </div>
                                    </div>
                                @empty
                                    <x-empty-message message="No shorts found" />
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-header__title mb-0 text-white">@lang('Most Shared Platforms') <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                    <path d="M10.0003 18.8333C14.6027 18.8333 18.3337 15.1023 18.3337 10.5C18.3337 5.89759 14.6027 2.16663 10.0003 2.16663C5.39795 2.16663 1.66699 5.89759 1.66699 10.5C1.66699 15.1023 5.39795 18.8333 10.0003 18.8333Z" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10 13.8333V10.5" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10 7.16663H10.0083" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="skills-progress-wrapper">
                            <div class="skills">
                                @forelse ($platformShares as $source)
                                    <div class="skill-item">
                                        <div class="skill-text d-flex justify-content-between">
                                            <p>{{ $source['platform'] ?? 'Unknown' }}</p>
                                            <p><span>{{ $source['percentage'] }}</span>%</p>
                                        </div>
                                        <div class="progress-bg-line">
                                            <div class="progress-animated-line" data-progress="{{ $source['percentage'] }}"></div>
                                        </div>
                                    </div>
                                @empty
                                    <x-empty-message message="No shorts found" />
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection