<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_title }}</title>

    <link href="{{asset('assets/css/material-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/material-dashboard.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/album.css')}}" rel="stylesheet">
</head>
    <body>

        <x-header />

        <main role="main">
            @yield('content')
        </main>

        <x-footer />

        <script src="{{asset('assets/js/jquery-3.2.1.slim.min.js')}}"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"
        ></script>
        <script>window.jQuery || document.write('<script src="{{asset('js/jquery-3.2.1.slim.min.js')}}"><\/script>')</script>
        <script src="{{asset('assets/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/holder.min.js')}}"></script>

    </body>
</html>
