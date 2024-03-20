<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>@yield('page_title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Author-->
    <meta name="author" content="Bitech" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    {{-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"> --}}
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css ') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/toast.min.css') }}">


    <!-- Custom css  -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        :root {
            /*#28aaa9*/
            --primary-color: #000000;
            /*#2b2d5d*/
            --secondary-color: #000000;
        }
    </style>

    <style>
        .al_bg {
            background: linear-gradient(to right, #b04300, #ff0000) !important;
        }
    </style>

</head>

<body>
    {{--     
    <div class="ic-preloader">
        <div class="ic-inner-preloader">
            <div class="db-spinner"></div>
        </div> --}}
    </div>
    <div id="wrapper">

        @include('layouts.head')

        @include('layouts.nav')



        <div class="content-page">
            @yield('page_content')
        </div>

        <footer class="footer">
            © {{ date('Y') }} All Right Reserved | Design &amp; Developed by bitechnology</a>
        </footer>


        <!-- App's Basic Js  -->
        <script src="{{ asset('assets/js/jquery.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/js/waves.min.js?v=3.5') }}"></script>
        <!-- App js-->
        <script src="{{ asset('assets/js/app.js?v=3.5') }}"></script>

        <script src="{{ asset('assets/js/slick.min.js?v=3.5') }}"></script>
        <!-- Vue -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <!-- Load script form view  -->



        {{-- <script src="{{ asset('assets/js/custom.js?v=3.5') }}"></script> --}}
        <script src="{{ asset('assets/js/custom-dev.js?v=3.5') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/toast.js') }}"></script>

        @if (session('error'))
            <script>
                Toastify({
                    text: "<?= session('error') ?>",
                    duration: 5000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #b04300, #ff0000)",
                    },
                }).showToast();
            </script>
        @endif

        @if (session('success'))
            <script>
                Toastify({
                    text: "<?= session('success') ?>",
                    duration: 5000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #00b09b, #01ff01)",
                    },
                }).showToast();
            </script>
        @endif


        <script>
            $(function() {
                setTimeout(function() {
                    $(".refresh").fadeOut(3000);
                }, 3000);

            })
        </script>



        @stack('scripts')


    </div>
</body>

</html>
