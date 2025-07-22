@extends($activeTemplate . 'layouts.app')

@section('app-content')
    <section class="account position-relative bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/account-bg.png') }}">

        <div class="account__header">
            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="img"> </a>
        </div>

        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 align-items-center justify-content-center">
                    <div class="account-form__wrapper d-flex justify-content-center pb-4">
                        <div class="account-form col-8">
                            <h3 class="mt-4 text-center">{{ __($pageTitle) }}</h3>
                            <div class="login-form__wrapper">
                                <form method="POST" action="{{ route('user.data.submit') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <label class="form-label">@lang('Username')</label>
                                            <div class="input-group-custom">
                                                <span class="input-group-custom__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.20455C7.1424 3.20455 3.20455 7.1424 3.20455 12C3.20455 16.8576 7.1424 20.7955 12 20.7955C16.8576 20.7955 20.7955 16.8576 20.7955 12C20.7955 7.1424 16.8576 3.20455 12 3.20455ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12Z" fill="Hsl(var(--primary))" />
                                                        <path d="M8.5 9.5C8.5 7.567 10.067 6 12 6C13.933 6 15.5 7.567 15.5 9.5C15.5 11.433 13.933 13 12 13C10.067 13 8.5 11.433 8.5 9.5Z" fill="Hsl(var(--primary))" />
                                                        <path d="M5.40873 17.6472C6.43247 15.8556 8.3377 14.75 10.4011 14.75H13.5979C15.6613 14.75 17.5666 15.8556 18.5903 17.6472L19.6094 19.5928C17.6634 21.5432 14.9724 22.7499 11.9996 22.7499C9.0267 22.7499 6.33569 21.5431 4.38965 19.5928L5.40873 17.6472Z" fill="Hsl(var(--primary))" />
                                                    </svg>
                                                </span>
                                                <input type="text" class="input-group-custom__input form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                                                <span class="username-exists-error d-none text-danger mt-1"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="form-label">@lang('Country')</label>
                                            <select name="country" class="form-control form--control select2" required>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                                        {{ __($country->country) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group-custom">
                                                <span class="input-group-text mobile-code"></span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="input-group-custom__input form-control form--control checkUser" required>
                                            </div>
                                            <span class="mobile-exists-error d-none text-danger mt-1"></span>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label class="form-label">@lang('Address')</label>
                                            <div class="input-group-custom">
                                                <span class="input-group-custom__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 2.709 2.709" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                                                        <g>
                                                            <path fill="Hsl(var(--primary))" d="M1.355.17c.516 0 .935.418.935.935 0 .396-.551 1.08-.807 1.376-.034.039-.077.059-.128.059s-.095-.02-.128-.06C.97 2.185.42 1.501.42 1.106.42.588.838.17 1.355.17zm0 .563a.355.355 0 1 1 0 .71.355.355 0 0 1 0-.71z" opacity="1" data-original="#333333" class=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" class="input-group-custom__input form-control form--control" name="address" value="{{ old('address') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label class="form-label">@lang('State')</label>
                                            <div class="input-group-custom">
                                                <span class="input-group-custom__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512.044 512.044" style="enable-background:new 0 0 24 24" xml:space="preserve" class="">
                                                        <g>
                                                            <circle cx="95.007" cy="389.247" r="10" fill="#000000" opacity="1" data-original="#000000" class=""></circle>
                                                            <path d="M499.123 166.018c-3.651-1.557-11.195-3.125-20.723 3.847-5.056 3.709-10.909 9.736-16.57 15.565-4.325 4.454-10.835 11.156-13.24 12.477-16.159 5.956-25.849 16.337-37.062 28.351-4.506 4.826-9.165 9.817-14.762 15.123-.817.774-1.391.965-1.448.984-1.546-.655-1.636-5.916-3.872-11.72-2.513-6.571-6.408-11.011-11.576-13.195-3.434-1.453-9.085-2.514-16.505.671-5.422 2.332-18.215 10.244-18.411 10.383 1.695-14.589 2.846-25.824-16.509-33.08-36.094-13.523-90.895-20.363-148.825-26.642-3.357-1.304 8.971 1.475-53.614-5.901v-37.639c22.795-4.646 40-24.847 40-48.994 0-27.57-22.43-50-50-50s-50 22.43-50 50c0 24.146 17.205 44.348 40 48.994v35.135c-19.173-2.575-40.137-6.02-53.567-10.768-7.111-2.513-15.17-5.361-22.188-1.368-7.037 4.009-8.611 11.965-10.434 21.177-3.928 19.861-7.606 34.679-10.852 47.752C3.645 238.608-.2 254.097.007 273.358c.467 42.79 12.901 72.567 50.402 100.754 4.414 3.317 10.682 2.43 14.002-1.986 3.318-4.414 2.429-10.684-1.986-14.002-13.508-10.153-23.272-20.513-29.971-31.875h187.372l-43.552 87.104c-13.237-4.811-25.569-9.572-36.728-14.189a9.996 9.996 0 0 0-13.063 5.417c-2.111 5.104.314 10.952 5.417 13.063 13.767 5.696 29.225 11.593 45.956 17.532l.056.02c21.771 7.691 27.149 12.346 42.705 31.524 2.449 3.02 4.982 6.143 7.778 9.39 7.553 8.781 18.608 12.196 29.009 7.727 10.708-4.601 17.614-16.469 16.422-28.211-.598-5.928.527-6.327 4.922-6.916 60.638-8.143 38.203-6.003 73.102-14.332 8.162-1.939 14.321-.1 19.391 5.788 8.815 10.23 20.371 27.365 28.259 33.568 5.966 4.7 12.837 6.543 19.346 5.193 6.462-1.341 11.982-5.717 15.55-12.334 8.039-14.954 9.285-30.41 3.605-44.698-10.815-27.211-2.782-38.164 4.987-48.757 9.892-13.486 16.767-29.68 15.448-46.182-1.933-24.317 9.501-40.008 24.049-59.068 15.877-20.8 33.872-44.375 28.634-83.263-1.676-12.459-8.235-17.006-11.996-18.607zM86.007 76.247c0-16.542 13.458-30 30-30s30 13.458 30 30-13.458 30-30 30-30-13.458-30-30zm80 230H24.017c-2.58-9.405-3.868-20.116-4.011-33.107-.179-16.705 3.223-30.409 8.371-51.152 3.137-12.634 7.039-28.357 11.06-48.688.273-1.382.842-4.251 1.411-6.456 1.157.338 2.747.853 4.926 1.622 12.74 4.505 31.522 8.283 60.233 12.082v35.7c0 5.522 4.478 10 10 10s10-4.478 10-10V183.02c12.618 1.471 26.15 2.915 40 4.407zm20 0v-116.65c53.411 5.888 103.201 12.483 135.419 24.554 3.058 1.146 4.135 1.923 4.438 2.182.18.75.208 2.743-.519 7.863-.616 4.35-.802 8.061-.578 11.253l-34.974 70.799H186.007zm140 114.317c-7.703 2.308-10.174 2.985-49.919 8.322-15.713 2.107-23.79 12.584-22.16 28.752.356 3.505-2.017 6.789-4.419 7.821-.777.334-2.845 1.22-5.954-2.397-2.607-3.027-5.046-6.034-7.404-8.941-10.552-13.01-20.575-25.353-40.965-33.87l47.001-94.003h83.82zm100.854-59.256c-8.9 12.135-22.352 30.474-7.446 67.974 3.479 8.75 2.592 18.117-2.629 27.83-.872 1.617-1.691 2.167-2.003 2.231-.337.066-1.38-.117-2.913-1.326-5.131-4.035-17.078-21.159-25.475-30.905-9.911-11.51-23.818-15.844-39.179-12.19l-1.209.29v-88.964h92.353c.041.765.078 1.529.139 2.297.922 11.548-4.805 23.449-11.638 32.763zm39.726-105.556c-11.264 14.756-22.86 29.951-26.885 50.495H312.1l26.734-54.118c7.448.533 14.165-4.613 17.305-7.019l.104-.08c5.507-3.012 12.118-7.627 15.789-8.828 1.193 2.066 1.741 5.166 2.465 8.215 2.018 8.499 7.663 14.896 15.101 17.111 7.137 2.121 14.963.02 20.928-5.634 6.041-5.726 11.132-11.179 15.623-15.991 10.285-11.019 17.717-18.979 29.5-23.283 5.56-2.031 11.423-7.881 20.528-17.256 5.088-5.238 10.35-10.655 14.045-13.367.269-.197.515-.365.739-.509.119.48.237 1.075.336 1.804 4.132 30.674-9.878 49.029-24.71 68.46z" fill="Hsl(var(--primary))" opacity="1" data-original="#000000" class=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" class="input-group-custom__input form-control form--control" name="state" value="{{ old('state') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label class="form-label">@lang('Zip Code')</label>
                                            <div class="input-group-custom">
                                                <span class="input-group-custom__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 24 24" xml:space="preserve" class="">
                                                        <g>
                                                            <path d="M459 121.454H302.685l9.005-14.588c7.017-11.404 10.5-24.837 10.049-38.211-1.199-35.533-29.948-64.637-65.449-66.258-38.647-1.765-71.905 29.912-71.905 68.624 0 12.3 3.318 24.807 9.768 35.318l9.329 15.115H53c-29.225 0-53 23.776-53 53v69.71c0 5.523 4.478 10 10 10s10-4.477 10-10v-69.71c0-18.196 14.804-33 33-33h162.823l15.492 25.094c9.87 15.987 33.634 15.84 43.534-.001l15.49-25.093H459c18.196 0 33 14.804 33 33v228.69c0 18.996-15.454 34.45-34.45 34.45H310.83c-17.608 0-34.257 9.326-43.448 24.338l-11.383 18.591-11.393-18.605c-9.196-15.004-25.836-24.324-43.427-24.324H54.45c-18.996 0-34.45-15.454-34.45-34.45v-71.01c0-5.523-4.478-10-10-10s-10 4.477-10 10v71.01c0 30.024 24.427 54.45 54.45 54.45h146.73c10.683 0 20.789 5.662 26.372 14.772l19.92 32.53a10 10 0 0 0 17.056 0l19.91-32.52c5.583-9.118 15.695-14.782 26.392-14.782h146.72c30.023 0 54.45-24.426 54.45-54.45v-228.69c0-29.224-23.775-53-53-53zm-239.551-85.65c9.708-9.274 22.474-14.053 35.929-13.427 25.153 1.148 45.522 21.772 46.373 46.952.319 9.486-2.082 18.759-6.945 26.815l-36.977 59.898c-2.155 3.489-7.336 3.492-9.491-.004l-36.972-59.887c-4.416-7.727-6.981-16.184-6.981-25.131 0-13.429 5.349-25.935 15.064-35.216z" fill="Hsl(var(--primary))" opacity="1" data-original="#000000" class=""></path>
                                                            <path d="M268.223 269.978v-63.847c0-5.523-4.478-10-10-10s-10 4.477-10 10v63.847c0 5.523 4.478 10 10 10s10-4.477 10-10zM165.748 274.743a10 10 0 0 0 8.792 5.235h42.593c5.522 0 10-4.477 10-10s-4.478-10-10-10h-24.142l31.528-48.388a10 10 0 0 0-8.379-15.459h-40.292c-5.522 0-10 4.477-10 10s4.478 10 10 10h21.841l-31.528 48.388a10 10 0 0 0-.413 10.224zM311.312 269.978v-17.787c2.966-.014 5.924-.025 7.778-.025 15.644 0 28.37-12.569 28.37-28.018s-12.727-28.018-28.37-28.018h-17.778c-5.442 0-10 4.557-10 10v63.847c0 5.523 4.478 10 10 10s10-4.476 10-9.999zm7.778-53.847c4.537 0 8.37 3.671 8.37 8.018s-3.833 8.018-8.37 8.018c-1.842 0-4.764.011-7.708.025-.014-3.071-.032-12.833-.041-16.06h7.749zM403.244 328.43c5.522 0 10-4.477 10-10s-4.478-10-10-10h-26.656c-5.522 0-10 4.477-10 10v63.264c0 5.523 4.478 10 10 10h26.656c5.522 0 10-4.477 10-10s-4.478-10-10-10h-16.656v-11.632h14.691c5.522 0 10-4.477 10-10s-4.478-10-10-10h-14.691V328.43zM285.146 380.035c0 5.82 4.068 11.006 10.163 11.006.53-.002 13.059-.05 18.073-.138 19.894-.348 34.332-17.524 34.332-40.842 0-24.511-14.073-40.979-35.021-40.979h-17.548c-5.496 0-10 4.595-10 10.064v60.889zm27.548-50.952c13.938 0 15.021 16.058 15.021 20.979 0 10.248-4.54 20.667-14.682 20.845-1.84.032-4.807.059-7.795.081-.022-7.106-.062-34.495-.074-41.904h7.53zM140.679 308.138c-23.116 0-41.923 18.807-41.923 41.924s18.807 41.923 41.923 41.923c10.665 0 20.869-4.362 27.771-12.582 3.552-4.229 3.002-10.537-1.228-14.088-4.229-3.552-10.538-3.002-14.089 1.228-3.122 3.715-7.667 5.442-12.454 5.442-12.088 0-21.923-9.835-21.923-21.923 0-12.089 9.835-21.924 21.923-21.924a21.79 21.79 0 0 1 12.25 3.738c4.577 3.093 10.792 1.889 13.885-2.687 3.092-4.576 1.889-10.792-2.688-13.884a41.718 41.718 0 0 0-23.447-7.167zM183.189 350.062c0 23.117 18.807 41.924 41.923 41.924 23.117 0 41.924-18.807 41.924-41.924s-18.807-41.923-41.924-41.923c-23.116-.001-41.923 18.806-41.923 41.923zm63.847 0c0 12.089-9.835 21.924-21.924 21.924-12.088 0-21.923-9.835-21.923-21.924 0-12.088 9.835-21.923 21.923-21.923 12.089-.001 21.924 9.834 21.924 21.923zM253.082 100.991c16.482 0 29.893-13.41 29.893-29.893s-13.41-29.893-29.893-29.893-29.893 13.41-29.893 29.893 13.411 29.893 29.893 29.893zm0-39.785c5.455 0 9.893 4.438 9.893 9.893s-4.438 9.893-9.893 9.893-9.893-4.438-9.893-9.893 4.438-9.893 9.893-9.893zM1.689 293.698c2.989 4.565 9.353 5.751 13.86 2.76 4.546-3.016 5.763-9.334 2.76-13.86-3.013-4.541-9.331-5.789-13.859-2.77-4.537 3.025-5.775 9.34-2.761 13.87z" fill="Hsl(var(--primary))" opacity="1" data-original="#000000" class=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" class="input-group-custom__input form-control form--control" name="zip" value="{{ old('zip') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <label class="form-label">@lang('City')</label>
                                            <div class="input-group-custom">
                                                <span class="input-group-custom__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 24 24" xml:space="preserve" class="">
                                                        <g>
                                                            <g data-name="16-location">
                                                                <path d="M320 100H192a12 12 0 0 0-12 12v204h48v-60a12 12 0 0 1 12-12h32a12 12 0 0 1 12 12v60h48V112a12 12 0 0 0-12-12ZM220 208a12 12 0 0 1-24 0v-16a12 12 0 0 1 24 0Zm0-64a12 12 0 0 1-24 0v-16a12 12 0 0 1 24 0Zm48 64a12 12 0 0 1-24 0v-16a12 12 0 0 1 24 0Zm0-64a12 12 0 0 1-24 0v-16a12 12 0 0 1 24 0Zm48 64a12 12 0 0 1-24 0v-16a12 12 0 0 1 24 0Zm0-64a12 12 0 0 1-24 0v-16a12 12 0 0 1 24 0Z" fill="Hsl(var(--primary))" opacity="1" data-original="#000000" class=""></path>
                                                                <path d="M256 4C143.514 4 52 95.514 52 208c0 34.837 10.568 72.315 31.412 111.4 16.371 30.695 39.121 62.515 67.619 94.576C199.279 468.251 246.8 504.1 248.8 505.6a12 12 0 0 0 14.4 0c2-1.5 49.521-37.349 97.769-91.627 28.5-32.061 51.248-63.881 67.619-94.576C449.432 280.315 460 242.837 460 208 460 95.514 368.486 4 256 4Zm0 364a159.606 159.606 0 0 1-117.942-52H168V212H96.051q-.05-2-.051-4c0-88.224 71.776-160 160-160s160 71.776 160 160q0 2.005-.051 4H344v104h29.942A159.606 159.606 0 0 1 256 368Z" fill="Hsl(var(--primary))" opacity="1" data-original="#000000" class=""></path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" class="input-group-custom__input form-control form--control" name="city" value="{{ old('city') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 form-group">
                                            <button type="submit" class="btn btn--base w-100" id="submitBtn" disabled>@lang('Submit')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('.select2').select2();

            $('select[name=country]').on('change', function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function (e) {
                var value = $(this).val();
                var name = $(this).attr('name');
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    };
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    };
                }
                $.post(url, data, function (response) {
                    domModifyForExists(response, name);
                });
            }

            let usernameError = false;
            let mobileError = false;

            function domModifyForExists(response, name) {
                if (response.data == true) {
                    if (name == 'username') {
                        var message = `@lang('Username already exists')`;
                        usernameError = true;
                    } else {
                        var message = `@lang('Mobile already exists')`;
                        mobileError = true;
                    }

                    $(`.${name}-exists-error`)
                        .html(`${message}`)
                        .removeClass('d-none')
                        .addClass("text-danger mt-1 d-block");
                } else {
                    $(`.${name}-exists-error`)
                        .empty()
                        .addClass('d-none')
                        .removeClass("text-danger mt-1 d-block");

                    if (name == 'username') {
                        usernameError = false;
                    } else {
                        mobileError = false;
                    }
                }

                if (!usernameError && !mobileError) {
                    $('#submitBtn')
                        .attr('disabled', false)
                        .removeClass('disabled');
                } else {
                    $('#submitBtn')
                        .attr('disabled', true)
                        .addClass('disabled');
                }
            }
        })(jQuery);
    </script>
@endpush