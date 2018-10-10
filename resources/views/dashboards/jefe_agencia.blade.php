@extends('layouts.master')

@section('identificador','jefe_agencia')

@section('content')
    <v-navigation-drawer
            v-model="left_menu"
            fixed
            clipped
            app
    >
        <v-img :aspect-ratio="16/9" src="/img/r3.jpg">
            <v-layout pa-2 column fill-height class="lightbox black--text">
                <v-spacer></v-spacer>
                <v-flex >
                    <div class="subheading"><strong>{{Auth()->user()->nombres}}</strong></div>
                    <div class="subheading"><strong>{{Auth()->user()->email}}</strong></div>
                </v-flex>
            </v-layout>
        </v-img>
        <v-divider class="pink darken-4"></v-divider>
        <!--class="pink darken-2"-->
        <v-list>
            <v-list-tile >
                <v-subheader>Mi usuario</v-subheader>
            </v-list-tile>
            <v-list-tile
                    v-for="(action, i) in actionsUser"
                    :key="i"
                    @click=""
                    :to="{path:action[2]}"
            >
                <v-list-tile-title v-text="action[0]"></v-list-tile-title>
                <v-list-tile-action>
                    <v-icon v-text="action[1]" color="black"></v-icon>
                </v-list-tile-action>
            </v-list-tile>
        </v-list>
    </v-navigation-drawer>

    <v-toolbar color="white"  clipped-left app fixed>
        <!--clase anterior = navbar_default-->
        <v-toolbar-side-icon
                @click.stop="left_menu = !left_menu"
                color="black--text"
        >
            <!--clase anterior = white--text -->
        </v-toolbar-side-icon>
        <router-link :to="{name:'home'}" class="navbar--title">E<span class="black--text">XPECO</span></router-link>
        <!--la etiqueta span no contenia una clase-->
        <v-spacer></v-spacer>
        <v-btn @click.stop="dialog_search=!dialog_search" class="navbar_button green--text2" depressed>
            <!-- clase anterior white--text -->
            <v-icon dark left>search</v-icon>Buscar
        </v-btn>
        <v-menu offset-y transition="scale-transition"
                class="hidden-xs-only"
                origin="center center"
        >
            <v-btn slot="activator" class="navbar_button green--text2" depressed>
                <!-- clase anterior white--text -->
                Mi usuario
                <v-icon dark right>account_circle</v-icon>
            </v-btn>
            <v-list>
                <v-list-tile
                        v-for="(item, index) in actionsUser"
                        :key="index"
                        @click=""
                        :to="{path:item[2]}"
                >
                    <v-list-tile-title v-text="item[0]" ></v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar>

    <v-content class="grey lighten-4">
        <!--clase anterior = grey lighten-5 -->
        <v-container fluid>
            <router-view></router-view>
            <div class="text-xs-center">
                <v-dialog
                        v-model="dialog_search"
                        width="300"
                >
                    <v-card>
                        <v-card-title
                                class="headline black--text text-xs-center"

                        >
                            Buscar expediente
                        </v-card-title>
                        <v-divider class="blue-darken-2"></v-divider>
                        <v-card-text>
                            <v-form ref="expediente" v-model="valid">
                                <v-text-field
                                        v-model="expediente"
                                        label="ingrese el numero"
                                        type="number"
                                        min="0"
                                        required
                                        :rules="expedienteRules"
                                        counter="10"
                                        validate-on-blur
                                >
                                </v-text-field>
                            </v-form>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                    class="green--text2"
                                    flat
                                    @click="buscarExpediente"
                            >
                                Buscar
                                <v-icon right dark>send</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-container>
    </v-content>
@stop

@section('script')
    <script src="{{asset('js/jefeagencia/jefe_agencia.js?version=1.0.13')}}"></script>
@stop