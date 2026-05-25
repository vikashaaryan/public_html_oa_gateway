<!doctype html>
<html lang="en">
    @php
        $settings = setting();
    @endphp
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->title}}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/spectrum.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.bootstrap-touchspin.css')}}">
    <link rel="stylesheet" href="{{asset('style.css')}}">
</head>
<body>
    <div id="preloader">
        <div class="item">
            <i class="loader --8"></i>
        </div>
    </div>