<div class="mobile-top-menu d-flex d-md-none">
    <div class="mobile-top-menu__inner">
        <button class="menu-button">
            <span class="menu-button-line"></span>
            <span class="menu-button-line"></span>
            <span class="menu-button-line"></span>
        </button>

        <div class="search-form-wrapper">
            <form class="search-form" action="{{ route('short.search', 'index') }}" method="GET">
                <div class="form-group">
                    <input class="form--control" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Search Here...')" id="search">
                    <button class="search-form-btn" type="submit">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>

            <button class="sm-search-btn d-md-none d-block" type="button">
                <i class="las la-search"></i>
            </button>
            <button class="search-close d-none" type="button">
                <i class="las la-times"></i>
            </button>
        </div>

    </div>
</div>