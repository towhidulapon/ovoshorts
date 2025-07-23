<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    @stack('style-lib')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom-animation.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/emoji.css') }}">

    @stack('style')
    {{--
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}"> --}}
</head>
@php echo loadExtension('google-analytics') @endphp

<body>

    <!--==================== Preloader End ====================-->
    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <button class="scroll-top" type="button">
        <svg class="scroll-top-progress" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98">
            </path>
        </svg>
    </button>
    <!-- ==================== Scroll to Top End Here ==================== -->


    @yield('app-content')

    @include('Template::partials.cookie')

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/lightcase.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/plyr.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/emoji.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/emoji-picker.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/select2.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>




    @stack('script-lib')

    <script src="{{ asset('assets/global/js/global.js') }}"></script>
    @php echo loadExtension('tawk-chat') @endphp

    @include('partials.notify')

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @stack('script')

</body>
<script>
    (function ($) {
        "use strict";

        //plicy
        $('.policy').on('click', function () {
            $.get('{{ route('cookie.accept') }}', function (response) {
                $('.cookies-card').addClass('d-none');
            });
        });

        // event when change lang
        $(".langSel").on("change", function () {
            window.location.href = "{{ route('home') }}/change/" + $(this).val();
        });

        //show cookie card
        setTimeout(function () {
            $('.cookies-card').removeClass('hide');
        }, 2000);
    })(jQuery);
</script>
</body>

</html>