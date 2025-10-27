@forelse ($shorts as $short)
    <tr data-post-id="{{ $short->id }}">
        <td data-label="Post">
            <div class="customer ">
                <div class="customer__thumb">
                    <img src="{{ getImage(getFilePath('coverImage') . '/' . $short->cover_image) }}" alt="img">
                </div>
                <div class="customer__content">
                    <h6 class="customer__name">{{ strLimit(__($short->description), 20)}}</h6>
                    <p class="date">{{ showDateTime($short->post_at) }}</p>
                </div>
            </div>

        </td>

        @php
    $privacyOptions = [
        1 => __('Everyone'),
        2 => __('Only Me'),
    ];
    $currentPrivacy = $privacyOptions[$short->is_visible];
        @endphp

        <td data-label="Privacy">
            <div class="dropdown message-item__dropdown">
                <span class="btn dropdown-btn everyone-action-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.06444 17.0712C8.68094 17.2395 9.32994 17.3294 9.99985 17.3294C10.5759 17.3294 11.1364 17.2629 11.6742 17.1372C11.9421 16.6337 12.0645 16.2357 12.1084 15.9183C12.1679 15.4878 12.0899 15.1595 11.9654 14.8545C11.9027 14.7012 11.8167 14.5312 11.7349 14.3693C11.6524 14.2063 11.5554 14.0134 11.4834 13.8111C11.3243 13.3643 11.2827 12.8569 11.5812 12.2849C11.7986 11.8682 12.1138 11.626 12.4914 11.5068C12.7811 11.4155 13.1834 11.3985 13.4388 11.3877C14.0009 11.3621 14.6126 11.3157 15.3634 10.7761C16.0338 10.2943 16.7078 10.159 17.326 10.2231C17.3283 10.1489 17.3294 10.0745 17.3294 9.99982C17.3294 8.33048 16.7713 6.79146 15.8315 5.55919C15.4158 5.71309 15.0114 5.97196 14.6927 6.3844C14.0154 7.26105 13.2891 7.80035 12.5524 8.01716C11.8014 8.23814 11.0927 8.10666 10.5264 7.7402C9.68802 7.19757 9.57969 6.43919 9.50877 5.94259C9.4701 5.6831 9.42327 5.44019 9.35352 5.31115C9.29535 5.20364 9.18977 5.0749 8.9271 4.94738C8.26663 4.62681 7.89234 4.04056 7.7625 3.40897C7.73719 3.2858 7.72091 3.16045 7.71327 3.034C5.04164 3.91045 3.04724 6.28102 2.71815 9.15765C3.16838 9.42074 3.68385 9.59824 4.24045 9.59824C4.79555 9.59824 5.2739 9.62424 5.67569 9.69949C6.07839 9.7749 6.4483 9.90765 6.74868 10.1537C7.37386 10.6656 7.46515 11.4677 7.46515 12.2929C7.46515 13.1421 7.46684 13.4996 7.51243 13.8045C7.55611 14.0966 7.64105 14.3469 7.86354 14.9846C7.99197 15.3527 8.1703 15.8752 8.16011 16.4386C8.1563 16.6492 8.12655 16.8612 8.06444 17.0712ZM1.04246 9.86732C1.04182 9.9114 1.0415 9.95557 1.0415 9.99982C1.0415 14.9474 5.05229 18.9582 9.99985 18.9582C10.6586 18.9582 11.3007 18.8871 11.9189 18.7522L11.9344 18.749C15.554 17.9522 18.352 14.9682 18.8719 11.2517C18.8733 11.2424 18.8744 11.2332 18.8752 11.224C18.9299 10.8237 18.9582 10.4151 18.9582 9.99982C18.9582 5.05229 14.9474 1.0415 9.99985 1.0415C9.96227 1.0415 9.92469 1.04174 9.88727 1.0422C5.03571 1.10194 1.11277 5.01832 1.04246 9.86732Z" fill="CurrentColor" />
                    </svg>
                    {{ $currentPrivacy }} <i class="las la-angle-down"></i>
                </span>
                <ul class="dropdown-menu">
                    @foreach($privacyOptions as $key => $label)
                        @if($key !== $short->is_visible)
                            <li>
                                <span class="dropdown-item" data-value="{{ $key }}">
                                    {{ $label }}
                                </span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </td>
        <td data-label="Views">{{ $short->views_count }}</td>
        <td data-label="Likes">{{ $short->likes_count }}</td>
        <td data-label="Comments">{{ $short->comments_count }}</td>
        <td data-label="Status">@php echo $short->statusBadge @endphp</td>
        <td data-label="Actions">
            <div class="action-buttons">
                <a href="{{ route('user.short.upload.index', $short->id) }}" class="action-btn edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M13.6873 3.83757L14.5123 3.01258C15.1958 2.32914 16.3038 2.32914 16.9873 3.01258C17.6707 3.69603 17.6707 4.80411 16.9873 5.48756L16.1623 6.31255M13.6873 3.83757L8.13782 9.387C7.7149 9.81 7.41487 10.3398 7.26981 10.9201L6.6665 13.3333L9.07975 12.73C9.66 12.585 10.1898 12.2849 10.6128 11.862L16.1623 6.31255M13.6873 3.83757L16.1623 6.31255" stroke="CurrentColor" stroke-width="1.2" stroke-linejoin="round" />
                        <path d="M15.8333 11.25C15.8333 13.9895 15.8332 15.3593 15.0767 16.2813C14.9382 16.45 14.7834 16.6048 14.6146 16.7433C13.6927 17.5 12.3228 17.5 9.58325 17.5H9.16667C6.02397 17.5 4.45263 17.5 3.47632 16.5236C2.50002 15.5474 2.5 13.976 2.5 10.8333V10.4166C2.5 7.67706 2.5 6.30728 3.25662 5.38533C3.39514 5.21654 3.54992 5.06177 3.7187 4.92324C4.64066 4.16663 6.01043 4.16663 8.75 4.16663" stroke="CurrentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <a href="{{ route('user.dashboard.analytics.post', $short->id) }}" class="action-btn analytics-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Analytics">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M5.8335 14.1667V10.8334" stroke="CurrentColor" stroke-width="1.2" stroke-linecap="round" />
                        <path d="M10 14.1667V5.83337" stroke="CurrentColor" stroke-width="1.2" stroke-linecap="round" />
                        <path d="M14.1665 14.1666V9.16663" stroke="CurrentColor" stroke-width="1.2" stroke-linecap="round" />
                        <path d="M2.0835 10C2.0835 6.26809 2.0835 4.40212 3.24286 3.24274C4.40224 2.08337 6.26821 2.08337 10.0002 2.08337C13.7321 2.08337 15.5981 2.08337 16.7575 3.24274C17.9168 4.40212 17.9168 6.26809 17.9168 10C17.9168 13.732 17.9168 15.598 16.7575 16.7574C15.5981 17.9167 13.7321 17.9167 10.0002 17.9167C6.26821 17.9167 4.40224 17.9167 3.24286 16.7574C2.0835 15.598 2.0835 13.732 2.0835 10Z" stroke="CurrentColor" stroke-width="1.2" stroke-linejoin="round" />
                    </svg>
                </a>
                <div class="dropdown message-item__dropdown">
                    <span class="btn dropdown-btn action-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="las la-ellipsis-h"></i>
                    </span>
                    <ul class="dropdown-menu">
                        @if($short->is_pinned == 0)
                            <li><button class="dropdown-item pin-btn" data-post-id="{{ $short->id }}" data-action="{{ route('user.dashboard.short.pin', $short->id) }}"><i class="las la-thumbtack"></i> @lang('Pin to top')</button></li>
                        @else
                            <li><button class="dropdown-item unpin-btn" data-action="{{ route('user.dashboard.short.pin', $short->id) }}"><i class="las la-thumbtack"></i> @lang('Unpin from top')</button></li>
                        @endif
                        <li><button class="dropdown-item confirmationBtn" data-question=" @lang('Are you sure to remove this short?')" data-action="{{ route('user.dashboard.short.delete', $short->id) }}"><i class="las la-trash-alt"></i> @lang('Delete')</button></li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="100%" class="text-center"><x-empty-message message="No shorts found" /></td>
    </tr>
@endforelse