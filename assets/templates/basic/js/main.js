'use strict';
(function ($) {
    /* ==================== Ready Function Start ========================== */
    $(document).ready(function () {


        /*===================== Dynamically Add Active Class JS Start ============================== */
        function dynamicActiveMenuClass(selector) {
            if (!($(selector).length)) return;

            let fileName = window.location.pathname.split('/').reverse()[0];
            selector.find('li').each(function () {
                let anchor = $(this).find('a');
                if ($(anchor).attr('href') == fileName) {
                    $(this).addClass('active');
                }
            });
            // if any li has active element add class
            selector.children('li').each(function () {
                if ($(this).find('.active').length) {
                    $(this).addClass('active');
                }
            });
            // if no file name return
            if ('' == fileName) {
                selector.find('li').eq(0).addClass('active');
            }
        }
        /*===================== Dynamically Add Active Class JS End ================================ */




        let toggler = $('.menu-button');
        let sidebar = $(".sidebar-menu");
        let sidebarClose = sidebar.find('.sidebar-menu__close');
        let sidebarOverlay = $('.sidebar-overlay');

        let hideSidebar = function () {
            sidebar.removeClass('show').removeClass("show-sm");
            sidebarOverlay.removeClass('show');
            $(toggler).removeClass('active');
            $('body').removeClass('scroll-hide');
            $(document).unbind('keydown', EscSidbear);
        }

        let EscSidbear = function (e) {
            if (e.keyCode === 27) {
                hideSidebar();
            }
        }

        let showSidebar = function () {
            $(toggler).addClass('active');
            sidebar.addClass('show');
            sidebarOverlay.addClass('show');
            $('body').addClass('scroll-hide');
            $(document).on('keydown', EscSidbear);
        }

        $(toggler).on('click', showSidebar);
        $(sidebarOverlay).on('click', hideSidebar);
        $(sidebarClose).on('click', hideSidebar);

        /* ==================== Dynamically Add BG Image JS Start ====================== */
        $('.bg-img').css('background-image', function () {
            return `url(${$(this).data('background-image')})`;
        });
        /* ==================== Dynamically Add BG Image JS End ========================= */

        /* ==================== Add A Class In Select Input JS Start ===================== */
        $('.form-select.form--select').each((index, select) => {
            if ($(select).val()) {
                $(select).addClass('selected');
            }

            $(select).on('change', function () {
                if ($(this).val()) {
                    $(this).addClass('selected')
                } else {
                    $(this).removeClass('selected')
                }
            });
        });
        /* ==================== Add A Class In Select Input JS End ======================== */

        /* ==================== Select2 Initialization JS Start ==================== */
        $('.select2').each((index, select) => {
            $(select).wrap('<div class="select2-wrapper"></div>').select2({
                dropdownParent: $(select).closest('.select2-wrapper')
            });
        });
        /* ==================== Select2 Initialization JS End ==================== */
        // ==================== User Profile Dropdown Start ==================
        $('.user-info__button').on('click', function () {
            $('.user-info-dropdown').toggleClass('show');
        });
        $('.user-info__button').attr('tabindex', -1).focus();

        $('.user-info__button').on('focusout', function () {
            $('.user-info-dropdown').removeClass('show');
        });
        // ====================  User Profile Dropdown End ==================


        // common dropdown filter  js

        const filterGroups = document.querySelectorAll('.common-filter');
        const allFilterBtns = document.querySelectorAll('.filter-btn');


        filterGroups.forEach(group => {
            const filterBtn = group.querySelector('.filter-btn');
            const filterDropdown = group.querySelector('.common-filter__dropdown');
            const clearBtn = group.querySelector('.clear-btn');
            filterBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.common-filter__dropdown').forEach(dropdown => {
                    if (dropdown !== filterDropdown) {
                        dropdown.classList.remove('active');
                    }
                });
                filterDropdown.classList.toggle('active');

                // Check if this is the last filter button (in document order)
                const isLastFilterBtn = filterBtn === allFilterBtns[allFilterBtns.length - 1];

                const dropdowns = document.querySelectorAll('.common-filter .common-filter__dropdown');
                const lastDropdown = dropdowns[dropdowns.length - 1];

                if (isLastFilterBtn) {
                    if (lastDropdown) {
                        lastDropdown.style.left = '-100px';
                    }
                }

            });
            clearBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                group.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
            document.addEventListener('click', (e) => {
                if (!group.contains(e.target)) {
                    filterDropdown.classList.remove('active');
                }
            });
        });


        // common dropdown filter  js

        // toltip js
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        // toltip js


        // progress bar  js
        document.querySelectorAll('.progress-animated-line').forEach(line => {
            const percent = line.getAttribute('data-progress');
            setTimeout(() => {
                line.style.width = percent + '%';
            }, 100);
        });
        // progress bar  js

        // ========================= Small Device Search And Little Bit Header Item Js Start =====================
        $(".button-comment").on("click", (e) => {
            $(".video-comment").toggleClass("show")
            $(".body-overlay").toggleClass("show");
        });
        $(".common-action-close, .body-overlay").on("click", e => {
            e.stopPropagation();
            $(".video-comment").removeClass("show");
            $(".body-overlay").removeClass("show");
        });

        $(".has-sidebar").on("click", function () {
            $(".sidebar-menu").toggleClass("show-sm").removeClass('show-sm');
        });
        $(".sidebar_left-close").on("click", function () {
            $(".sidebar-menu").removeClass("show-sm").addClass('show-sm');
        });
        // Body click to close sidebar if open

        $(".sm-search-btn").on("click", function () {
            $(".search-close").toggleClass("show");
            $(".search-form").toggleClass("show");
        });
        $(".body-overlay, .search-close").on("click", function () {
            $(".search-close").removeClass("show");
            $(".search-form").removeClass("show");
        });

        $(".sm-message-box ").on("click", function () {
            $(".message-sidebar").toggleClass("show");
        });
        $(".common-action-close").on("click", function () {
            $(".message-sidebar").removeClass("show");
        });

        $(".comment__details-btn").on("click", function () {
            $(".comment__details").toggleClass("show");
            $(".body-overlay").toggleClass("show");
        });
        $(".body-overlay, .sidebar-menu__close").on("click", function () {
            $(".body-overlay").removeClass("show");
            $(".comment__details").removeClass("show");
        });

        $('.showFilterBtn').on('click', function () {
            $('.responsive-filter-card').toggleClass('show');
        });


        // Notification js

        $('.notification-btn').on('click', function (event) {
            event.stopPropagation();
            $('.notification-dropdown').toggleClass("show")
        })
        $('body').on('click', function () {
            $('.notification-dropdown').removeClass('show');
        })
        // Notification js

        // view time js


        let seconds = 0;
        const timerDisplay = document.getElementById('playTime');

        function updateTimer() {
            if (!timerDisplay) return;

            seconds++;

            const hrs = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            timerDisplay.textContent = `${hrs}h:${mins.toString().padStart(2, '0')}m:${secs.toString().padStart(2, '0')}s`;
        }

        setInterval(updateTimer, 1000);


        // Sidebar Icon & Overlay js
        $('.sidebar-trigger').on('click', function () {
            $('.setting-menu').addClass('show');
            $('.body-overlay').addClass('show');
        });
        $('.sidebar-menu__close, .body-overlay').on('click', function () {
            $('.setting-menu').removeClass('show');
            $('.body-overlay').removeClass('show');
        })
        // Sidebar Dropdown Menu Start
        $(".has-dropdown > a").click(function () {
            $(".dashboard-sidebar-submenu").slideUp(200);
            if (
                $(this)
                    .parent()
                    .hasClass("active")
            ) {
                $(".has-dropdown").removeClass("active");
                $(this)
                    .parent()
                    .removeClass("active");
            } else {
                $(".has-dropdown").removeClass("active");
                $(this)
                    .next(".dashboard-sidebar-submenu")
                    .slideDown(200);
                $(this)
                    .parent()
                    .addClass("active");
            }
        });
        // Sidebar Dropdown Menu End
        // Sidebar Icon & Overlay js
        $(".dashboard-body__bar-icon").on("click", function () {
            $(".dashboard-sidebar-menu").addClass('show-sidebar');
            $(".sidebar-overlay").addClass('show');
        });
        $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
            $(".dashboard-sidebar-menu").removeClass('show-sidebar');
            $(".sidebar-overlay").removeClass('show');
        });
        // Sidebar Icon & Overlay js


        // filter button action

        // ========================= Small Device Search And Little Bit Header Item Js End =====================
        const container = document.getElementById('scrollContainer');
        if (container) {
            const btnLeft = document.getElementById('scrollLeft');
            const btnRight = document.getElementById('scrollRight');
            const toggleButtons = () => {
                const maxScroll = container.scrollWidth - container.clientWidth;
                btnLeft.style.display = container.scrollLeft > 0 ? 'block' : 'none';
                btnRight.style.display = container.scrollLeft < maxScroll - 1 ? 'block' : 'none';
            };

            btnLeft.onclick = () => container.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
            btnRight.onclick = () => container.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
            container.onscroll = toggleButtons;
            window.onload = toggleButtons;

            document.querySelectorAll('.menu-link').forEach(link =>
                link.onclick = () => {
                    document.querySelectorAll('.menu-link').forEach(el => el.classList.remove('active'));
                    link.classList.add('active');
                }
            );

            let isDown = false,
                startX, scrollLeft, isDragging = false;

            const setPointerEvents = val =>
                container.querySelectorAll('a').forEach(a =>
                    a.addEventListener('click', e => {
                        if (isDragging) {
                            e.preventDefault();
                        }
                    })
                );

            const startDrag = e => {
                isDown = true;
                isDragging = false;
                startX = (e.touches ? e.touches[0].pageX : e.pageX) - container.offsetLeft;
                scrollLeft = container.scrollLeft;
                container.classList.add('dragging');
            };

            const endDrag = () => {
                isDown = false;
                container.classList.remove('dragging');
                setTimeout(() => {
                    isDragging = false;
                }, 0);
            };

            const drag = e => {
                if (!isDown) return;
                e.preventDefault();
                const x = (e.touches ? e.touches[0].pageX : e.pageX) - container.offsetLeft;
                const walk = (x - startX) * 1.5;
                if (Math.abs(walk) > 5) isDragging = true;
                container.scrollLeft = scrollLeft - walk;
            };

            container.addEventListener('mousedown', startDrag);
            container.addEventListener('touchstart', startDrag);
            container.addEventListener('mouseup', endDrag);
            container.addEventListener('mouseleave', endDrag);
            container.addEventListener('touchend', endDrag);
            container.addEventListener('mousemove', drag);
            container.addEventListener('touchmove', drag);

            container.querySelectorAll('a').forEach(a =>
                a.addEventListener('click', e => {
                    if (isDragging) e.preventDefault();
                })
            );
        }


        // ========================= Wow Js Start=====================
        new WOW().init();
        // ========================= Wow Js End=====================
        /* ==================== Slick Slider Initialization JS Start ==================== */
        const sliderConfig = {
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            speed: 1500,
            dots: true,
            pauseOnHover: true,
            arrows: false,
            prevArrow: '<button type="button" class="slick-prev"><i class="las la-arrow-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="las la-arrow-right"></i></button>',
        };

        $('.shorts-video_sliders').slick({
            infinite: false,
            dots: false,
            arrows: true,
            vertical: true,
            verticalSwiping: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-up"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-down"></i></button>',
            appendArrows: $('.shorts-video_arrows')
        });

        $('.shorts-video_sliders').on('wheel', function (e) {
            e.preventDefault();
            if (e.originalEvent.deltaY < 0) {
                $(this).slick('slickPrev');
            } else {
                $(this).slick('slickNext');
            }
        });


        /* ==================== Slick Slider Initialization JS End ====================== */


        /* ==================== Password Toggle JS Start ================================ */
        $('.input--group-password').each(function (index, inputGroup) {
            let inputGroupBtn = $(inputGroup).find('.input-group-btn');
            let formControl = $(inputGroup).find('.form-control.form--control');

            inputGroupBtn.on('click', function () {
                if (formControl.attr('type') === 'password') {
                    formControl.attr('type', 'text');
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    formControl.attr('type', 'password');
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
        /* ==================== Password Toggle JS End ================================== */
    });
    /* ==================== Ready Function End ============================ */

    /* ==================== Header Fixed JS Start ========================= */
    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= 150) {
            $('.setting-header, .mobile-top-menu').addClass('fixed-header');
        } else {
            $('.setting-header, .mobile-top-menu').removeClass('fixed-header');
        }
    });
    /* ==================== Header Fixed JS End ============================= */

    /* ==================== Scroll To Top Button JS Start ==================== */
    let scrollTopBtn = $('.scroll-top');

    if (scrollTopBtn.length) {
        let progressPath = scrollTopBtn.find('.scroll-top-progress path');
        let pathLength = progressPath[0].getTotalLength();
        let offset = 250;
        let duration = 550;

        progressPath.css({
            transition: 'none',
            WebkitTransition: 'none',
            strokeDasharray: `${pathLength} ${pathLength}`,
            strokeDashoffset: pathLength,
            transition: 'stroke-dashoffset 10ms linear',
            WebkitTransition: 'stroke-dashoffset 10ms linear',
        });

        function updateProgress() {
            let scroll = $(window).scrollTop();
            let height = $(document).height() - $(window).height();
            let progress = pathLength - (scroll * pathLength / height);
            progressPath.css('strokeDashoffset', progress)
        }

        updateProgress();

        $(window).on('scroll', function () {
            updateProgress();
            if ($(this).scrollTop() > offset) {
                scrollTopBtn.addClass('active');
            } else {
                scrollTopBtn.removeClass('active');
            }
        });

        scrollTopBtn.on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        });
    }

    // Disabled scroll top for account pages
    if ($(scrollTopBtn).next(':is(.page-wrapper)').find('.account').length) {
        $(scrollTopBtn).hide();
    }
    /* ==================== Scroll To Top Button JS End ==================== */

    // ========================= Video js Js start ===================
    $(document).ready(function () {
        $('.video-player').each(function () {
            new Plyr(this);
        });
    });



    /* ==================== Preloader JS Start ============================== */
    $(window).on('load', () => $('.preloader').fadeOut());
    /* ==================== Preloader JS End ================================ */


    /* ==================== Highlight Word JS Start ================================ */
    $("[data-highlight]").each(function () {
        const $this = $(this);
        let originalText = $this.text().trim().split(" ");
        let textLength = originalText.length;
        const highlight = $this.data("highlight").toString();
        const highlight_class = $this.data("highlight-class") ? $this.data("highlight-class") || "text--base" : "text--base";
        const highlightToArray = highlight.split(",");
        // Loop through each highlight range
        $.each(highlightToArray, function (i, element) {
            const index = element.toString().split("_");
            var startIndex = index[0];
            var endIndex = index.length > 1 ? index[1] : startIndex;
            if (startIndex < 0) {
                startIndex = textLength - Math.abs(startIndex);
            }
            if (endIndex < 0) {
                endIndex = textLength - Math.abs(endIndex);
            }
            const startIndexValue = originalText[startIndex];
            const endIndexValue = originalText[endIndex];
            if (startIndex === endIndex) {
                originalText[
                    startIndex
                ] = `<span class="${highlight_class}">${startIndexValue}</span>`;
            } else {
                originalText[
                    startIndex
                ] = `<span class="${highlight_class}">${startIndexValue}`;
                originalText[endIndex] = `${endIndexValue}</span>`;
            }
        });
        $this.html(originalText.join(" "));
    });
    /* ==================== Highlight Word JS End ================================== */

})(jQuery);