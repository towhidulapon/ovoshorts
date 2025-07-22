<div class="dashboard-sidebar-menu flex-between">
    <div class="dashboard-sidebar-menu__inner">
        <span class="sidebar-menu__close d-lg-none d-block"><i class="fas fa-times"></i></span>

        <div class="dashboard-sidebar__header">
            <!-- Sidebar Logo Start -->
            <div class="dashboard-sidebar-logo">
                <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
            </div>
            <!-- Sidebar Logo End -->

            <div class="dashboard-sidebar-btn">
                <a href="#" class="btn btn--base w-100"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path d="M12.501 5.5V19.502" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M19.502 12.502H5.5" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>@lang('Upload')</a>
            </div>
        </div>
        <!-- ========= Sidebar Menu Start ================ -->
        <ul class="dashboard-sidebar-menu-list">
            <li class="menu-title">@lang('MANAGE')</li>
            <li class="dashboard-sidebar-menu-list__item active">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10.7435 2.34168L17.9062 7.99639C18.1758 8.20929 18.3332 8.53391 18.3332 8.8775C18.3332 9.49758 17.8306 10.0002 17.2105 10.0002H16.6665V12.9168C16.6665 15.2738 16.6665 16.4523 15.9343 17.1846C15.202 17.9168 14.0235 17.9168 11.6665 17.9168H8.33317C5.97615 17.9168 4.79764 17.9168 4.0654 17.1846C3.33317 16.4523 3.33317 15.2738 3.33317 12.9168V10.0002H2.78914C2.16913 10.0002 1.6665 9.49758 1.6665 8.8775C1.6665 8.53391 1.82384 8.20929 2.0935 7.99639L9.25617 2.34168C9.46792 2.17445 9.72992 2.0835 9.99984 2.0835C10.2698 2.0835 10.5318 2.17445 10.7435 2.34168Z" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.0832 17.9168V14.1668C12.0832 13.388 12.0832 12.9986 11.9157 12.7085C11.806 12.5185 11.6482 12.3607 11.4582 12.251C11.1681 12.0835 10.7787 12.0835 9.99984 12.0835C9.221 12.0835 8.83159 12.0835 8.5415 12.251C8.3515 12.3607 8.19368 12.5185 8.08397 12.7085C7.9165 12.9986 7.9165 13.388 7.9165 14.1668V17.9168" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg></span>
                    <span class="text">@lang('Home')</span>
                </a>
            </li>
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M6.66651 5.8343H13.9582C15.7138 5.8343 16.5916 5.8343 17.2221 6.25575C17.4951 6.4382 17.7295 6.67264 17.9118 6.9457C18.3162 7.55097 18.3325 8.384 18.3332 10.0022V10.8357M9.99984 5.8343L9.472 4.77827C9.03467 3.90338 8.635 3.02275 7.6659 2.65922C7.24143 2.5 6.75653 2.5 5.78674 2.5C4.273 2.5 3.51615 2.5 2.94823 2.81702C2.5434 3.04301 2.20935 3.37714 1.98344 3.78209C1.6665 4.35017 1.6665 5.10726 1.6665 6.62143V9.16858C1.6665 13.0981 1.6665 15.0628 2.8869 16.2836C3.92091 17.3179 5.4889 17.4759 8.33317 17.5" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M15.8335 15.4167L17.0379 16.2196C17.6082 16.5998 17.8934 16.7899 18.1134 16.6722C18.3335 16.5544 18.3335 16.2117 18.3335 15.5263V14.4737C18.3335 13.7883 18.3335 13.4456 18.1134 13.3278C17.8934 13.2101 17.6082 13.4002 17.0379 13.7804L15.8335 14.5833M15.8335 15.4167V14.5833M15.8335 15.4167C15.8335 16.1955 15.8335 16.5849 15.666 16.875C15.5563 17.065 15.3985 17.2228 15.2085 17.3325C14.9184 17.5 14.529 17.5 13.7502 17.5H13.3335C12.155 17.5 11.5657 17.5 11.1996 17.1339C10.8335 16.7677 10.8335 16.1785 10.8335 15C10.8335 13.8215 10.8335 13.2322 11.1996 12.8661C11.5657 12.5 12.155 12.5 13.3335 12.5H13.7502C14.529 12.5 14.9184 12.5 15.2085 12.6675C15.3985 12.7772 15.5563 12.935 15.666 13.125C15.8335 13.4151 15.8335 13.8045 15.8335 14.5833" stroke="#D9DEE3" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Post')</span>
                </a>
            </li>
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
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
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M6.6665 11.2502H13.3332M6.6665 7.0835H9.99984" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.08218 15.8335C3.99875 15.7269 3.18713 15.4015 2.64281 14.8572C1.6665 13.8809 1.6665 12.3095 1.6665 9.16683V8.75016C1.6665 5.60746 1.6665 4.03612 2.64281 3.0598C3.61913 2.0835 5.19047 2.0835 8.33317 2.0835H11.6665C14.8092 2.0835 16.3806 2.0835 17.3568 3.0598C18.3332 4.03612 18.3332 5.60746 18.3332 8.75016V9.16683C18.3332 12.3095 18.3332 13.8809 17.3568 14.8572C16.3806 15.8335 14.8092 15.8335 11.6665 15.8335C11.1994 15.8439 10.8274 15.8794 10.462 15.9627C9.46334 16.1926 8.53859 16.7036 7.62473 17.1492C6.32258 17.7842 5.6715 18.1017 5.26291 17.8044C4.48125 17.2222 5.24529 15.4184 5.4165 14.5835" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Comments')</span>
                </a>
            </li>
            <li class="menu-title">@lang('TOOLS')</li>
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <g clip-path="url(#clip0_2203_3088)">
                                <path d="M5.07465 12.4992C4.7593 11.7903 4.5835 11.0018 4.5835 10.1708C4.5835 7.08446 7.00862 4.58252 10.0002 4.58252C12.9917 4.58252 15.4168 7.08446 15.4168 10.1708C15.4168 11.0018 15.241 11.7903 14.9257 12.4992" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M10 1.66602V2.49935" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M18.3333 9.99951H17.5" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.49984 9.99951H1.6665" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.892 4.10645L15.3027 4.6957" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.69717 4.69668L4.10791 4.10742" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12.0974 16.088C12.9394 15.8157 13.2771 15.045 13.3721 14.2699C13.4004 14.0383 13.2099 13.8462 12.9766 13.8462L7.06396 13.8464C6.82263 13.8464 6.62882 14.0512 6.65763 14.2908C6.75067 15.0644 6.98551 15.6296 7.8778 16.088M12.0974 16.088C12.0974 16.088 8.02468 16.088 7.8778 16.088M12.0974 16.088C11.9962 17.7089 11.5281 18.3508 10.0056 18.3328C8.37709 18.3629 8.00245 17.5694 7.8778 16.088" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2203_3088">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </span>
                    <span class="text">@lang('Inspirations')</span>
                </a>
            </li>
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M2.0835 10.0002C2.0835 6.26821 2.0835 4.40224 3.24286 3.24286C4.40224 2.0835 6.26821 2.0835 10.0002 2.0835C13.7321 2.0835 15.5981 2.0835 16.7575 3.24286C17.9168 4.40224 17.9168 6.26821 17.9168 10.0002C17.9168 13.7321 17.9168 15.5981 16.7575 16.7575C15.5981 17.9168 13.7321 17.9168 10.0002 17.9168C6.26821 17.9168 4.40224 17.9168 3.24286 16.7575C2.0835 15.5981 2.0835 13.7321 2.0835 10.0002Z" stroke="#D9DEE3" stroke-width="1.5" />
                            <path d="M10.8332 12.0835C10.8332 13.2341 9.90042 14.1668 8.74984 14.1668C7.59925 14.1668 6.6665 13.2341 6.6665 12.0835C6.6665 10.9329 7.59925 10.0002 8.74984 10.0002C9.90042 10.0002 10.8332 10.9329 10.8332 12.0835ZM10.8332 12.0835V5.8335C11.1109 6.25016 11.3332 8.00016 13.3332 8.3335" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Sounds')</span>
                </a>
            </li>
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M16.6668 18.3332H5.00016C4.07969 18.3332 3.3335 17.587 3.3335 16.6665M3.3335 16.6665C3.3335 15.746 4.07969 14.9998 5.00016 14.9998H16.6668V4.99984C16.6668 3.42849 16.6668 2.64281 16.1787 2.15466C15.6905 1.6665 14.9048 1.6665 13.3335 1.6665H8.3335C5.97647 1.6665 4.79796 1.6665 4.06573 2.39874C3.3335 3.13097 3.3335 4.30948 3.3335 6.6665V16.6665Z" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16.2498 15C16.2498 15 15.4165 15.6357 15.4165 16.6667C15.4165 17.6977 16.2498 18.3333 16.2498 18.3333" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.1468 7.696L9.32433 5.93193C9.22141 5.8676 9.1025 5.8335 8.98108 5.8335C8.62341 5.8335 8.3335 6.12344 8.3335 6.4811V10.1859C8.3335 10.5436 8.62341 10.8335 8.98108 10.8335C9.1025 10.8335 9.22141 10.7994 9.32433 10.7351L12.1468 8.971C12.3667 8.83358 12.5002 8.59266 12.5002 8.3335C12.5002 8.0743 12.3667 7.83337 12.1468 7.696Z" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Creator Academy')</span>
                </a>
            </li>
            <li class="menu-title">@lang('OTHERS')</li>
            <li class="dashboard-sidebar-menu-list__item">
                <a href="#" class="dashboard-sidebar-menu-list__link">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M18.3332 10.4166C18.3332 10.0071 18.3288 9.18084 18.32 8.77017C18.2656 6.21555 18.2383 4.93825 17.2958 3.99205C16.3531 3.04586 15.0413 3.0129 12.4175 2.94698C10.8004 2.90635 9.19925 2.90635 7.58219 2.94697C4.95845 3.01289 3.64657 3.04585 2.70396 3.99205C1.76135 4.93824 1.73412 6.21555 1.67964 8.77017C1.66212 9.59159 1.66213 10.4081 1.67965 11.2295C1.73412 13.7842 1.76136 15.0614 2.70397 16.0077C3.64657 16.9538 4.95845 16.9868 7.5822 17.0527C8.25116 17.0695 8.91742 17.0793 9.58317 17.0823" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.8335 7.0835L8.28518 8.533C9.7145 9.37808 10.2858 9.37808 11.7152 8.533L14.1668 7.0835" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11.6665 14.5833H18.3332M11.6665 14.5833C11.6665 13.9998 13.3284 12.9096 13.7498 12.5M11.6665 14.5833C11.6665 15.1668 13.3284 16.2571 13.7498 16.6667" stroke="#D9DEE3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="text">@lang('Feedback')</span>
                </a>
            </li>
        </ul>
        <!-- ========= Sidebar Menu End ================ -->
    </div>
    <a href="{{ route('home') }}" class="btn sidebar-back-btn"><i class="las la-angle-left"></i> @lang('Back to OvoShorts')</a>
</div>