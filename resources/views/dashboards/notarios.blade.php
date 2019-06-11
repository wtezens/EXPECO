@extends ('layouts.master')

@section('identificador','notario')

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
                    <div class="subheading"><strong>{{Auth()->user()->nombre}}</strong></div>
                    <div class="subheading"><strong>{{Auth()->user()->email}}</strong></div>
                </v-flex>
            </v-layout>
        </v-img>
        <v-divider class="pink darken-2"></v-divider>
        <v-list dense>
            <div>
                <v-list-tile
                        v-for="(action) in menuEnvios"
                        :key="action.id"
                        :to="{path: action.route}"
                >
                    <v-list-tile-title v-text="action.title"></v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon v-text="action.icon" color="black"></v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </div>
            <div>
                <v-list-tile
                        v-for="(action) in menuLiquidacion"
                        :key="action.id"
                        :to="{path: action.route}"
                >
                    <v-list-tile-title v-text="action.title"></v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon v-text="action.icon" color="black"></v-icon>
                    </v-list-tile-action>
                </v-list-tile></div>

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

    <v-toolbar color="navbar_default" clipped-left app fixed>
        <v-toolbar-side-icon
                @click.stop="left_menu = !left_menu"
                color="white--text"
        >
        </v-toolbar-side-icon>
        <router-link :to="{name:'home'}" class="navbar--title">E<span>XPECO</span></router-link>

        <v-spacer></v-spacer>
        <v-btn  @click.stop="dialog_search=!dialog_search" class="navbar_button white--text" depressed>
            <v-icon dark left>search</v-icon>buscar
        </v-btn>
        <v-btn  @click.stop="dialog_note=!dialog_note" class="navbar_button white--text" depressed>
            <v-icon dark left>note</v-icon>notas
        </v-btn>
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

    <v-content class="grey lighten-3">
        <v-container fluid>
            <router-view></router-view>
            <div class="text-xs-center">
                <v-dialog
                        v-model="dialog_search"
                        width="300"
                >
                    <v-card>
                        <v-card-title
                                class="headline black--text"
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
                                <v-icon dark right>send</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
            <div class="text-xs-center">
                <v-dialog
                        v-model="dialog_note"
                        width="400"
                >
                    <v-card>
                        <v-card-title
                                class="headline black--text"
                        >
                            Nota de desembolso
                        </v-card-title>
                        <v-divider class="amber darken-4 "></v-divider>
                        <v-card-text>
                            <v-form ref="expediente" v-model="valid">
                                <v-text-field
                                        v-model="expediente"
                                        label="ingrese el no. de expediente"
                                        type="number"
                                        min="0"
                                        required
                                        :rules="expedienteRules"
                                        counter="10"
                                        validate-on-blur
                                >
                                </v-text-field>
                                <v-textarea
                                        v-model="observaciones"
                                        label="Observaciones"
                                        solo
                                >
                                </v-textarea>
                            </v-form>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                    class="green-2 white--text"
                                    @click="NotaExpediente"
                            >
                                generar
                                <v-icon dark right>send</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-container>
    </v-content>
@stop

@section('script')
    <script src="{{asset('js/notario/notarios.js?version=1.17')}}"></script>
@stop
