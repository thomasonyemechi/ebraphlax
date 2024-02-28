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

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css ') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/flaticon/font/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable -->
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Datepicker  -->
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet">
    <!-- Chartist  -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/chartist/css/chartist.min.css') }}">
    <!-- Select2  -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- include summernote css/js -->
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.css') }}">
    <!-- Load style form view css -->

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
        <!-- Sweet-Alert  -->
        <script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/pages/sweet-alert.init.js?v=3.5') }}"></script>
        <!-- Required datatable js -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js?v=3.5') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js?v=3.5') }}"></script>

        <script src="{{ asset('assets/plugins/select2/js/select2.min.js?v=3.5') }}"></script>
        <!-- Datepicker  -->
        <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js?v=3.5') }}"></script>
        <!-- Chart  -->
        <script src="{{ asset('assets/plugins/chartjs/Chart.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/plugins/chartist/js/chartist.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/plugins/chartist/js/chartist-plugin-tooltip.min.js?v=3.5') }}"></script>
        <!-- peity JS -->
        <script src="{{ asset('assets/plugins/peity-chart/jquery.peity.min.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js?v=3.5') }}"></script>
        <!-- Vue -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <!-- Load script form view  -->



        <script src="{{ asset('assets/js/custom.js?v=3.5') }}"></script>
        <script src="{{ asset('assets/js/custom-dev.js?v=3.5') }}"></script>



    </div>
</body>

</html>
