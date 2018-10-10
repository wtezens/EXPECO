<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ECOSABAR R. L.,">
    <meta name="author" content="Super User">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('icono.png')}}" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <link href="{{asset('css/vuetify.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/app.css?version=1.0.05')}}" rel="stylesheet">
    <title>{{$PageTitle}} {{($PageTitle !="")? "|":""}}</title>
</head>
<body>
<div id="@yield('identificador')">
    <v-app id="inspire">

        @yield('content')

        <app-footer></app-footer>
    </v-app>
</div>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>
@yield('script')
</body>
</html>