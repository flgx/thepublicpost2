<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="">
    <meta name="author" content="">
    <title>The Public Post | @yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/jssocials.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/jssocials-theme-flat.css')}}" rel="stylesheet">

    @yield('css')
    <link href="{{asset('dist/icons/style.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/ninja-slider.css')}}" rel="stylesheet">
    <script src="{{asset('dist/js/ninja-slider.js')}}"></script>
    <link href="{{asset('dist/css/thumbnail-slider.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('dist/js/thumbnail-slider.js')}}" type="text/javascript"></script>
    <style>
        .caption span {
            display: block;
            color: #ccc;
        }
        #thumbnail-slider li {
            display: flex !important;
            border: 0 !important;
            align-items: center;
            justify-content: center;
        }
        #thumbnail-slider li .title {
            font-size: 12px;
            margin: 0 10px;
            color: #000;
        }
        #thumbnail-slider .thumb {
            position: relative;
            transition: all 0.5s;
            border: 3px solid transparent;
        }
        #thumbnail-slider li:hover .thumb {
            border-color: rgba(255,255,255,0.5);
        }
    </style>

</head>

<body>
@include('layouts.partials.front.navbar')
@yield('content')
@include('layouts.partials.front.footer')    

<!-- jQuery -->
<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('dist/js/platform/platform.js')}}"></script>
<script src="{{asset('dist/js/jssocials.js')}}"></script>

<script>
 
var token = $('meta[name="csrf-token"]').attr('content');       
$('.login').click(function(){
console.log('click');
$('.profile-menu').toggleClass('mostrar'),
$('.icono-toggle').toggleClass('glyphicon-triangle-top');
});
</script>
<script>
$("#share").jsSocials({
    url: "{{url()->full()}}",
    text: "Google Search Page",
    showCount: true,
    showLabel: true,
    shares: [
        { share: "twitter", via: "artem_tabalin", hashtags: "search,google" },
        "facebook",
        "googleplus",
        "linkedin",
        "pinterest",
        "stumbleupon",
        "whatsapp"
    ]
});

</script>

@yield('front-js')
</body>

</html>
