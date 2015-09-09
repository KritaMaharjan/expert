<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- Set latest rendering mode for IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Expert Finance Solutions</title>

        <!-- Set viewport for mobile devices to zoom to 100% -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
        <!-- Loading fonts in the header makes it work in IE<9 -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

        <!-- Including bootstrap 2.3.1 -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- Including Font Awesome 3.0 styles -->
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <!-- Including Slider styles -->
        <link rel="stylesheet" href="{{asset('css/slider.css')}}"/>
        <!-- Including main template styles -->
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">

        <!-- Loading jQuery liblary from CDN with a local fallback when CDN not responding. 
             Version 2.0 is available but it is the same as 1.9.1 but without IE8 support -->
        <!-- Load jQuery from CDN -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <!-- Check if "window" is available. If not that means jQuery didn't load from CDN so instead use local version (otherwise skip) -->
        <script>window.jQuery || document.write('<script src="{{asset('js/jquery-1.9.1.min.js')}}"><\/script>')</script>

        <!-- If the browser version of IE is less than 9 load HTML5 & CSS3 polyfills -->
        <!--[if lt IE 9]>
            <link rel="stylesheet" href="{{asset('css/ie.css')}}">
            <script type="text/javascript" src="{{asset('js/html5shiv.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('js/selectivizr.min.js')}}"></script>
        <![endif]-->

   </head>
    <body>