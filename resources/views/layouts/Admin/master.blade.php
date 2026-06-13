<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Rentify Admin Dashboard</title>
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

    @yield('extraCSS')

</head>

<body class="antialiased">
    <div class="grid-overlay"></div>
    <div class="floating-orb bg-orange-500" style="top: 10%; left: 10%; width: 300px; height: 300px;"></div>
    <div class="floating-orb bg-blue-500" style="bottom: 10%; right: 10%; width: 400px; height: 400px;"></div>
    <div class="wrapper">
        @include('layouts.Admin.sidebar')

        <div class="main-panel">
            @include('layouts.Admin.header')

            @yield('content')

            @include('layouts.Admin.footer')
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

    <!-- Global SweetAlert Confirmation Interceptor -->
    <script>
        $(document).ready(function() {
            // Bind directly to elements with inline onclick confirm to reliably prevent default submit
            $('[onclick*="confirm"]').each(function() {
                var element = $(this);
                var onclickAttr = element.attr('onclick');
                var match = onclickAttr.match(/confirm\(\s*['"`](.*?)['"`]\s*\)/);
                var message = match ? match[1] : 'Apakah Anda yakin?';
                
                element.removeAttr('onclick');
                
                element.on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var form = element.closest('form');
                    
                    triggerSweetAlert(message, function() {
                        if (element.is('a') && element.attr('href') && element.attr('href') !== '#' && !element.attr('href').startsWith('javascript:')) {
                            window.location.href = element.attr('href');
                        } else if (form.length > 0) {
                            form[0].submit(); // Bypasses jQuery listener to avoid recursion
                        }
                    });
                });
            });

            // Bind directly to forms with inline onsubmit confirm
            $('form[onsubmit*="confirm"]').each(function() {
                var form = $(this);
                var onsubmitAttr = form.attr('onsubmit');
                var match = onsubmitAttr.match(/confirm\(\s*['"`](.*?)['"`]\s*\)/);
                var message = match ? match[1] : 'Apakah Anda yakin?';
                
                form.removeAttr('onsubmit');
                
                form.on('submit', function(e) {
                    e.preventDefault();
                    
                    triggerSweetAlert(message, function() {
                        form[0].submit(); // Bypasses jQuery listener to avoid recursion
                    });
                });
            });

            function triggerSweetAlert(message, callback) {
                var isDanger = /hapus|tolak|batal|permanen/i.test(message);
                var confirmText = "Ya, Lanjutkan";
                
                if (isDanger) {
                    if (/hapus/i.test(message)) confirmText = "Ya, Hapus";
                    else if (/batal/i.test(message)) confirmText = "Ya, Batalkan";
                    else if (/tolak/i.test(message)) confirmText = "Ya, Tolak";
                } else {
                    if (/setuju/i.test(message)) confirmText = "Ya, Setujui";
                    else if (/konfirmasi/i.test(message)) confirmText = "Ya, Konfirmasi";
                }

                swal({
                    title: isDanger ? "Konfirmasi Hapus / Pembatalan" : "Konfirmasi Tindakan",
                    text: message,
                    icon: isDanger ? "warning" : "info",
                    buttons: {
                        cancel: {
                            text: "Batal",
                            value: null,
                            visible: true,
                            className: "btn btn-light",
                            closeModal: true,
                        },
                        confirm: {
                            text: confirmText,
                            value: true,
                            visible: true,
                            className: isDanger ? "btn btn-danger" : "btn btn-success",
                            closeModal: true
                        }
                    },
                    dangerMode: isDanger,
                }).then(function(willSubmit) {
                    if (willSubmit) {
                        callback();
                    }
                });
            }
        });
    </script>

    @yield('extraJS')
</body>

</html>
