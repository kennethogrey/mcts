<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <title>@yield('title')</title>
        <base href="{{ URL::to('/') }}">
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
        <meta name="author" content="Codedthemes" />
        <!-- Favicon icon -->
        <link href="{{asset('landings/assets/img/favicon.png')}}" rel="icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
        <!-- waves.css -->
        <link rel="stylesheet" href="{{asset('assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap/css/bootstrap.min.css')}}">
        <!-- waves.css -->
        <link rel="stylesheet" href="{{asset('assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
        <!-- themify icon -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/icon/themify-icons/themify-icons.css')}}">
        <!-- font-awesome-n -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome-n.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
        <!-- scrollbar.css -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.mCustomScrollbar.css')}}">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
        @yield('styles')
    </head>

    <body>
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="loader-track">
                <div class="preloader-wrapper">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar">
                            <div class="pcoded-inner-navbar main-menu">
                                <div class="p-15 p-b-0">
                                    <form class="form-material">
                                        <div class="form-group form-primary">
                                            <input type="text" name="footer-email" class="form-control">
                                            <span class="form-bar"></span>
                                            <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Child</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="pcoded-navigation-label">Reviews</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="//" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-layers"></i></span>
                                            <span class="pcoded-mtext">Feedbacks</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10"> All Devices in the Queuing Job</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                        @yield('content')
                    </div>    
                </div>
            </div>
        </div>

        <!-- Required Jquery -->
        <script type="text/javascript" src="{{asset('assets/js/jquery/jquery.min.js ')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/jquery-ui/jquery-ui.min.js')}} "></script>
        <script type="text/javascript" src="{{asset('assets/js/popper.js/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/bootstrap/js/bootstrap.min.js')}} "></script>
        <!-- waves js -->
        <script src="{{asset('assets/pages/waves/js/waves.min.js')}}"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="{{asset('assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

        <!-- slimscroll js -->
        <script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}} "></script>

        <!-- menu js -->
        <script src="{{asset('assets/js/pcoded.min.js')}}"></script>
        <script src="{{asset('assets/js/vertical/vertical-layout.min.js ')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/script.js')}} "></script>
        @stack('scripts')
    </body>
</html>