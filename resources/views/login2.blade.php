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
    <link href="{{asset('css/app.css?vernsion=1.0.2')}}" rel="stylesheet">
    <title>ECOSABA - EXPECO</title>
    <!--style>html{overflow-y: hidden}</style-->
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body{
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .wave{
            position: fixed;
            bottom: 0;
            left: 0;
            height: 100%;
            z-index: -1;
        }

        .container{
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap :7rem;
            padding: 0 2rem;
        }

        .img{
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .login-content{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            text-align: center;
        }

        .img img{
            width: 500px;
        }

        form{
            width: 360px;
        }

        .login-content img{
            height: 100px;
        }

        .login-content h2{
            margin: 15px 0;
            color: #333;
            text-transform: uppercase;
            font-size: 2.9rem;
        }

        .login-content .input-div{
            position: relative;
            display: grid;
            grid-template-columns: 7% 93%;
            margin: 25px 0;
            padding: 5px 0;
            border-bottom: 2px solid #d9d9d9;
        }

        .login-content .input-div.one{
            margin-top: 0;
        }

        .i{
            color: #d9d9d9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .i i{
            transition: .3s;
        }

        .input-div > div{
            position: relative;
            height: 45px;
        }

        .input-div > div > h5{
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            transition: .3s;
        }

        .input-div:before, .input-div:after{
            content: '';
            position: absolute;
            bottom: -2px;
            width: 0%;
            height: 2px;
            background-color: #38d39f;
            transition: .4s;
        }

        .input-div:before{
            right: 50%;
        }

        .input-div:after{
            left: 50%;
        }

        .input-div.focus:before, .input-div.focus:after{
            width: 50%;
        }

        .input-div.focus > div > h5{
            top: -5px;
            font-size: 15px;
        }

        .input-div.focus > .i > i{
            color: #38d39f;
        }

        .input-div > div > input{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: none;
            padding: 0.5rem 0.7rem;
            font-size: 1.2rem;
            color: #555;
            font-family: 'poppins', sans-serif;
        }

        .input-div.pass{
            margin-bottom: 4px;
        }

        a{
            display: block;
            text-align: right;
            text-decoration: none;
            color: #999;
            font-size: 0.9rem;
            transition: .3s;
        }

        a:hover{
            color: #38d39f;
        }

        .btn{
            display: block;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            outline: none;
            border: none;
            background-image: linear-gradient(to right, #32be8f, #38d39f, #32be8f);
            background-size: 200%;
            font-size: 1.2rem;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            margin: 1rem 0;
            cursor: pointer;
            transition: .5s;
        }
        .btn:hover{
            background-position: right;
        }


        @media screen and (max-width: 1050px){
            .container{
                grid-gap: 5rem;
            }
        }

        @media screen and (max-width: 1000px){
            form{
                width: 290px;
            }

            .login-content h2{
                font-size: 2.4rem;
                margin: 8px 0;
            }

            .img img{
                width: 400px;
            }
        }

        @media screen and (max-width: 900px){
            .container{
                grid-template-columns: 1fr;
            }

            .img{
                display: none;
            }

            .wave{
                display: none;
            }

            .login-content{
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div id="login">

    <!--img class="wave" src="img/wave.png"-->
    <div class="container">
        <div class="img">
            <img src="img/bg.svg">
        </div>
        <div class="login-content">
            <form action="index.html">
                <img src="/img/svg/profile.svg">
                <h2 class="title">Welcome</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input">
                    </div>
                </div>
                <a href="#">Forgot Password?</a>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <!--script type="text/javascript" src="js/main.js"></script-->



    <!--v-app id="inspire">
        <v-content>
            <v-container
                fluid
                fill-height
            >
                <v-layout
                    align-center
                    justify-center
                >
                    <v-flex
                        xs12
                        sm8
                        md4
                    >
                        <v-card class="elevation-4">
                            <v-toolbar
                                color="primary"
                                dark
                                flat
                            >
                                <v-toolbar-title>Login form</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-card-text>
                                <v-form>
                                    <v-text-field
                                        label="Nombre de usuario"
                                        name="login"
                                        prepend-icon="person"
                                        type="text"
                                    ></v-text-field>

                                    <v-text-field
                                        id="password"
                                        label="Contrase&ntilde;a"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>

                                @yield('route')
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app-->
</div>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<script src="{{asset('/js/login/login.js?version=1.0.03')}}"></script>
</body>
</html>
