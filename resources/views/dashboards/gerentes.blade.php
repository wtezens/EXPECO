@extends('layouts.master')

@section('identificador','gerentes')

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
        <v-divider class="pink darken-2"></v-divider>
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
                    <v-icon v-text="action[1]"></v-icon>
                </v-list-tile-action>
            </v-list-tile>

        </v-list>
    </v-navigation-drawer>

    <v-toolbar class="white" absolute clipped-left app fixed>
        <v-toolbar-side-icon
                @click.stop="left_menu = !left_menu"
                color="black--text"
        >
        </v-toolbar-side-icon>
        <router-link :to="{name:'home'}" class="navbar--title">E<span class="black--text">XPECO</span></router-link>

        <v-spacer></v-spacer>
        <v-menu offset-y transition="scale-transition"
                class="hidden-xs-only"
                origin="center center"
        >
            <v-btn slot="activator" class="white green--text2" depressed>
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
        <v-container fluid>
            <router-view></router-view>
        </v-container>
    </v-content>
@stop

@section('script')
    <script src="{{asset('js/gerentes/gerentes.js?version=1.0.15')}}"></script>
@stop