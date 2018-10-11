@extends ('layouts.master')

@section('identificador','creditos')

@section('content')
    <v-navigation-drawer
            v-model="left_menu"
            fixed
            clipped
            app
            id="style-3"
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
        <v-list dense>
            <div>
                <v-list-tile
                        v-for="(acciones) in menuEnvios"
                        :key="acciones.id"
                        :to="{path: acciones.route}"
                >
                    <v-list-tile-title v-text="acciones.title"></v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon v-text="acciones.icon" color="black"></v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </div>
            <div>
                <v-list-tile
                        v-for="(reports) in menuReportes"
                        :key="reports.id"
                        :to="{path: reports.route}"
                >
                    <v-list-tile-title v-text="reports.title"></v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon v-text="reports.icon" color="black"></v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </div>
            <v-divider></v-divider>

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

    <v-toolbar class="navbar_default"  clipped-left app fixed>
        <v-toolbar-side-icon
                @click.stop="left_menu = !left_menu"
                color="white--text"
        >
        </v-toolbar-side-icon>
        <router-link :to="{name:'home'}" class="navbar--title">E<span>XPECO</span></router-link>
        <v-spacer></v-spacer>

        <!--xs displays-->
        <v-tooltip bottom class="hidden-sm-and-up">
            <v-btn slot="activator" icon class="navbar_button white--text"
                   @click.stop="dialog_search=!dialog_search"
            >
                <v-icon>search</v-icon>
            </v-btn>
            <span>Buscar</span>
        </v-tooltip>
        <v-tooltip bottom class="hidden-sm-and-up">
            <v-menu offset-y transition="scale-transition"
                    class="hidden-sm-and-up"
                    slot="activator"
                    origin="center center"
            >
                <v-btn icon slot="activator" class="navbar_button white--text" >
                    <v-icon>account_box</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile
                            v-for="(item, index) in menuPartner"
                            :key="index"
                            @click=""
                            :to="{path: item.route}"
                    >
                        <v-list-tile-title v-text="item.title"></v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
            <span>Asociados</span>
        </v-tooltip>

        <v-tooltip bottom class="hidden-sm-and-up">
            <v-menu offset-y transition="scale-transition"
                    class="hidden-sm-and-up"
                    slot="activator"
                    origin="center center"
            >
                <v-btn icon slot="activator" class="navbar_button white--text" depressed>
                    <v-icon >folder_open</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile
                            v-for="(item, index) in menuCaseFile"
                            :key="index"
                            @click=""
                            :to="{path:item.route}"
                    >
                        <v-list-tile-title v-text="item.title" ></v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
            <span>Créditos</span>
        </v-tooltip>

        <!--sm displays-->
        <v-btn  class="navbar_button white--text hidden-xs-only" depressed
                @click.stop="dialog_search=!dialog_search"
        >
            <v-icon dark left>search</v-icon>Buscar
        </v-btn>
        <v-menu offset-y transition="scale-transition"
                class="hidden-xs-only"
                origin="center center"
        >
            <v-btn slot="activator" class="navbar_button white--text" depressed>
                <v-icon dark left>account_box</v-icon>Asociados
            </v-btn>
            <v-list>
                <v-list-tile
                        v-for="(item, index) in menuPartner"
                        :key="index"
                        @click=""
                        :to="{path: item.route}"
                >
                    <v-list-tile-title v-text="item.title"></v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>

        <v-menu offset-y transition="scale-transition"
                class="hidden-xs-only"
                origin="center center"
        >
            <v-btn slot="activator" class="navbar_button white--text" depressed>
                <v-icon dark left >folder_open</v-icon>Créditos
            </v-btn>
            <v-list>
                <v-list-tile
                        v-for="(item, index) in menuCaseFile"
                        :key="index"
                        @click=""
                        :to="{path:item.route}"
                >
                    <v-list-tile-title v-text="item.title" ></v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
        <v-menu offset-y transition="scale-transition"
                class="hidden-xs-only"
                origin="center center"
        >
            <v-btn slot="activator" class="navbar_button white--text" depressed>
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

    <v-content class="grey lighten-5">
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
    <script src="{{asset('js/app.js?version=1.0.15')}}"></script>
@stop