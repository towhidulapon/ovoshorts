<div class="dashboard-header">
    <div class="dashboard-header__inner flex-between">
     
            <div class="dashboard-header__left d-flex gap-3 align-items-center">
                <div class="dashboard-body__bar d-lg-none d-block">
                    <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
                </div>
            </div>
        @if (request()->routeIs('user.dashboard.analytics', 'user.dashboard.analytics.*'))
            <div class="dashboard-header__left">
                <div class="overview__menu">
                    @if (!request()->routeIs('user.dashboard.analytics.post'))
                        <a href="{{ route('user.dashboard.analytics') }}"
                            class="overview__menu-link {{ request()->routeIs('user.dashboard.analytics') ? 'active' : '' }}">@lang('Overview')</a>
                        <a href="{{ route('user.dashboard.analytics.content') }}"
                            class="overview__menu-link {{ request()->routeIs('user.dashboard.analytics.content') ? 'active' : '' }}">@lang('Content')</a>
                        <a href="{{ route('user.dashboard.analytics.viewers') }}"
                            class="overview__menu-link {{ request()->routeIs('user.dashboard.analytics.viewers') ? 'active' : '' }}">@lang('Viewers')</a>
                    @else
                        <a href="{{ route('user.dashboard.analytics.post', $short->name) }}"
                            class="overview__menu-link active">@lang('Overview')</a>
                    @endif
                </div>
            </div>
            @include('Template::partials.user_header')
        @else
            @include('Template::partials.user_header')
        @endif
    </div>
</div>
