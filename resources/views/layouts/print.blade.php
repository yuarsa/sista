<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title','Print Data')</title>
    <link rel="stylesheet" href="{{ asset('css/app/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app/AdminLTE.min.css') }}">
    @stack('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print();">
    <div class="wrapper" style="margin-left: 0; page-break-after: always;">
        @yield('content')
    </div>
    <!-- ./wrapper -->
    <script src="{{ asset('js/app/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/app/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/app/adminlte.min.js') }}"></script>
    @stack('js')
    @stack('script')
</body>
</html>
