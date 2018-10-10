<!DOCTYPE html>
<html lang="{{App()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ECOSABAR R. L.,">
    <meta name="author" content="Super User">
    <title>403 Forbidden </title>
    <link href="{{asset('icono.png')}}" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <style>
        body {
            background: #f5f5f5; font-family: 'Roboto', sans-serif;}

        .mini {
            font-size: 1em;
            color: #000;
            line-height: 9em;
            text-indent: 2.5em;
            position: absolute;
            left: 50%;
            top: 50%;
        }
        .mega, .bola{
            line-height: 1.65em;
            font-weight: bold;
            font-size: 11em;
            color: black;
            font-family: 'Roboto', sans-serif;
            width: 300px;
            height: 300px;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -150px;
            margin-top: -150px;}
        .primary {
            background-color: #1976d2 !important;
            border-color: #1976d2 !important;
            color:#fff;
        }
        .v-btn {
            align-items: center;
            border-radius: 2px;
            cursor: pointer;
            display: inline-flex;
            height: 36px;
            flex: 0 1 auto;
            font-size: 14px;
            font-weight: 500;
            justify-content: center;
            margin: 6px 8px;
            min-width: 88px;
            outline: 0;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1), color 1ms;
            position: relative;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .v-btn:not(.v-btn--depressed) {
            will-change: box-shadow;
            box-shadow: 0px 3px 1px -2px rgba(0,0,0,0.2), 0px 2px 2px 0px rgba(0,0,0,0.14), 0px 1px 5px 0px rgba(0,0,0,0.12);
        }
        .v-btn {
            padding: 0 16px;
        }
        .v-btn {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<p >
    <a onclick="goBack()" class="primary v-btn"> Regresar</a>
</p>
<p class="mega">403<div class="bola">
</div></p>
<p class="mini">No tiene la autorización para ver este recurso.</p>

<script type="text/javascript">
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>