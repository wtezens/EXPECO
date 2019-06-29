<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta name="author" content="Super User">
    <link href="{{asset('icono.png')}}" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <!-- Latest compiled and minified CSS -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"-->
    <link href="{{asset('css/reportes/reportes.css?version=1.02')}}" rel="stylesheet">
    <title>Reporte | Envio notario</title>
</head>
<body>
        @yield('content')
</body>
</html>