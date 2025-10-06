<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ config('app.name', 'KOMINFO') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="Aplikasi Pendaftaran Pengembangan Sistem Informasi Dinas Kominfo Provinsi Jawa Timur">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="stylesheet" href="{{ url('/assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/pe-icon-7-stroke/css/helper.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <link src="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ url('/assets/main.css') }}" rel="stylesheet">

    <link href="{{ url('/assets/global/plugins/bootstrap-toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/global/plugins/sweetalert2/sweetalert2.css')}}" rel="stylesheet" type="text/css" />

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ url('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ url('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <style>
        .select2-selection__rendered {
          line-height: 38px !important;
        }

        .select2-selection {
          height: 38px !important;
        }

        .select2-selection__choice {
            height: 35px !important;
            margin-top: 0px !important;
        }

        .btn-rata {
            width: 100px !important;
        }
    </style>
    @stack('custom-css')

</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">

    @include('layouts.header')


    <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    @include('layouts.menu')
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @yield('content')
                </div>

                @include('layouts.footer')
            </div>
    </div>
</div>

<div class="app-drawer-overlay d-none animated fadeIn"></div>

<script src="{{ url('/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/jquery-nicescroll/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/numeral.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/bootstrap-toastr/toastr.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/global/plugins/sweetalert2/sweetalert2.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ url('/assets/scripts/main.js') }}"></script>
<script src="{{  url('/assets/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@stack('custom-scripts')

<script type="text/javascript">

$(document).ready(function(){
    $('.select2').select2();
    @if(session()->has('success'))
    toastr["success"]("Sukses", "{{ session()->get('success') }}");
    @endif

    @if(session()->has('warning'))
    toastr["warning"]("Peringatan", "{{ session()->get('warning') }}");
    @endif

    @if(session()->has('error'))
    toastr["error"]("Gagal", "{{ session()->get('error') }}");
    @endif


});

</script>

</body>

</html>
