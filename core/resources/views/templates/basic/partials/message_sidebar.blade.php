<div class="message-sidebar">
    <div class="sidebar-left__header">
        <div class="sidebar-left__header-top message-header d-flex gap-2 justify-content-between">
            <h4 class="titel">@lang('Messages')</h4>
            <button type="button" class="common-action-close d-flex d-md-none"><i class="las la-times"></i></button>
            
        </div>
        <div class="message-search mt-3 px-3">
                <div class="input-group-custom">
                    <span class="input-group-custom__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M11.5 2C16.75 2 21 6.25 21 11.5C21 16.75 16.75 21 11.5 21C6.25 21 2 16.75 2 11.5C2 7.8 4.11 4.6 7.2 3.03" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M22 22L20 20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input class="input-group-custom__input form-control form--control" type="search" name="search" value="" placeholder="Search">
                </div>
            </div>
    </div>

    <div class="message-sidebar__body chat-list">
        @include('Template::partials.chat_list', ['chatUsers' => $chatUsers, 'activeUser' => $activeUser, 'unreadCounts' => $unreadCounts ?? [],
        ])
    </div>
</div>