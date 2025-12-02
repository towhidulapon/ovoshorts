@php
    $initialFollowings = auth()->user()->followings()->take(5)->get();
    $totalFollowings = auth()->user()->followings()->count();
@endphp


<div class="followings-container">
    @include('Template::partials.sidebar_following_items', ['followings' => $initialFollowings])
</div>

@if ($totalFollowings > 5)
    <a data-page="2" class="btn load-more-followings sidebar-back-btn">
        @lang('Show More') <i class="las la-angle-down"></i>
    </a>
@endif