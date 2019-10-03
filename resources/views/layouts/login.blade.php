<!DOCTYPE html>
<html>
<head>
    <title>SMART - SISTA</title>
    <link rel="stylesheet" href="{{ asset('css/login/login-app.min.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/login/login-style.css') }}"> 
    <script src="{{ asset('js/app/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app/bootstrap.min.js') }}"></script>
    <style>
        .login__block__header > img {
            width: 70px;
            height: 85px;
            border-radius: 0;
            margin-left: auto;
            margin-right: auto;
            box-shadow: none;
        }
    </style>
</head>
<body data-ma-theme="blue"> 
    <div class="login">     
        <div class="login__block active" id="l-login">
            @include('flash::message')
            <div class="login__block__header" style="background-color: #F7F7F7">
                <img src="{{ asset('img/logo-s.jpeg') }}" style="width: 100%">
                <strong style="font-size: 14px;color: #2196F3">BACK OFFICE SMART SISTA</strong>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>