<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ECOSABA R. L.,">
    <meta name="author" content="Super User">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('icono.png')}}" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <link href="{{asset('iconfont/material-icons.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/ecosaba.css')}}">
    <title>ECOSABA</title>
</head>
    <body>
    <nav class="nav" id="menu">
        <div class="wrap">
            <div class="brand">
                <img src="/img/ecosaba.png" alt="ECOSABA R. L.,">
            </div>
        </div>
    </nav>
    <header>
        <div class="shade">
            <div class="front-content">
                <h1><strong>Bienvenido a <span class="title">EXPECO</span></strong></h1>
                <br>
                <h4 class="subheading">Seleccione un módulo para ingresar.</h4>
                <br>
                <a href="/colaborador/login" class="btn-regular"><i class="material-icons">keyboard_arrow_right</i> Colaborador</a>
                <a href="/notario/login" class="btn-regular"><i class="material-icons">keyboard_arrow_right</i> Notario</a>
            </div>
        </div>
    </header>
    </body>
</html>
