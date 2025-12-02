@forelse ($users as $user)
        @php
    $short = $user->shorts->first();
    $fileUrl = $short?->fileUrl;
    $extension = $short?->extension;
    $poster = $short
        ? getImage(getFilePath('coverImage') . '/' . $short->cover_image)
        : asset($activeTemplateTrue . 'images/default.png');
        @endphp

        <div class="explore-item">
            <div class="explore-item__video">
                <video class="video-player" playsinline preload="metadata" muted loop poster="{{ $poster }}">
                    <source src="{{ $fileUrl }}" type="video/{{ $extension }}">
                </video>

                <div class="follower-profile">
                    <div class="follower-profile__thumb">
                        <img src="{{ $user->image ? getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) : asset('assets/images/avatar.jpg') }}" alt="image" class="fit-image">
                    </div>
                    <div class="follower-profile__author">
                        <a href="{{ route('user.profile', $user->username) }}" class="name">{{ $user->firstname }} {{ $user->lastname }}</a>
                        <span class="following-username">{{ $user->username }}</span>
                        <div class="following-btn">
                            <button class="btn btn-danger follow-btn" data-id="{{ $user->id }}" data-action="unfollow">
                                @lang('Unfollow')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@empty
 @if(!request()->has('page') || request()->get('page') == 1)
    <x-empty-message message="No user found" />
 @endif
@endforelse