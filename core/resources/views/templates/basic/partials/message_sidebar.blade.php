<div class="message-sidebar">
    <div class="sidebar-left__header">
        <div class="sidebar-left__header-top message-header d-flex gap-2 justify-content-between">
            <h4 class="titel">@lang('Messages')</h4>
            <button type="button" class="common-action-close d-flex d-md-none"><i class="las la-times"></i></button>

        </div>
    </div>

    <div class="message-sidebar__body chat-list">
        @include('Template::partials.chat_list', [
            'chatUsers' => $chatUsers,
            'activeUser' => $activeUser,
            'unreadCounts' => $unreadCounts ?? [],
        ])
    </div>
</div>