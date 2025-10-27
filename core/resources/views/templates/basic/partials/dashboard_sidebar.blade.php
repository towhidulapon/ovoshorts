@if (request()->routeIs('user.dashboard.analytics.post'))

    @php
    $user = auth()->user();
    $shorts = App\Models\Short::where('user_id', $user->id)->withCount('likes', 'comments')->orderBy('id', 'desc')->get();
    @endphp

    <div class="dashboard-sidebar-menu flex-between">
        <div class="dashboard-sidebar-menu__inner">
            <span class="sidebar-menu__close d-lg-none d-block"><i class="fas fa-times"></i></span>

            <div class="dashboard-sidebar__header">
                <div class="dashboard-sidebar-logo">
                    <a href="{{ route('user.dashboard.home') }}"> <img src="{{ siteLogo('dark') }}" alt="img"> </a>
                </div>

                <div class="dashboard-sidebar-back-btn">
                    <a href="{{ route('user.dashboard.post') }}" class="sidebar-back"><i class="las la-angle-left"></i> @lang('Back')</a>
                </div>
            </div>
            <ul class="post-content-list">
                @foreach ($shorts as $short)
                    <li class="post-content-list__item">
                        <a href="{{ route('user.dashboard.analytics.post', $short->id) }}" class="post-content-list__item-link">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('coverImage') . '/' . $short->cover_image) }}" class="fit-image" alt="img">
                            </div>
                            <div class="content">
                                <h6 class="title">{{ __(strLimit($short->description)) }}</h6>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@else
    <div class="dashboard-sidebar-menu flex-between">
        <div class="dashboard-sidebar-menu__inner">
            <span class="sidebar-menu__close d-lg-none d-block"><i class="fas fa-times"></i></span>

            <div class="dashboard-sidebar__header">
                <div class="dashboard-sidebar-logo">
                    <a href="{{ route('user.home') }}"> <img src="{{ siteLogo('dark') }}" alt="img"> </a>
                </div>

                <div class="dashboard-sidebar-btn">
                    <a href="{{route('user.short.upload.index')}}" class="btn btn--base w-100"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path d="M12.501 5.5V19.502" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M19.502 12.502H5.5" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>@lang('Upload')</a>
                </div>
            </div>
            <ul class="dashboard-sidebar-menu-list">
                <li class="menu-title">@lang('MANAGE')</li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('user.home') ? 'active' : '' }}">
                    <a href="{{ route('user.home') }}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10.7435 2.34168L17.9062 7.99639C18.1758 8.20929 18.3332 8.53391 18.3332 8.8775C18.3332 9.49758 17.8306 10.0002 17.2105 10.0002H16.6665V12.9168C16.6665 15.2738 16.6665 16.4523 15.9343 17.1846C15.202 17.9168 14.0235 17.9168 11.6665 17.9168H8.33317C5.97615 17.9168 4.79764 17.9168 4.0654 17.1846C3.33317 16.4523 3.33317 15.2738 3.33317 12.9168V10.0002H2.78914C2.16913 10.0002 1.6665 9.49758 1.6665 8.8775C1.6665 8.53391 1.82384 8.20929 2.0935 7.99639L9.25617 2.34168C9.46792 2.17445 9.72992 2.0835 9.99984 2.0835C10.2698 2.0835 10.5318 2.17445 10.7435 2.34168Z" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12.0832 17.9168V14.1668C12.0832 13.388 12.0832 12.9986 11.9157 12.7085C11.806 12.5185 11.6482 12.3607 11.4582 12.251C11.1681 12.0835 10.7787 12.0835 9.99984 12.0835C9.221 12.0835 8.83159 12.0835 8.5415 12.251C8.3515 12.3607 8.19368 12.5185 8.08397 12.7085C7.9165 12.9986 7.9165 13.388 7.9165 14.1668V17.9168" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></span>
                        <span class="text">@lang('Home')</span>
                    </a>
                </li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('user.dashboard.post') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard.post')}}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M6.66651 5.8343H13.9582C15.7138 5.8343 16.5916 5.8343 17.2221 6.25575C17.4951 6.4382 17.7295 6.67264 17.9118 6.9457C18.3162 7.55097 18.3325 8.384 18.3332 10.0022V10.8357M9.99984 5.8343L9.472 4.77827C9.03467 3.90338 8.635 3.02275 7.6659 2.65922C7.24143 2.5 6.75653 2.5 5.78674 2.5C4.273 2.5 3.51615 2.5 2.94823 2.81702C2.5434 3.04301 2.20935 3.37714 1.98344 3.78209C1.6665 4.35017 1.6665 5.10726 1.6665 6.62143V9.16858C1.6665 13.0981 1.6665 15.0628 2.8869 16.2836C3.92091 17.3179 5.4889 17.4759 8.33317 17.5" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M15.8335 15.4167L17.0379 16.2196C17.6082 16.5998 17.8934 16.7899 18.1134 16.6722C18.3335 16.5544 18.3335 16.2117 18.3335 15.5263V14.4737C18.3335 13.7883 18.3335 13.4456 18.1134 13.3278C17.8934 13.2101 17.6082 13.4002 17.0379 13.7804L15.8335 14.5833M15.8335 15.4167V14.5833M15.8335 15.4167C15.8335 16.1955 15.8335 16.5849 15.666 16.875C15.5563 17.065 15.3985 17.2228 15.2085 17.3325C14.9184 17.5 14.529 17.5 13.7502 17.5H13.3335C12.155 17.5 11.5657 17.5 11.1996 17.1339C10.8335 16.7677 10.8335 16.1785 10.8335 15C10.8335 13.8215 10.8335 13.2322 11.1996 12.8661C11.5657 12.5 12.155 12.5 13.3335 12.5H13.7502C14.529 12.5 14.9184 12.5 15.2085 12.6675C15.3985 12.7772 15.5563 12.935 15.666 13.125C15.8335 13.4151 15.8335 13.8045 15.8335 14.5833" stroke="#D9DEE3" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text">@lang('Post')</span>
                    </a>
                </li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('user.dashboard.analytics', 'user.dashboard.analytics.content', 'user.dashboard.analytics.viewers') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard.analytics')}}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5.8335 14.1668V10.8335" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M10 14.1668V5.8335" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M14.1665 14.1665V9.1665" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M2.0835 10.0002C2.0835 6.26821 2.0835 4.40224 3.24286 3.24286C4.40224 2.0835 6.26821 2.0835 10.0002 2.0835C13.7321 2.0835 15.5981 2.0835 16.7575 3.24286C17.9168 4.40224 17.9168 6.26821 17.9168 10.0002C17.9168 13.7321 17.9168 15.5981 16.7575 16.7575C15.5981 17.9168 13.7321 17.9168 10.0002 17.9168C6.26821 17.9168 4.40224 17.9168 3.24286 16.7575C2.0835 15.5981 2.0835 13.7321 2.0835 10.0002Z" stroke="#D9DEE3" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text">@lang('Analytics')</span>
                    </a>
                </li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
                    <a href="{{ route('user.transactions')}}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M294.152 190.12c-8.599-12.323-30.223-21.481-58.485-12.92-25.951 7.861-37.579 49.624-3.732 65.675 5.311 2.519 18.921 7.896 39.455 15.195 45.958 16.337 47.469 77.038-7.076 81.829-18.175 1.597-44.092-3.317-57.883-20.534M253.754 341.812v14.144M253.754 156.044v16.815M253.403 450.306h233.403M462.625 479.847 492 450.306l-29.375-29.541M254.532 61.694H25.194M49.375 32.153 20 61.694l29.375 29.541" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="#d9dee3" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" opacity="1" class=""></path>
                                    <path d="M440.16 206c-21.937-83.082-97.237-144.306-186.757-144.306-106.709 0-193.214 86.994-193.214 194.306s86.505 194.306 193.214 194.306c89.52 0 164.819-61.224 186.757-144.306" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="#d9dee3" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" opacity="1" class=""></path>
                                </g>
                            </svg>
                        </span>
                        <span class="text">@lang('Transactions')</span>
                    </a>
                </li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('user.withdraw.history') ? 'active' : '' }}">
                    <a href="{{ route('user.withdraw.history')}}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" fill="none" stroke="#d9dee3" stroke-width="40" stroke-linecap="round" stroke-linejoin="round">
                                <g>
                                    <circle cx="256" cy="128" r="72" />
                                    <path d="M256 392V272" />
                                    <path d="M192 336l64-64 64 64" />
                                    <path d="M128 448h256" />
                                    <path d="M128 448v-80" />
                                    <path d="M384 448v-80" />
                                </g>
                            </svg>
                        </span>
                        <span class="text">@lang('Withdraw History')</span>
                    </a>
                </li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('user.deposit.history') ? 'active' : '' }}">
                    <a href="{{ route('user.deposit.history')}}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" fill="none" stroke="#d9dee3" stroke-width="40" stroke-linecap="round" stroke-linejoin="round">
                                <g>
                                    <circle cx="256" cy="128" r="72" />
                                    <path d="M256 200v120" />
                                    <path d="M192 288l64 64 64-64" />
                                    <path d="M128 448h256" />
                                    <path d="M128 448v-80" />
                                    <path d="M384 448v-80" />
                                </g>
                            </svg>

                        </span>
                        <span class="text">@lang('Deposit History')</span>
                    </a>
                </li>
                <li class="dashboard-sidebar-menu-list__item {{ request()->routeIs('ticket.index') ? 'active' : '' }}">
                    <a href="{{ route('ticket.index')}}" class="dashboard-sidebar-menu-list__link">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="m501.541 176.678-20.515-35.803c-5.467-9.542-17.615-12.883-27.194-7.469a19.704 19.704 0 0 1-9.808 2.573c-11.029 0-20.001-8.972-20.001-20.001 0-7.082 3.814-13.708 9.956-17.29 9.488-5.536 12.737-17.689 7.274-27.22l-18.127-31.637C412.614 21.489 395.59 8.337 375.19 2.8c-20.4-5.538-41.736-2.797-60.076 7.718L39.789 168.374C15.302 182.413.056 208.688 0 236.983v76.004c0 11.047 8.954 20.001 20.001 20.001 11.029 0 20.001 8.972 20.001 20.001S31.03 372.99 20.001 372.99C8.954 372.99 0 381.945 0 392.991v39.002c0 44.114 35.89 80.004 80.004 80.004H402.02c44.114 0 80.004-35.89 80.004-80.004v-39.002c0-11.047-8.954-20.001-20.001-20.001-11.029 0-20.001-8.972-20.001-20.001s8.972-20.001 20.001-20.001c11.047 0 20.001-8.954 20.001-20.001v-34.912c30.182-23.886 39.219-67.011 19.517-101.397zm-31.883 52.658c-14.19-22.423-39.195-37.355-67.637-37.355h-49.705c3.442-5.966 3.724-13.544.052-19.95-5.493-9.583-17.716-12.9-27.299-7.406s-12.9 17.715-7.406 27.298c.011.02.025.038.037.058H211.011c-11.047 0-20.001 8.954-20.001 20.001s8.954 20.001 20.001 20.001h191.01c22.057 0 40.002 17.945 40.002 40.002v24.428c-23.282 8.255-40.002 30.5-40.002 56.576s16.72 48.32 40.002 56.576v22.428c0 22.057-17.945 40.002-40.002 40.002H80.004c-22.057 0-40.002-17.945-40.002-40.002v-22.428c23.282-8.255 40.002-30.5 40.002-56.576s-16.72-48.32-40.002-56.576v-24.428c0-22.057 17.945-40.002 40.002-40.002h31.002c11.047 0 20.001-8.954 20.001-20.001s-8.954-20.001-20.001-20.001H80.004c-.339 0-.673.022-1.011.026L335.011 45.22c9.067-5.198 19.615-6.555 29.702-3.816 10.088 2.739 18.506 9.242 23.704 18.314l9.953 17.37c-9.104 10.716-14.351 24.483-14.351 38.889 0 33.086 26.917 60.003 60.003 60.003 3.523 0 7.032-.313 10.483-.926l12.326 21.51c5.938 10.365 6.592 22.329 2.827 32.772z" fill="#d9dee3" opacity="1" data-original="#000000" class=""></path>
                                    <circle cx="332.017" cy="281.986" r="20.001" fill="#d9dee3" opacity="1" data-original="#000000" class=""></circle>
                                    <circle cx="332.017" cy="351.989" r="20.001" fill="#d9dee3" opacity="1" data-original="#000000" class=""></circle>
                                    <circle cx="332.017" cy="421.993" r="20.001" fill="#d9dee3" opacity="1" data-original="#000000" class=""></circle>
                                    <circle cx="300.011" cy="120.975" r="20.001" fill="#d9dee3" opacity="1" data-original="#000000" class=""></circle>
                                </g>
                            </svg>
                        </span>
                        <span class="text">@lang('Support Ticket')</span>
                    </a>
                </li>
            </ul>
        </div>
        <a href="{{ route('home') }}" class="btn sidebar-back-btn"><i class="las la-angle-left"></i> @lang('Back to OvoShorts')</a>
    </div>
@endif