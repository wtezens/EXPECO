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
    <title>Login |</title>
    <style>html{overflow-y: hidden}</style>
</head>
<body>
<div id="login">
    <v-app id="inspire" class="login">
        <v-content>
            <v-container fluid fill-height pa-0>
                <v-layout row align-center justify-center>
                    <v-flex xs12 sm7 md5 lg4 xl3>
                        <div>
                            <v-snackbar
                                    v-model="alertErrors"
                                    :timeout="4500"
                                    :color="snackbarColor"
                                    :top="y==='top'"
                            >
                                <li class="red--text" v-for="value in errors" v-text="convertToString(value)">
                                </li>
                                <v-btn
                                        color="primary"
                                        flat
                                        @click="alertErrors = false"
                                >
                                    Cerrar
                                </v-btn>
                            </v-snackbar>
                        </div>
                        <v-card class="elevation-8 box-login">
                            <!--v-card-title class="card-login center pt-3 pb-2 "-->
                            <v-card-title class="center pt-3 pb-2 blue-grey lighten-5">
                                <div class="card-header text-center">
                                    <div class="thumbur">
                                        <div class="icon-lock"></div>
                                    </div>
                                    <h3 class="headline titulo black--text">iniciar sesi&oacute;n</h3>
                                </div>
                            </v-card-title>
                            <v-divider class="amber darken-4"></v-divider>
                            <v-card-text>
                                <v-card flat>
                                    <v-form id="form" ref="form" v-model="valido" lazy-validation>
                                        <v-layout row wrap>
                                            <v-flex xs12 pt-2>
                                                <v-text-field
                                                        validate-on-blur
                                                        prepend-icon="account_circle"
                                                        ref="email"
                                                        v-model="email"
                                                        label="Usuario"
                                                        :rules="emailRules"
                                                        required
                                                        autofocus
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            <v-flex xs12 pb-2>
                                                <v-text-field
                                                        validate-on-blur
                                                        prepend-icon="lock"
                                                        ref="password"
                                                        :append-icon="visualizar ? 'visibility_off' : 'visibility'"
                                                        ref="password"
                                                        v-model="password"
                                                        label="Contraseña"
                                                        :rules="passwordRules"
                                                        required
                                                        :type="visualizar ? 'text' : 'password'"
                                                        @click:append="visualizar = !visualizar"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                            @yield('route')
                                        </v-layout>
                                    </v-form>
                                </v-card>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</div>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<script src="{{asset('/js/login/login.js?version=1.0.03')}}"></script>
</body>
</html>