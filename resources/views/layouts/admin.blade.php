<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>@yield('title','Backend - SMART SISTA')</title>
    
    <link rel="stylesheet" href="{{ asset('css/app/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugin/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugin/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugin/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app/skin-green.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom/sia-style.css') }}">

    @stack('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">
        @include('partials.admin._header')
        @include('partials.admin._aside')
        @include('partials.admin._content')
        @include('partials.admin._footer')
    </div>
    <!-- ./wrapper -->

    <script src="{{ asset('js/app/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('js/app/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugin/fastclick.js') }}"></script>
    <script src="{{ asset('js/plugin/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugin/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/app/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/app/sia.js') }}"></script>

    @stack('js')

    <script>
        $("div.alert").not('.alert-important').delay(2000).fadeOut(350);
    </script>
    <script>
        $(function() {
            $('#table-data').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true
            });
        });
    </script>
    @stack('scripts')
</body>
</html>