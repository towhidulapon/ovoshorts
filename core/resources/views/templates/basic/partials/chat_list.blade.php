<div class="message-group">
    @foreach ($chatUsers as $user)
        @php
            $lastMessage = \App\Models\Message::where(function ($q) use ($user) {
                $q->where('from_id', auth()->id())
                    ->where('to_id', $user->id)
                    ->orWhere('from_id', $user->id)
                    ->where('to_id', auth()->id());
            })
                ->with('images')
                ->orderBy('last_message_at', 'desc')
                ->first();
        @endphp
        <div class="message-item {{ $activeUser && $user->id == $activeUser->id ? 'active' : '' }}"
            data-user-id="{{ $user->id }}" data-username="{{ $user->username }}"
            data-firstname="{{ $user->firstname }}" data-lastname="{{ $user->lastname }}"
            data-image="{{ $user->image ? getImage(getFilePath('userProfile') . '/' . $user->image) : asset('assets/images/avatar.jpg') }}">
            <div class="message-item__left">
                <div class="message-item__thumb thumb">
                    <img src="{{ $user->image ? getImage(getFilePath('userProfile') . '/' . $user->image) : asset('assets/images/avatar.jpg') }}" alt="img" class="fit-image">
                    @if ($user->is_online)
                        <span class="online-indicator"></span>
                    @endif
                </div>
                <div class="message-item__content d-flex justify-content-between gap-2">
                    <div class="">
                        <h6 class="name">{{ $user->username }}</h6>
                        <div class="desc">
                            <span class="desc-text last-message-content fw-bold">
                                @if ($lastMessage)
                                    @if ($lastMessage->images->isNotEmpty())
                                        @php
                                            $isVideo = $lastMessage->images->contains('is_video', 1);
                                        @endphp
                                        @if ($isVideo)
                                            {{ $lastMessage->from_id == auth()->id() ? __('Sent a video') : __('Received a video') }}
                                        @else
                                            {{ $lastMessage->from_id == auth()->id() ? __('Sent a photo') : __('Received a photo') }}
                                        @endif
                                    @else
                                        {{ Str::limit($lastMessage->message, 20) }}
                                    @endif
                                @else
                                    @lang('No messages yet')
                                @endif
                            </span>
                            <span class="date">{{ diffForHumans($lastMessage?->last_message_at) }}</span>
                        </div>

                    </div>
                    <div>
                        @if (isset($unreadCounts[$user->id]) && $unreadCounts[$user->id] > 0)
                            @if ($unreadCounts[$user->id] < 10)
                                <span class="badge badge--base">{{ $unreadCounts[$user->id] }}</span>
                            @else
                                <span class="badge badge--base">10+</span>
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
