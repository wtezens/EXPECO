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
    <style>
        *{
            padding: 0;
            margin: 0;
        }

        .shade {
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
        }

        .front-content {
            /*text-align: center;*/
            padding-left: 10%;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        header {
            background: url("/img/index12.jpg") no-repeat center center fixed;
            height: 100vh;
            background-size: cover;
            display: flex;
            flex-direction: column;
            color: #d9d9d9;
        }

        html, body {
            font-family: 'Nunito Sans', sans-serif;
            color: #333;
            font-size: 16px;
        }
        input, button.cta {
            font-family: 'Nunito Sans', sans-serif
        }

        p {
            line-height: 1.6;
            max-width: 50em;
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
            background: rgba(255,255,255, 0.2);
            border-bottom: 2px solid #1FA050;
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
        a.cta {
            background: none;
            border: 3px solid #aaaebc;
            min-width: 40px;
            transition: 300ms ease;
            -webkit-appearance: none;
            font-size: 1rem;
            text-shadow: none;
            line-height: 1.2;
            display: inline-block;
            padding: 10px 16px;
            margin: 0 10px 0 0;
            position: relative;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            white-space: nowrap;
            text-overflow: ellipsis;
            text-decoration: none;
            text-align: center;
            font-weight: normal !important;
        }
        a.cta:hover {
            /*background: white;
            border-color: white;
            color: white;*/
            border-color: #00c084;
            background: #00c084;
            box-shadow: white;
        }

        .title{
            /*background: -webkit-linear-gradient(left top, #fed136, #2ecc71);
            background: linear-gradient(to bottom right, #fed136, #2ecc71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;*/
            /*background: #23cc71;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;*/
            /*background: #2ecc71;*/
            background: -webkit-linear-gradient(left top,  #2ecc71, #fed136);
            /*background: linear-gradient(to bottom right, #fed136, #2ecc71);*/
            color: black;
            font-size: 2.5rem;
            padding: 0 3px;
            border-radius: 0.5rem;
        }
        .subheading {
            background: -webkit-linear-gradient(left top,  #f4f4f4, white);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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
                <h1><strong>Bienvenido a <span class="title">EXPECO</span></strong></h1>
                <br>
                <h4 class="subheading">Seleccione un módulo para ingresar.</h4>
                <br>
                <a href="/colaborador/login" class="cta"><i class="material-icons">keyboard_arrow_right</i> Colaborador</a>
                <a href="/notario/login" class="cta"><i class="material-icons">keyboard_arrow_right</i> Notario</a>
            </div>
        </div>
    </header>
    </body>
</html>