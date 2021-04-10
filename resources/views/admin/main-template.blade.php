<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="_base_url" content="{{ url('/') }}">
        <title>Dataful</title>

        <link type="text/css" href="{{ asset('public/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('public/assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{asset('public/assets/css/theme.css')}}" rel="stylesheet">
        <link type="text/css" href="{{asset('public/assets/images/icons/css/font-awesome.css')}}" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
              rel='stylesheet'>

        {{--        fa fa icon--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        {{--        custom stylesheet--}}
        <link rel="stylesheet" href="{{ asset("public/assets/css/style.css") }}">

        {{--        bootstrap--}}
    </head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <i class="icon-reorder shaded"></i></a><a class="brand" href="index.html">Dataful </a>
            <div class="nav-collapse collapse navbar-inverse-collapse">
                <ul class="nav pull-right">
                    <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('public/assets/images/user.png')}}" class="nav-avatar" />
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Your Profile</a></li>
                            <li><a href="#">Edit Profile</a></li>
                            <li><a href="#">Account Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.nav-collapse -->
        </div>
    </div>
    <!-- /navbar-inner -->
</div>
<!-- /navbar -->
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="span3">
                <div class="sidebar">
                    <ul class="widget widget-menu unstyled">
                        <li class="active"><a href="{{ url('admin/dashboard') }}"><i class="menu-icon icon-dashboard"></i>Dashboard
                            </a></li>
                        </li>
                        <li><a href="{{ route('capture-index') }}"><i class="menu-icon icon-inbox"></i>Capture<b class="label green pull-right">11</b> </a></li>
                        <li><a href="{{ url('#') }}"><i class="menu-icon icon-inbox"></i>Culture </a></li>
                        <li><a href="{{ url('#') }}"><i class="menu-icon icon-inbox"></i>Marine</a></li>
                        <li><a href="{{ url('#') }}"><i class="menu-icon icon-inbox"></i>Hilsa</a></li>
                        <li><a href="{{ url('#') }}"><i class="menu-icon icon-inbox"></i>Shrimp/Prawn</a></li>



                        {{--                        Table's Options--}}
                        <ul class="widget widget-menu unstyled">
                            <li><a class="collapsed" data-toggle="collapse" href="#togglePages2"><i class="menu-icon icon-table">
                                    </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                    </i>Table </a>
                                <ul id="togglePages2" class="collapse unstyled">
                                    <li><a href="{{ url('/admin/upload-excel') }}"><i class="icon-plus-sign"></i>Create Table </a></li>
                                    <li><a href="{{ url('/admin/tables') }}"><i class="icon-inbox"></i>View Tables </a></li>
                                </ul>
                            </li>
                        </ul>
                    </ul>
                    <!--/.widget-nav-->

                </div>
                <!--/.sidebar-->
            </div>

            @yield('capture')
            @yield('create-article-from')
            @yield('all-articles')
            @yield('all-tables')
            @yield('all-graphs')

        </div>
    </div>
    <!--/.container-->
</div>
<!--/.wrapper-->
<script src="{{asset('public/assets/scripts/jquery-1.9.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/scripts/jquery-ui-1.10.1.custom.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('../assets/scripts/flot/jquery.flot.js')}}" type="text/javascript"></script>--}}
{{--<script src="{{asset('../assets/scripts/flot/jquery.flot.resize.js')}}" type="text/javascript"></script>--}}
<script src="{{asset('public/assets/scripts/datatables/jquery.dataTables.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('../assets/scripts/common.js')}}" type="text/javascript"></script>--}}

{{--    for toaster--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

{{--chart js--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

@yield('script')

</body>
