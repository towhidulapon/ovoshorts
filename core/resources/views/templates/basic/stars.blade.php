@php
$starContent = getContent('stars.content', true);
$starElements = getContent('stars.element', false, orderById: true);
@endphp

@extends($activeTemplate . 'layouts.setting_frontend')
@section('content')
    <section class="gets-coin setting-page-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="gets-coin__card">
                        <div class="gets-coin__card-heading flex-wrap justify-content-between mb-4 align-items-center">
                            <h4 class="title mb-0">{{ __($starContent->data_values->title) }}</h4>
                            <a href="{{ route('user.transactions') }}" class="title text-white mb-0">@lang('View transaction history')</a>
                        </div>

                        <div class="ets-coin__card__reffer flex-wrap gap-4 mb-4">
                            <div class="gets__login-card">
                                <div class="thumb">
                                    <img src="{{ auth()->user() ? getImage(getFilePath('userProfile') . '/' . auth()?->user()?->image) : asset($activeTemplateTrue . 'images/avatar.jpg') }}" alt="img">
                                </div>
                                <div class="content">
                                    <h6 class="text mb-0 fw-600">{{ auth()->user()->username ?? '' }}</h6>
                                    <span class="fw-500"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                            <g>
                                                <linearGradient id="a" x1="12" x2="12" y1="2.42" y2="21.58" gradientUnits="userSpaceOnUse">
                                                    <stop offset="0" stop-color="#ffe61c"></stop>
                                                    <stop offset="1" stop-color="#ffa929"></stop>
                                                </linearGradient>
                                                <path fill="url(#a)" d="m12 18.954-4.687 2.464c-1.01.531-2.19-.326-1.998-1.451l.895-5.22-3.792-3.698c-.818-.796-.367-2.184.762-2.35l5.242-.76 2.343-4.75c.505-1.025 1.964-1.025 2.47 0l2.343 4.75 5.242.76c1.129.165 1.58 1.552.763 2.35l-3.793 3.698.895 5.22c.192 1.125-.988 1.983-1.998 1.451z" opacity="1" data-original="url(#a)" class=""></path>
                                            </g>
                                        </svg> {{ $user->stars ?? 0 }}</span>
                                </div>
                            </div>

                            @auth
                                <div class="gets__login-card">
                                    <div class="content">
                                        <h6 class="text mb-0 fw-600">@lang('Wallet')</h6>
                                        <span class="fw-500"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                <g>
                                                    <linearGradient id="a" x1="12" x2="12" y1="2.42" y2="21.58" gradientUnits="userSpaceOnUse">
                                                        <stop offset="0" stop-color="#ffe61c"></stop>
                                                        <stop offset="1" stop-color="#ffa929"></stop>
                                                    </linearGradient>
                                                    <path fill="url(#a)" d="m12 18.954-4.687 2.464c-1.01.531-2.19-.326-1.998-1.451l.895-5.22-3.792-3.698c-.818-.796-.367-2.184.762-2.35l5.242-.76 2.343-4.75c.505-1.025 1.964-1.025 2.47 0l2.343 4.75 5.242.76c1.129.165 1.58 1.552.763 2.35l-3.793 3.698.895 5.22c.192 1.125-.988 1.983-1.998 1.451z" opacity="1" data-original="url(#a)" class=""></path>
                                                </g>
                                            </svg> {{ showAmount($user->balance) }}</span>
                                    </div>
                                </div>
                                    <div class="gets__login-card">
                                        <div class="content">
                                            <a href="javascript:void(0)" class="title text-white fw-600" data-bs-toggle="modal" data-bs-target="#staticBackdrop">@lang('Invite & Get Rewards') <i class="fa-solid fa-arrow-right"></i></a>
                                            <div class="invite-box">
                                                <input type="text" value="{{ $link ?? '' }}" readonly>
                                                <button class="copy-btn"><i class="fa-regular fa-copy"></i></button>
                                            </div>
                                        </div>
                                    </div>
                            @endauth
                        </div>

                        <div class="gets-coin__wrapper">
                            <form action="{{ route('user.star.recharge') }}" method="GET" class="choose-recharge">
                                <div class="recharge-method-wrapper mb-4">
                                    <div class="row gy-4">
                                        @forelse ($stars as $star)
                                            <div class="col-xl-3 col-lg-4 col-sm-6 col-xsm-6">
                                                <div class="form-check form--radio">
                                                    @php
    $inputId = 'starOption' . $loop->index;
                                                    @endphp
                                                    <label class="form-check-label" for="{{ $inputId }}">
                                                        <input class="form-check-input" type="radio" name="star_id" id="{{ $inputId }}" value="{{ $star->id }}" @if ($loop->first) checked @endif hidden="">
                                                        <div class="recharge-content">
                                                            <div class="recharge-content__left">
                                                                <div class="title mb-0">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                                        <g>
                                                                            <linearGradient id="a" x1="12" x2="12" y1="2.42" y2="21.58" gradientUnits="userSpaceOnUse">
                                                                                <stop offset="0" stop-color="#ffe61c"></stop>
                                                                                <stop offset="1" stop-color="#ffa929"></stop>
                                                                            </linearGradient>
                                                                            <path fill="url(#a)" d="m12 18.954-4.687 2.464c-1.01.531-2.19-.326-1.998-1.451l.895-5.22-3.792-3.698c-.818-.796-.367-2.184.762-2.35l5.242-.76 2.343-4.75c.505-1.025 1.964-1.025 2.47 0l2.343 4.75 5.242.76c1.129.165 1.58 1.552.763 2.35l-3.793 3.698.895 5.22c.192 1.125-.988 1.983-1.998 1.451z" opacity="1" data-original="url(#a)" class=""></path>
                                                                        </g>
                                                                    </svg>
                                                                    <span> {{ $star->stars }}</span>
                                                                </div>
                                                                <p class="subtitle mb-0 star-price">{{ showAmount($star->price) }}</p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <x-empty-message message="No stars found" />
                                        @endforelse
                                    </div>
                                </div>

                                <div class="offer-box">
                                    <div class="offer-content">
                                        <span class="percent">{{ $starContent->data_values->cashback }}<span class="percent-symbol">%</span></span>
                                        <div class="offer-text">
                                            <h6 class="fw-600">{{ __($starContent->data_values->cashback_detail) }}</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-section">
                                    <div class="payment-method">
                                        <label>@lang('Payment method')</label>
                                        <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" alt="MasterCard" class="card-icon">
                                        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" class="card-icon">
                                    </div>

                                    <div class="total text-white mb-4">
                                        <label class="fw-600">@lang('Total')</label>
                                        <span class="amount total-amount"></span>
                                    </div>

                                    <button type="submit" class="btn btn--base">@lang('Recharge')</button>
                                    @auth
                                    <button type="button" class="btn btn--secondary" data-bs-toggle="modal" data-bs-target="#convertModal">@lang('Convert to Balance')</button>
                                    @endauth
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="secure-badge">
                                        <span>✔ @lang('SECURE')</span> @lang('Payment')
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @auth
                        <a href="#" class="reward-banner mt-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <div class="banner-content">
                                <img src="{{ asset($activeTemplateTrue . 'images/invite_rewards.png') }}" alt="img">
                                <div class="text-content">
                                    <strong>@lang('Invite & Get Rewards')</strong>
                                    <p>@lang('Check out this new feature!')</p>
                                </div>
                            </div>
                            <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal custom--modal fade-in-scale fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 justify-content-end">
                    <button type="button" class="btn btn--sm btn--close btn-outline--secondary rounded-full " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invite-box">
                        <div class="invite-box__header d-flex">
                            <h4 class="title" data-highlight="6,7">{{ __($starContent->data_values->modal_title) }}</h4>
                            <img class="fit-image" src="{{ asset($activeTemplateTrue . 'images/invite_rewards.png') }}" alt="img">
                        </div>
                    </div>
                    <div class="invite-code">
                        <div class="code-box">
                            <div>
                                <label>@lang('Your invitation code')</label>
                                <input type="text" value="{{ $link }}" id="inviteCode" readonly>
                            </div>
                            <button class="copy-btn-invite">@lang('Copy')</button>
                        </div>
                        <button class="btn btn--danger w-100 invite-btn">@lang('Invite now')</button>
                    </div>
                    <div class="invite-earn">
                        <h3>@lang('Your cashback')</h3>
                        <div class="invite-earn-wrapper">
                            <a href="#" class="invite-earn-card">
                                <div class="icon">
                                    <svg fill="currentColor" font-size="28px" color="white" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em">
                                        <path d="M25 10a1 1 0 0 1 1 1v2.47c2.04.3 3.8 1.09 5.25 2.25.39.32.43.9.12 1.3l-.88 1.16c-.36.49-1.07.53-1.56.17a8.58 8.58 0 0 0-2.93-1.4v5.55c3.17.86 6.42 2.2 6.42 6.26 0 3.14-1.98 5.93-6.42 6.5V37a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1.78a11.22 11.22 0 0 1-5.93-2.65.94.94 0 0 1-.11-1.26l.9-1.23c.37-.52 1.12-.55 1.6-.15A9.19 9.19 0 0 0 22 31.77V25.5c-2.99-.84-5.83-2.16-5.83-5.93 0-3.02 2.24-5.46 5.83-6.1V11a1 1 0 0 1 1-1h2Zm1 16.6v5.3c1.83-.44 2.58-1.64 2.58-2.79 0-1.3-1.08-2-2.58-2.52Zm-4-5.23v-4.5c-1.25.4-2 1.27-2 2.42 0 1 .8 1.62 2 2.08Z">
                                        </path>
                                        <path d="M24 2a22 22 0 1 0 0 44 22 22 0 0 0 0-44ZM6 24a18 18 0 1 1 36 0 18 18 0 0 1-36 0Z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text">
                                    <small>@lang('Total cashback')</small>
                                    <h4>{{ showAmount($totalReferralAmount) }}</h4>
                                </div>
                            </a>
                            <a href="#" class="invite-earn-card">
                                <div class="icon">
                                    <svg fill="currentColor" font-size="28px" color="white" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19 2.5a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm-6 10a6 6 0 1 1 12 0 6 6 0 0 1-12 0Z">
                                        </path>
                                        <path d="M5 43.5c.55 0 1-.45 1.02-1 .18-4.33 1.56-7.46 3.6-9.53 2.2-2.23 5.4-3.47 9.38-3.47 2.44 0 4.58.46 6.38 1.33A4.5 4.5 0 0 1 29 29h.94c-2.96-2.36-6.76-3.5-10.94-3.5-4.82 0-9.12 1.51-12.22 4.66-2.92 2.96-4.57 7.16-4.76 12.34-.02.55.43 1 .98 1h2ZM35 26.5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v6h6a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-6v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-6h-6a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h6v-6Z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text">
                                    <small>@lang('Total referrals')</small>
                                    <h4>{{ getAmount($totalReferral) }}</h4>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="invite-steps">
                        @foreach ($starElements as $starElement)
                            <div class="invite-steps__item">
                                <div class="invite-steps__number">{{ $loop->iteration }}</div>
                                <p class="invite-steps__text">{{ __($starElement->data_values->modal_option) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Convert Coins to Balance Modal -->
    <div class="modal custom--modal fade-in-scale fade" id="convertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 justify-content-end">
                    <button type="button" class="btn btn--sm btn--close btn-outline--secondary rounded-full" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4 class="mb-3 text-center">@lang('Convert Coins to Balance')</h4>
                    <form action="{{ route('user.star.transaction.convert') }}" method="POST" id="convertForm">
                        @csrf
                        <div class="mb-3">
                            <label for="convertAmount" class="form-label fw-600">@lang('Enter coins to convert')</label>
                            <input type="number" min="1" max="{{ $user->stars ?? 0 }}" class="form-control form--control convert-amount" id="convertAmount" name="stars" required>
                            <small class="text-muted">@lang('Available:') {{ $user->stars ?? 0 }}</small>
                        </div>
                        <div class="mb-3 text-center">
                            <span class="fw-600">@lang('Conversion Rate:')</span>
                            <span class="text--base">{{ showAmount(gs('star_price')) }} @lang('per coin')</span>
                        </div>
                        <div class="mb-3 text-center">
                            <label class="fw-600">@lang('You will get')</label>
                            <span class="amount converted-balance text--success"> 0 {{gs('cur_text')}}</span>
                        </div>
                        <button type="submit" class="btn btn--base w-100">@lang('Convert Now')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div class="modal custom--modal fade-in-scale fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 justify-content-end">
                    <button type="button" class="btn btn--sm btn--close btn-outline--secondary rounded-full" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <h5 class="mb-3">@lang('Share on')</h5>
                    <input type="text" class="form-control mb-3" id="referralLink" value="{{ $link }}" readonly>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($link) }}" target="_blank" class="btn btn--primary"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($link) }}" target="_blank" class="btn btn--success"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($link) }}" target="_blank" class="btn btn--info"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($link) }}" target="_blank" class="btn btn--secondary"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://t.me/share/url?url={{ urlencode($link) }}" target="_blank" class="btn btn--primary"><i class="fab fa-telegram-plane"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                function updateTotal() {
                    let selected = $("input[name='star_id']:checked").closest('.form-check-label');
                    let price = selected.find('.star-price').text();
                    $('.total-amount').text(price);
                }

                updateTotal();
                $('input[name="star_id"]').on('change', function () {
                    updateTotal();
                });

                $('.copy-btn').on('click', function () {
                    var copyText = $(this).siblings("input");
                    copyText[0].select();
                    copyText[0].setSelectionRange(0, 99999);
                    document.execCommand("copy");
                    notify('success', 'Referral link copied to clipboard');
                });

                $('.copy-btn-invite').on('click', function () {
                    var copyText = $('#inviteCode');
                    copyText[0].select();
                    copyText[0].setSelectionRange(0, 99999);
                    document.execCommand("copy");
                    notify('success', 'Referral link copied to clipboard');
                });


                $('.invite-btn').on('click', function () {
                    $('#shareModal').modal('show');
                });


                $('.convert-amount').on('input', function () {
                    let coins = Number($(this).val());
                    let rate = Number("{{ gs('star_price') }}");
                    let total = coins * rate;
                    $('.converted-balance').text((total > 0 ? total : 0) + " {{ gs('cur_text') }}");
                });

                $('#convertModal').on('hidden.bs.modal', function () {
                    $('.convert-amount').val('');
                    $('.converted-balance').text("0 {{ gs('cur_text') }}");
                });
            });
        })(jQuery);
    </script>
@endpush