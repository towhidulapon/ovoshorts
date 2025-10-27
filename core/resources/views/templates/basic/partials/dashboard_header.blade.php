<div class="dashboard-header">
    <div class="dashboard-header__inner flex-between">
        @if (request()->routeIs('user.short.upload.*', 'user.dashboard.post', 'user.home'))
            <div class="dashboard-header__left">
                <h4 class="dashboard-header__grettings mb-0">@lang('Hello!') {{ auth()->user()->username }} </h4>
            </div>
        @endif
        @if (request()->routeIs('user.dashboard.analytics', 'user.dashboard.analytics.*'))
            <div class="dashboard-header__left">
                <div class="overview__menu">
                    @if (!request()->routeIs('user.dashboard.analytics.post'))
                        <a href="{{ route('user.dashboard.analytics')}}" class="overview__menu-link {{ request()->routeIs('user.dashboard.analytics') ? 'active' : '' }}">@lang('Overview')</a>
                        <a href="{{ route('user.dashboard.analytics.content') }}" class="overview__menu-link {{ request()->routeIs('user.dashboard.analytics.content') ? 'active' : '' }}">@lang('Content')</a>
                        <a href="{{ route('user.dashboard.analytics.viewers') }}" class="overview__menu-link {{ request()->routeIs('user.dashboard.analytics.viewers') ? 'active' : '' }}">@lang('Viewers')</a>
                    @else
                        <a href="{{ route('user.dashboard.analytics.post', $short->name) }}" class="overview__menu-link active">@lang('Overview')</a>
                    @endif
                </div>
            </div>
            @include('Template::partials.user_header')
        @else
            @include('Template::partials.user_header')
        @endif
    </div>
</div>