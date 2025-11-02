@extends($activeTemplate . 'layouts.message_frontend')
@section('content')
    <div class="home-body message-body overflow-hidden">
        <div class="mobile-top-menu d-flex d-md-none">
            <div class="mobile-top-menu__inner">
                <button class="menu-button">
                    <span class="menu-button-line"></span>
                    <span class="menu-button-line"></span>
                    <span class="menu-button-line"></span>
                </button>
                <div class="search-form-wrapper">
                    <div class="header-btn-group align-center gap-4">
                        <button class="sm-message-box d-md-none d-block" type="button">
                            <i class="las la-envelope"></i>
                        </button>
                    </div>
                    <button class="search-close d-none" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="chat-box">
            <div class="chat-box__header chat-header {{ $activeUser ? '' : 'd-none' }}">
                <div class="chat-author">
                    <div class="thumb">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $activeUser?->image) }}" alt="img"
                            class="fit-image">
                            @if($activeUser && $activeUser->is_online)
                                <span class="online-indicator"></span>
                            @endif
                    </div>
                    <div class="content">
                        <h4 class="name">{{ $activeUser?->firstname . ' ' . $activeUser?->lastname }}</h4>
                        <span class="username">@ {{ $activeUser?->username }}</span>
                    </div>
                </div>
            </div>

            <div class="chat-box__thread message_wrapper" id="message2">

                <div class="text-center my-2 d-none" id="loading-indicator">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">@lang('Loading messages...')</span>
                    </div>
                </div>

                @if (!$activeUser)
                    @include('Template::user.message.empty')
                @elseif ($messages->isEmpty())
                    <div class="empty-message">
                        <div class="empty-message__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M40.7482 7.59472C46.8201 7.19109 53.1667 7.19026 59.2513 7.59472C78.2788 8.85955 93.3759 24.2191 94.6172 43.4267C94.8493 47.02 94.8493 50.7367 94.6172 54.33C93.3759 73.5375 78.2788 88.8971 59.2513 90.1621C53.1667 90.5663 46.8201 90.5654 40.7482 90.1621C38.3943 90.0054 35.8321 89.4488 33.5763 88.52C32.5842 88.1113 31.9108 87.835 31.418 87.6542C31.0792 87.8871 30.6292 88.2179 29.9738 88.7013C26.672 91.1358 22.5035 92.8438 16.5879 92.7L16.3973 92.6954C15.2561 92.6679 14.0397 92.6392 13.0477 92.4471C11.8528 92.2158 10.3745 91.6379 9.44929 90.0604C8.44229 88.3438 8.84604 86.6075 9.23666 85.5142C9.60533 84.4821 10.2444 83.2717 10.8972 82.0354L10.9867 81.8658C12.9298 78.1838 13.4711 75.1746 12.4322 73.1683C8.96416 67.9333 5.84433 61.4817 5.38216 54.33C5.14996 50.7367 5.14996 47.02 5.38216 43.4267C6.6235 24.2191 21.7205 8.85955 40.7482 7.59472ZM32.2913 39.5833C32.2913 41.3092 33.6905 42.7083 35.4163 42.7083H49.9997C51.7255 42.7083 53.1247 41.3092 53.1247 39.5833C53.1247 37.8575 51.7255 36.4583 49.9997 36.4583H35.4163C33.6905 36.4583 32.2913 37.8575 32.2913 39.5833ZM32.2913 60.4167C32.2913 62.1425 33.6905 63.5417 35.4163 63.5417H64.583C66.3088 63.5417 67.708 62.1425 67.708 60.4167C67.708 58.6908 66.3088 57.2917 64.583 57.2917H35.4163C33.6905 57.2917 32.2913 58.6908 32.2913 60.4167Z"
                                    fill="#2E2E2E" />
                            </svg>
                        </div>
                    </div>
                @else
                    @foreach ($messages as $message)
                        @include('Template::user.message.single_message', [
            'message' => $message,
            'currentUserId' => auth()->id(),
        ])
                    @endforeach
                @endif
            </div>

            <div class="chat-footer {{ $activeUser ? '' : 'd-none' }}">
                <div class="chat-box__footer">
                    <div class="chat-send-area">
                        <div class="chat-send-field">
                            <form method="POST" class="send__msg no-submit-loader" enctype="multipart/form-data"
                                id="messageForm">
                                @csrf
                                <div class="image-preview-container d-none mb-2"></div>
                                <div class="d-flex gap-2 align-center">
                                    <div class="input-group position-relative">


                                        <input id="message" class="form--control" name="message"
                                            placeholder="@lang('Type your message here ...')" />
                                        <div class="avatar-preview">
                                            <div class="avatar-edit">
                                                <input class="profilePicUpload" id="profilePicUpload1" name="media[]"
                                                    type='file' multiple accept=".png, .jpg, .jpeg, .mp4, .mov, .webm" />
                                                <label class="btn mb-0" for="profilePicUpload1"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M2 12.96V15C2 20 4 22 9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9"
                                                            stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M15.5 9.75C16.3284 9.75 17 9.07843 17 8.25C17 7.42157 16.3284 6.75 15.5 6.75C14.6716 6.75 14 7.42157 14 8.25C14 9.07843 14.6716 9.75 15.5 9.75Z"
                                                            stroke="CurrentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M8.5 9.75C9.32843 9.75 10 9.07843 10 8.25C10 7.42157 9.32843 6.75 8.5 6.75C7.67157 6.75 7 7.42157 7 8.25C7 9.07843 7.67157 9.75 8.5 9.75Z"
                                                            stroke="CurrentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M8.4 13.3H15.6C16.1 13.3 16.5 13.7 16.5 14.2C16.5 16.69 14.49 18.7 12 18.7C9.51 18.7 7.5 16.69 7.5 14.2C7.5 13.7 7.9 13.3 8.4 13.3Z"
                                                            stroke="CurrentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="chating-btn" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M22 2L11 13" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="chat-skeleton" class="d-none">
            @for ($i = 0; $i <= 15; $i++)
                @php $isRight = $i % 2 === 0; @endphp
                <div class="single-message {{ $isRight ? 'message--right' : 'message--left' }} skeleton-message">
                    <div class="message-content-outer">
                        <div class="message-content-author">
                            @if ($isRight)
                                <div class="thumb skeleton-avatar"></div>
                                <div class="message-content skeleton-bubble"></div>
                            @else
                                <div class="thumb skeleton-avatar"></div>
                                <div class="message-content skeleton-bubble"></div>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection

@push('style')
    <style>
        .thumb {
            position: relative;
        }

        .online-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background-color: #4CAF50;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .image-preview-container {
            display: flex;
            justify-content: flex-start;
        }

        .image-preview-wrapper {
            position: relative;
            display: inline-block;
        }

        .previewImg {
            object-fit: cover;
            border-radius: 4px;
            padding: 5px;
        }

        .remove-image {
            top: -10px;
            right: -10px;
            padding: 2px 6px;
            font-size: 12px;
            line-height: 1;
        }

        .avatar-edit {
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .skeleton-message {
            opacity: 0.8;
            margin-bottom: 12px;
        }

        .skeleton-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #3a3a3a;
            flex-shrink: 0;
            animation: skeleton-loading 1.5s infinite;
        }

        .skeleton-bubble {
            min-width: 120px;
            max-width: 220px;
            height: 32px;
            border-radius: 10px;
            background: #3a3a3a;
            margin: 0 10px;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% {
                background-color: #3a3a3a;
            }

            50% {
                background-color: #4a4a4a;
            }

            100% {
                background-color: #3a3a3a;
            }
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/pusher.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/broadcasting.js') }}"></script>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";
            var userId = '{{ $user?->id }}';
            var toId = '{{ $activeUser?->id }}';
            var currentChannel = null;
            var currentPage = 1;
            var hasMorePages = true;
            var isLoading = false;

            var onlineStatusChannels = {};
            var onlineStatusUpdateInterval;

            function updateOnlineStatus() {
                $.post('{{ route("user.message.online.status") }}', {
                    _token: '{{ csrf_token() }}'
                });
            }

            function subscribeToUserOnlineStatus(userId) {
                if (onlineStatusChannels[userId]) {
                    return;
                }

                const channelName = `private-user-online-status.${userId}`;
                console.log('Subscribing to online status channel:', channelName);

                const channel = pusher.subscribe(channelName);
                onlineStatusChannels[userId] = channel;

                channel.bind('pusher:subscription_succeeded', function() {
                    console.log(`Subscribed to ${channelName}`);
                });

                channel.bind('pusher:subscription_error', function(error) {
                    console.error(`Subscription error for ${channelName}:`, error);
                });

                channel.bind('user.online.status.changed', function(data) {
                    console.log('Online status changed:', data);
                    updateOnlineStatusIndicator(data.user_id, data.is_online);
                });
            }

            function updateOnlineStatusIndicator(userId, isOnline) {
                const $chatItem = $(`.message-item[data-user-id="${userId}"]`);
                if ($chatItem.length) {
                    const $indicator = $chatItem.find('.online-indicator');
                    if (isOnline) {
                        if (!$indicator.length) {
                            $chatItem.find('.thumb').append('<span class="online-indicator"></span>');
                        }
                    } else {
                        $indicator.remove();
                    }
                }

                if (userId == toId) {
                    const $headerIndicator = $('.chat-header .online-indicator');
                    if (isOnline) {
                        if (!$headerIndicator.length) {
                            $('.chat-header .thumb').append('<span class="online-indicator"></span>');
                        }
                    } else {
                        $headerIndicator.remove();
                    }
                }
            }

            function startOnlineStatusUpdates() {
                updateOnlineStatus();

                onlineStatusUpdateInterval = setInterval(updateOnlineStatus, 120000);
            }

            function stopOnlineStatusUpdates() {
                if (onlineStatusUpdateInterval) {
                    clearInterval(onlineStatusUpdateInterval);
                }
            }

            function loadOlderMessages() {
                if (isLoading || !hasMorePages) return;
                isLoading = true;
                $('#loading-indicator').removeClass('d-none');
                $.get("{{ route('user.message.fetch') }}", {
                        userId: toId,
                        page: currentPage + 1
                    }, function(response) {
                        if (response.html) {
                            const messageWrapper = $('.message_wrapper');
                            const oldScrollHeight = messageWrapper[0].scrollHeight;
                            const oldScrollTop = messageWrapper.scrollTop();
                            messageWrapper.prepend(response.html);
                            currentPage++;
                            hasMorePages = response.hasMorePages;
                            const newScrollHeight = messageWrapper[0].scrollHeight;
                            messageWrapper.scrollTop(oldScrollTop + (newScrollHeight - oldScrollHeight));
                        }
                    })
                    .always(function() {
                        isLoading = false;
                        $('#loading-indicator').addClass('d-none');
                    });
            }

            $('.message_wrapper').on('scroll', function() {
                if ($(this).scrollTop() === 0 && !isLoading) {
                    loadOlderMessages();
                }
            });

            const GLOBAL_CHANNEL = `private-user-${userId}`;
            function setupGlobalSubscription() {
                const SOCKET_ID = pusher.connection.socket_id;
                pusher.config.authEndpoint = makeAuthEndPointForPusher(SOCKET_ID, GLOBAL_CHANNEL);
                var globalChannel = pusher.subscribe(GLOBAL_CHANNEL);
                console.log('Subscribing to global channel:', GLOBAL_CHANNEL);
                globalChannel.bind('pusher:subscription_succeeded', function() {
                    console.log('Subscribed to global channel');
                    globalChannel.bind('receive-message', function(data) {
                        console.log('Global message received:', data);
                        refreshSidebar();
                    });
                });
            }

            if (pusher.connection.state === 'connected') {
                setupGlobalSubscription();
            } else {
                pusher.connection.bind('connected', setupGlobalSubscription);
            }

            function updatePusherConnection(newToId) {
                if (currentChannel) {
                    pusher.unsubscribe(currentChannel);
                    currentChannel = null;
                }
                toId = newToId;
                const CHANNEL_NAME = `private-receive-message-${userId}-${toId}`;
                console.log('Updating Pusher connection for channel:', CHANNEL_NAME);
                function setupChannelSubscription() {
                    const SOCKET_ID = pusher.connection.socket_id;
                    pusher.config.authEndpoint = makeAuthEndPointForPusher(SOCKET_ID, CHANNEL_NAME);
                    currentChannel = pusher.subscribe(CHANNEL_NAME);
                    console.log('Subscribing to chat channel:', CHANNEL_NAME);
                    console.log('Socket ID:', SOCKET_ID);
                    currentChannel.bind('pusher:subscription_succeeded', function() {
                        console.log('Subscribed to chat channel:', CHANNEL_NAME);
                        currentChannel.bind('receive-message', function(data) {
                            console.log('Chat message received:', data);
                            if (data.receiver == userId) {
                                messageReceived(data);
                            }
                        });
                    });
                }
                if (pusher.connection.state === 'connected') {
                    setupChannelSubscription();
                } else {
                    pusher.connection.bind('connected', setupChannelSubscription);
                }

                if (newToId) {
                    subscribeToUserOnlineStatus(newToId);
                }
            }

            if (toId) {
                updatePusherConnection(toId);
            }

            function messageReceived(data) {
                if (data.receiver == userId) {
                    if (data.sender == toId) {
                        $('.message_wrapper').append(data.html);
                        scrollToBottom();
                        $.post('{{ route('user.message.mark.as.read') }}', {
                            user_id: data.sender,
                            _token: '{{ csrf_token() }}'
                        }, function() {
                            refreshSidebar();
                        });
                    } else {
                        refreshSidebar();
                    }
                }
            }

            function scrollToBottom() {
                const messageWrapper = $('.message_wrapper');
                const images = messageWrapper.find('img');
                if (images.length === 0) {
                    messageWrapper.scrollTop(messageWrapper[0].scrollHeight);
                    return;
                }
                let loadedImages = 0;
                const totalImages = images.length;
                function checkAllLoaded() {
                    loadedImages++;
                    if (loadedImages === totalImages) {
                        messageWrapper.scrollTop(messageWrapper[0].scrollHeight);
                    }
                }
                images.each(function() {
                    const img = this;
                    if (img.complete) {
                        checkAllLoaded();
                    } else {
                        img.addEventListener('load', checkAllLoaded);
                        img.addEventListener('error', checkAllLoaded);
                    }
                });
            }

            function refreshSidebar() {
                $.get('{{ route('user.message.sidebar') }}', {
                    activeUserId: toId
                }, function(response) {
                    if (typeof response === 'object' && response.view) {
                        $('.chat-list').html(response.view);
                    } else {
                        $('.chat-list').html(response);
                    }
                    if (toId) {
                        $(`.message-item[data-user-id="${toId}"]`).addClass('active');
                    }

                    $('.message-item').each(function() {
                        const userId = $(this).data('user-id');
                        if (userId) {
                            subscribeToUserOnlineStatus(userId);
                        }
                    });
                });
            }

            $('#profilePicUpload1').on('change', function() {
                const input = this;
                const files = input.files;
                const $previewContainer = $('.image-preview-container');
                $previewContainer.empty().removeClass('d-none');
                if (files && files.length > 0) {
                    Array.from(files).forEach((file, index) => {
                        const isVideo = file.type.startsWith('video/');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const $wrapper = $(
                                '<div class="image-preview-wrapper position-relative d-inline-block"></div>'
                            );
                            let $media;
                            if (isVideo) {
                                $media = $('<video class="previewImg" muted></video>').attr('src', e
                                    .target.result);
                            } else {
                                $media = $('<img class="previewImg" alt="Preview" />').attr('src', e
                                    .target.result);
                            }
                            const $removeBtn = $(
                                    '<button type="button" class="remove-image btn btn-sm btn-danger position-absolute">x</button>'
                                )
                                .data('index', index);
                            $wrapper.append($media).append($removeBtn);
                            $previewContainer.append($wrapper);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    $previewContainer.addClass('d-none');
                }
            });

            $(document).on('click', '.remove-image', function() {
                const $wrapper = $(this).closest('.image-preview-wrapper');
                const index = $(this).data('index');
                const input = $('#profilePicUpload1')[0];
                const files = Array.from(input.files);
                const dt = new DataTransfer();
                files.forEach((file, i) => {
                    if (i !== index) dt.items.add(file);
                });
                input.files = dt.files;
                $wrapper.remove();
                if ($('.image-preview-wrapper').length === 0) {
                    $('.image-preview-container').addClass('d-none');
                }
            });

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                let message = $('#message').val().trim();
                let hasMedia = $('#profilePicUpload1')[0].files.length > 0;
                if (!message && !hasMedia) {
                    notify('error', 'Please enter a message or attach a file');
                    return;
                }
                let formData = new FormData(this);
                formData.append('to_id', toId);
                formData.append('active_user_id', toId);
                $.ajax({
                    url: '{{ route('user.message.send') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.data && response.data.success) {
                            $('#message').val('');
                            $('#profilePicUpload1').val('');
                            $('.image-preview-container').addClass('d-none');
                            $('.message_wrapper').append(response.data.html);
                            scrollToBottom();
                            refreshSidebar();
                        } else {
                            notify('error', 'Failed to send message');
                        }
                    }
                });
            });

            $('#message').on('keydown', function(e) {
                if (e.key == 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    $('#messageForm').trigger('submit');
                }
            });

            $('body').on('click', ".message-item", function() {
                $('.message-item').removeClass('active');
                $(this).addClass('active');
                var newUserId = $(this).data('user-id');
                var username = $(this).data('username');
                var firstname = $(this).data('firstname');
                var lastname = $(this).data('lastname');
                var image = $(this).data('image');
                $('.chat-header').removeClass('d-none');
                $('.chat-footer').removeClass('d-none');
                $('.chat-author .thumb img').attr('src', image);
                $('.chat-author .name').text(firstname + ' ' + lastname);
                $('.chat-author .username').text('@' + username);
                updatePusherConnection(newUserId);
                console.log('Switching to user:', newUserId);
                toId = newUserId;
                currentPage = 1;
                hasMorePages = true;
                $('#message2').html($('#chat-skeleton').html());
                var url = "{{ route('user.message.fetch') }}?userId=" + newUserId + "&page=1";
                console.log('Fetching messages from:', url);
                $.get(url, function(response) {
                    console.log('Response received:', response);
                    if (response.html) {
                        currentPage = 1;
                        hasMorePages = response.hasMorePages;
                        $('#message2').html(response.html);
                        scrollToBottom();
                        $.post('{{ route('user.message.mark.as.read') }}', {
                            user_id: newUserId,
                            _token: '{{ csrf_token() }}'
                        }, function() {
                            refreshSidebar();
                        });
                    }
                })
            });

            $(document).ready(function() {
                scrollToBottom();

                startOnlineStatusUpdates();

                $('.message-item').each(function() {
                    const userId = $(this).data('user-id');
                    if (userId) {
                        subscribeToUserOnlineStatus(userId);
                    }
                });

                if (toId) {
                    subscribeToUserOnlineStatus(toId);
                }
            });

            $(window).on('beforeunload', function() {
                stopOnlineStatusUpdates();
            });
        })(jQuery);
    </script>
@endpush