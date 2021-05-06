<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_base_url" content="{{ url('/') }}">
    <title>Fisheries Tracker</title>

    {{--    Bootstrap   --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{--    Font    --}}
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


    {{--    Custom CSS--}}
    <link rel="stylesheet" href="{{ asset("public/assets/user-pages-assets/css/style.css") }}">

    {{--    ajax CDN    --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{--chart js--}}
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>--}}
</head>
<body>
<div class="container" id="user-page-main-body">
    <div class="container">
            <div class="row" id="user-page-header">
                <div class="col-md-6">
                    <div class="row">
                        <img id="bangladesh-gov-log" src="public/assets/user-pages-assets/images/bangladesh-gov-logo.png" alt="bangladesh-govt-logo">
                        <div id="vertical-line"></div>
                        <span><h4 id="app-name-heading">Fisheries <img src="public/assets/user-pages-assets/images/fish-icon-3.png" style="background-color: white; max-width: 85px; max-height: 50px"> Tracker</h4></span>
                    </div>
                </div>
                <div class="col-md-6" id="search-login-section-paraent">
                    <div id="search-login-section">
                        <div class="row">
                            <div class="col-2">

                            </div>
                            <div class="col-8" style="padding: 0px">
                                <div class="input-group" style=" width: 241px; float: right">
                                    <div class="form-outline" >
                                        <input type="search" id="search-field" class="form-control" style="width: 200px" />
                                    </div>
                                    <button type="button" class="btn btn-primary" id="search-button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" style="float: left;">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-6"></div>
            <div class="col-6" style="padding-right: 0px;">
                <nav class="float-right navbar navbar-expand-lg navbar-light">
                    {{--        <a class="navbar-brand" href="#">Navbar</a>--}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-element btn btn-sm btn-outline-secondary" type="button">Home</a>
                                {{--                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                            </li>
                            <li class="nav-item">
                                <a class="nav-element btn btn-sm btn-outline-secondary" href="#">Capture</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-element btn btn-sm btn-outline-secondary" href="#">Culture</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-element btn btn-sm btn-outline-secondary" href="#">Marine</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-element btn btn-sm btn-outline-secondary" href="#">Hilsa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-element btn btn-sm btn-outline-secondary" href="#">Prawn</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-element btn btn-sm btn-outline-secondary" href="#">About</a>
                            </li>
                        </ul>
                    </div>
                </nav >
            </div>
        </div>
    </div>

{{--    <div class="row" style="margin-top: 20px;">--}}
{{--    </div>--}}
    <hr style="height:3px;border-width:0;color:gray;background-color:gray">
    @yield('home')
    @yield('culture-home')
</div>
</body>

{{--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
{{--<script src="https://rawgit.com/emn178/chartjs-plugin-labels/master/src/chartjs-plugin-labels.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

@yield('javascript')
{{--@include('user/javascript')--}}
</html>
