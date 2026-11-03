<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="author" content="{{ getSetting('web_owner') }}">
    <meta name="keywords" content="{{ getSetting('web_keyword') }}">
    <link rel="shortcut icon" href="{{ berkas( getSetting('favicon')) }}">
    @if(request()->segment(1) == 'home' && request()->segment(2) == 'search')
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="all,index,follow">
    @endif
    <meta http-equiv="Content-Language" content="id-ID">
    <meta NAME="Distribution" CONTENT="Global">
    <meta NAME="Rating" CONTENT="General">
    <link rel="canonical" href="{{ url()->full() }}" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:site_name" content="{{  getSetting('web_name') }}" />
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ getSetting('web_name') }}</title>

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <!-- Global stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
    <link href="{{ callassetspath('frontend/theme-2024limitless/global/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css">
    <!--[if (lt IE 9)]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.helper.ie8.js"></script>
    <![endif]-->
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            200: '#BFDBFE',
                            500: '#3B82F6',
                            600: '#2563EB',
                            700: '#1D4ED8',
                            800: '#1E40AF',
                            900: '#0F2F64',
                        },
                        navy: {
                            800: '#0B2545',
                            900: '#071A30',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ callassetspath('frontend/theme-2024limitless/app/css/bappeda-redesign.css')}}?v={{ time() }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ callassetspath('frontend/theme-2024limitless/global/js/main/jquery.min.js')}}"></script>
    <script src="{{ callassetspath('frontend/theme-2024limitless/global/js/main/bootstrap.bundle.min.js')}}"></script>

    @if(env('G_ANAL_MEASUREMENT_ID'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('G_ANAL_MEASUREMENT_ID')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{env("G_ANAL_MEASUREMENT_ID")}}', {
            @if(env('G_STREAM_NAME'))
            stream_name: '{{env('G_STREAM_NAME')}}'
            @endif
        });
    </script>
    @endif

    <link rel="stylesheet" href="{{ callassetspath('css/video-popup.css') }}">
    @stack('css')

    <script>
        window.Laravel = <?php echo json_encode([
                                'csrfToken' => csrf_token(),
                            ]); ?>
    </script>

    @stack('mapscripts')
</head>

<body>
    <?php
    $ukuranlebarlogo = 50;
    if (berkas(getSetting('logo'))) {
        $ukuranlebarlogo = getImageRatio(berkasLogo(getSetting('logo')));
    }

    ?>
    @include('theme-2024limitless.partials.header')

    @yield('content')


    @include('theme-2024limitless.partials.footer')


    <script src="{{ callassetspath('js/video-popup.js') }}"></script>
    @stack('scripts')

    <script src="{{ callassetspath('frontend/theme-2024limitless/global/js/plugins/media/fancybox.min.js')}}"></script>
    <script>
        $(document).ready(function() {

            $('[data-popup="lightbox"]').fancybox({
                padding: 3
            });



        });

        $('.dropdown-submenu > a').on("click", function(e) {
            var submenu = $(this);
            submenu.closest('.dropdown-menu').find('.dropdown-menu').removeClass('show');
            submenu.next('.dropdown-menu').toggleClass('show');
            e.stopPropagation();
        });


        $('.dropdown').on("hidden.bs.dropdown", function() {

            $('.dropdown-menu.show').removeClass('show');
        });
    </script>
    
    <script> window.addEventListener("load", (event) => { setTimeout(() => { let aioa_script_tag = document.createElement("script"); aioa_script_tag.src = "https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#420083&token=&position=bottom_right"; aioa_script_tag.id = "aioa-adawidget"; document.getElementsByTagName("body")[0].appendChild(aioa_script_tag); }, 3000)}); </script>
    <!-- Untuk Share ke beberapa sosmed -->
    <script>
        function changeFontSize(delta) {
            var html = document.documentElement;
            if (delta === 0) {
                html.style.fontSize = '';
            } else {
                var current = parseFloat(window.getComputedStyle(html).fontSize) || 16;
                var newSize = Math.max(13, Math.min(22, current + delta));
                html.style.fontSize = newSize + 'px';
            }
        }

        function toggleNavSearch() {
            var searchBar = document.getElementById('nav-search-bar');
            if (!searchBar) return;
            searchBar.classList.toggle('hidden');
            if (!searchBar.classList.contains('hidden')) {
                document.getElementById('nav-search-input')?.focus();
            }
        }
    </script>
</body>

</html>
