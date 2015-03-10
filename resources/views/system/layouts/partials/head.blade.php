<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>@yield('title')</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/fonts-awesome.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/ionicons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/_all-skins.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
  <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script>
   var appUrl = "{{ url() }}";
</script>

</head>
<body class="skin-blue">
<div class="wrapper">
  <!-- header logo: style can be found in header.less -->
@include('system.layouts.partials.header')