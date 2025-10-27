@extends($activeTemplate . 'layouts.dashboard_frontend')
@section('content')

    <div class="dashboard-body">
        <div class="dashboard-body__bar d-lg-none d-block">
            <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
        </div>

        <div class="dashboard-card mb-4">

            <div class="dashboard-card-wrapper">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('Total viewers')</span>
                        <h4 class="dashboard-widget__number">{{ showFormatCount($totalViewers) }}</h4>
                    </div>
                </div>

                <div class="dashboard-widget">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('New viewers')</span>
                        <h4 class="dashboard-widget__number">{{ showFormatCount($newViewers) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card custom--card mb-4">
            <div class="card-header">
                <h5 class="card-header__title mb-0 text-white">@lang('Viewers types') <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M10.0003 18.8333C14.6027 18.8333 18.3337 15.1023 18.3337 10.5C18.3337 5.89759 14.6027 2.16663 10.0003 2.16663C5.39795 2.16663 1.66699 5.89759 1.66699 10.5C1.66699 15.1023 5.39795 18.8333 10.0003 18.8333Z" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10 13.8333V10.5" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10 7.16663H10.0083" stroke="#9DA4AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span> </h5>
            </div>
            <div class="card-body">
                <div class="skills-progress-wrapper">
                    <div class="skills">
                        <div class="skill-item">
                            <div class="skill-text">
                                <p>{{ $newViewersPercentage }}%</p>
                                <p><span>{{ $returningViewersPercentage }}</span>%</p>
                            </div>
                            <div class="progress-bg-line d-flex gap-2">
                                <div class="progress-animated-line" data-progress="{{ $newViewersPercentage }}"></div>
                                <div class="progress-animated-line progress-animated-line-two" data-progress="{{ $returningViewersPercentage }}"></div>
                            </div>
                            <div class="skill-text mt-2">
                                <p class="fw-700">@lang('New viewers')</p>
                                <p class="fw-700"><span>@lang('Returning viewers')</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection