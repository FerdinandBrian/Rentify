<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Rentify User Dashboard')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/premium-rentify.css') }}" />

    <style>
        .main-header,
        .navbar-header,
        .main-panel {
            overflow: visible;
        }

        .topbar-user .dropdown-menu {
            z-index: 1080;
            right: 0;
            left: auto;
        }

        .rentify-page-lead {
            max-width: 720px;
            color: #6c757d;
        }

        .rentify-empty {
            padding: 48px 16px;
            text-align: center;
        }

        .rentify-empty i {
            opacity: .45;
        }

        .rentify-soft-card {
            border: 0;
            box-shadow: 0 6px 18px rgba(31, 58, 90, .08);
        }

        .rentify-action-list .btn {
            justify-content: flex-start;
            text-align: left;
        }

        @media (max-width: 575.98px) {
            .page-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }

            .profile-username {
                display: none;
            }
        }
    </style>

    @yield('extraCSS')

</head>

<body class="antialiased">
    <div class="grid-overlay"></div>
    <div class="floating-orb bg-orange-500" style="top: 10%; left: 10%; width: 300px; height: 300px;"></div>
    <div class="floating-orb bg-blue-500" style="bottom: 10%; right: 10%; width: 400px; height: 400px;"></div>
    <div class="wrapper">
        @include('layouts.User.sidebar')

        <div class="main-panel">
            @include('layouts.User.header')

            @yield('content')

            @include('layouts.User.footer')
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Google Maps Plugin -->
    <script src="{{ asset('assets/js/plugin/gmaps/gmaps.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    @yield('extraJS')
</body>

</html>
