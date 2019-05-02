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
    <style>
        *{
            padding: 0;
            margin: 0;
        }

        .shade {
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .front-content {
            text-align: center;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        header {
            /*background-image: url("/img/index1.jpg");*/
            background: url("/img/index5.jpg") no-repeat center center fixed;
            height: 100vh;
            background-size: cover;
            display: flex;
            flex-direction: column;
            color: #F5F5F5;

            /*margin-bottom: 25px;*/
        }

        html, body {
            font-family: 'Nunito Sans', sans-serif;
            color: #333;
            font-size: 16px;
        }

        p {
            line-height: 1.6;
            max-width: 50em;
        }

        button, input {
            font-family: Hind, sans-serif;
            font-size: 1rem;
            outline: none;
        }

        .wrap{
            margin: 0 auto;
            max-width: 1000px;
        }

        .nav {
            position: fixed;
            z-index: 3;
            height: 60px;
            width: 100%;
            transition: 300ms ease;
            /*background: linear-gradient(to right, #018647 0%, #008570 50%, #008685 100%);*/
            background: rgba(255,255,255, 0.3);
            border-bottom: 2px solid #2ecc71;
            /*border-bottom: 2px solid #fdcb01;*/
        }

        .brand {
            float: left;
            line-height: 70px;
            color: white;
            font-weight: 500;
            padding-left: 1rem;
        }
        .brand span {
            font-size: .9em;
            font-weight: 700;
        }
        .brand img {
            vertical-align: middle;
            height: calc(70px - 1rem);
            margin-right: .5rem;
        }
        button.cta {
            padding: 0.75em 1.5em;
            background: white;
            color: black;
            border: none;
            cursor: pointer;
            transition: 200ms ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            border-radius: 2px;
        }
        button.cta:hover {
            color: #e14;
            box-shadow: 0 0.25em 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
    <body>
    <nav class="nav" id="menu">
        <div class="wrap">
            <div class="brand">
                <!--span>Landing Page</span-->
                <img src="/img/ecosaba.png" alt="ECOSABA R. L.,">
            </div>
        </div>
    </nav>
    <header>
        <div class="shade">
            <div class="front-content">
                <h1><strong>Bienvenido a <span style="color:#269850;">EXPECO</span></strong></h1>
                <h4>Seleccione un módulo para ingresar.</h4>
                <br>
                <button class="cta">&rarr; Colaborador</button>
                <button class="cta">&rarr; Notario</button>
            </div>
        </div>
    </header>
    </body>
</html>