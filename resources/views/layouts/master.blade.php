<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>WholeSale App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Tahira Anwar">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <!-- App Notification -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/toastr/build/toastr.min.css')}}">

    <!-- Custome Css -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/css/customCss/select2.min.css')}}" />
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" />
    <!-- Sumoselect-->
    <link href="{{asset('assets/css/customCss/sumoselect.css')}}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Sweet Alerts -->
    <link href="{{asset('assets/css/customCss/sweetalert2.min.css')}}" rel="stylesheet" />
    <!-- Summernote css -->
    <link href="{{asset('assets/libs/summernote/summernote-bs4.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker {
            z-index: 1200 !important;
            /* has to be larger than 1050 */
        }
    </style>
    <!-- Calendar -->
    <link href="{{asset('assets/calendar/style.css')}}" rel="stylesheet" type="text/css" />
    <!-- Tui Calendar -->
    <link href="{{asset('assets/libs/tui-time-picker/tui-time-picker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/tui-date-picker/tui-date-picker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/tui-calendar/tui-calendar.min.css')}}" rel="stylesheet" type="text/css" />
    @yield('css')
</head>


<body data-sidebar="dark">
    <div id="app">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{route('home')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="17">
                                </span>
                            </a>

                            <a href="{{route('home')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="50">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="bx bx-search-alt"></span>
                            </div>
                        </form>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ml-2">
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-5.jpg" alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ml-1" key="t-henry">{{head(explode(' ', trim(Auth::user()->name)))}}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                                    <span key="t-logout">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>

                            <li>
                                <a href="{{route('home')}}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboards</span>
                                </a>
                            </li>

                            @if(Auth::user()->role->name == "Admin" || Auth::user()->role->name == "Client" )
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-package"></i>
                                    <span key="t-layouts">Products</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                @if(Auth::user()->role->name == "Admin")
                                    <li><a href="{{ route('product.index') }}" key="t-light-sidebar">Product List</a></li>
                                @endif
                                @if(Auth::user()->role->name == "Client")
                                    <li><a href="{{ route('product-client.index') }}" key="t-light-sidebar">Product List</a></li>
                                @endif
                                </ul>
                            </li>
                            @endif

                            @if(Auth::user()->role->name == "Admin" )
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account-check-outline"></i>
                                    <span key="t-layouts">Clients</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li>
                                        <a href="{{ route('client.index') }}" key="t-light-sidebar">Clients List</a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <main class="py-4">
                @yield('content')
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Design &amp; Develop by <a href="#">Tahira Anwar</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- END layout-wrapper -->
        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> -->
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- apexcharts -->
        <!-- <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script> -->

        <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- App js -->
        <script src="{{asset('assets/js/app.js')}}"></script>
        <!-- form adv -->
        <!-- <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script> -->

        <!-- sumoselect -->
        <script src="{{asset('assets/js/customJs/jquery.sumoselect.js')}}"></script>
        <!-- Select2 -->
        <script src="{{asset('assets/js/customJs/select2.full.min.js')}}"></script>

        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

        <script src="{{asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>


        <!-- DataTables -->

        <!-- Sweet Alerts -->
        <script src="{{asset('assets/js/customJs/sweetalert2.min.js')}}"></script>
        <!-- END: Page JS-->

        <!--tinymce js-->
        <script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

        <!-- Summernote js -->
        <script src="{{asset('assets/libs/summernote/summernote-bs4.min.js')}}"></script>

        <!-- init js -->
        <script src="{{asset('assets/js/pages/form-editor.init.js')}}"></script>


        <!-- toastr plugin -->
        <script src="{{asset('assets/libs/toastr/build/toastr.min.js')}}"></script>

        <!-- toastr init -->
        <script src="{{asset('assets/js/pages/toastr.init.js')}}"></script>

        <!-- tui Calendar -->
        <script src="{{asset('assets/js/tui-code-snippet.min.js')}}"></script>
        <script src="{{asset('assets/libs/tui-dom/tui-dom.min.js')}}"></script>

        <script src="{{asset('assets/libs/tui-time-picker/tui-time-picker.min.js')}}"></script>
        <script src="{{asset('assets/libs/tui-date-picker/tui-date-picker.min.js')}}"></script>

        <script src="{{asset('assets/libs/tui-calendar/tui-calendar.min.js')}}"></script>
        <!-- Calendar -->
        <script src="{{asset('assets/calendar/script.js')}}"></script>

        <script>
            $(document).ready(function() {
                $(".select2").select2();
            });
        </script>
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        @yield('js')
    </div>
</body>

</html>