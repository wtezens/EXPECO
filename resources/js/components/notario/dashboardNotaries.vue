<template>
    <div>
        <v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8>
                <v-card>
                    <v-card-title primary-title
                                  class="diagradient center white--text elevation-4" >
                        <!-- class = card-home"-->
                        <div>
                            <h6 class="headline">SISTEMA DE CONTROL DE EXPEDIENTES</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 sm6 md4 pa-2>
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="blue--text text--darken-3" style="font-size:40px;">assignment</v-icon>
                        </div>
                        <h3 class="title mb-0">Créditos Asignados</h3>
                    </v-card-title>
                    <v-card-text class="display-1 center"
                    >
                        <p class="txt-blue-card" v-text="this.$root.datos.creditos"></p>
                        <div class="pl-5 pr-5">
                            <v-progress-linear
                                    color="teal accent-4"
                                    :value="100"
                                    class="my-0"
                                    height="3"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>

                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 pa-2>
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="green--text" style="font-size:40px;">trending_up</v-icon>
                        </div>
                        <h3 class="title mb-0">Liquidados</h3>
                    </v-card-title>
                    <v-card-text class="display-1 center">
                        <p class="txt-blue-card" v-text="this.$root.datos.liquidados"></p>
                        <div class="pl-5 pr-5">
                            <v-progress-linear
                                    color="teal accent-4"
                                    :value="100"
                                    class="my-0"
                                    height="3"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md4 pa-2>
                <v-card class="elevation-3 bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="red--text text--darken3" style="font-size:40px;">whatshot</v-icon>
                        </div>
                        <h3 class="title mb-0">En tr&aacute;mite</h3>
                    </v-card-title>
                    <v-card-text class="display-1 center">
                        <p class="txt-blue-card" v-text="this.$root.datos.pendientes"></p>
                        <div class="pl-5 pr-5">
                            <v-progress-linear
                                    color="teal accent-4"
                                    :value="100"
                                    class="my-0"
                                    height="3"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>

                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap pt-3>
            <v-flex xs12>
                <v-card class="elevation-3">
                    <v-card-title primary-title>
                        <div class="title blue--text text--darken-4">Acciones</div>
                        <v-divider class="primary"></v-divider>
                    </v-card-title>
                    <v-layout row wrap>
                        <v-flex xs12 sm6 md3>
                            <v-responsive
                                    class="blue--text"
                                    height="50px"
                            >
                                <v-layout fill-height >
                                    <v-flex xs12 flexbox>
                                        <v-btn outline color="black"
                                               @click="modal_buscar=!modal_buscar"
                                        >Buscar Expediente</v-btn>
                                    </v-flex>
                                </v-layout>
                                <!--v-container fill-height fluid>

                                </v-container-->
                            </v-responsive>
                        </v-flex>
                        <v-flex xs12 sm6 md3
                        >
                            <v-responsive
                                    class="blue--text"
                                    height="50px"
                            >
                                <v-layout fill-height>
                                    <v-flex xs12 flexbox>
                                        <v-btn outline color="black"
                                               :to="{name:'expedientes.revision'}"
                                        >
                                            Envio a revisión
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                                <!--v-container fill-height fluid>

                                </v-container-->
                            </v-responsive>
                        </v-flex>
                        <v-flex xs12 sm6 md3
                        >
                            <v-responsive
                                    class="blue--text"
                                    height="50px"
                            >
                                <v-layout fill-height>
                                    <v-flex xs12 flexbox>
                                        <v-btn outline color="black"
                                               :to="{name:'expedientes.liquidacion'}"
                                        >
                                            Nueva Liquidación
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                                <!--v-container fill-height fluid>

                                </v-container-->
                            </v-responsive>
                        </v-flex>
                        <v-flex xs12 sm6 md3
                        >
                            <v-responsive
                                    class="blue--text"
                                    height="50px"
                            >
                                <v-layout fill-height>
                                    <v-flex xs12 flexbox>
                                        <v-btn outline color="black"
                                               :to="{name:'liquidaciones.show'}"
                                        >
                                            Ver Liquidaciones
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                                <!--v-container fill-height fluid>

                                </v-container-->
                            </v-responsive>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap pt-4 v-if="this.$root.expedientes.length>0">
            <v-flex xs12 md10 lg12 xl12>
                <v-toolbar flat class="diagradient-red">
                    <v-toolbar-title class="white--text hidden-xs-only">No liquidados mayores a 2 meses</v-toolbar-title>
                    <v-divider
                            class="mx-2 hidden-xs-only"
                            inset
                            vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                            class="pt-1"
                            v-model="search"
                            append-icon="search"
                            label="buscar..."
                            single-line
                            solo
                    ></v-text-field>
                    <!--v-icon large color="white"
                            @click="reporte">get_app</v-icon-->
                </v-toolbar>
                <v-data-table
                        primary
                        :headers="headers"
                        :items="this.$root.expedientes"
                        class="elevation-1 success"
                        :pagination.sync="pagination"
                        :rows-per-page-text="RegPorPagina"
                        :search="search"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xl-left font-weight-medium" v-text="props.item.expediente"></td>
                        <td class="text-xl-left font-weight-medium" v-text="props.item.monto_credito"></td>
                        <td class="text-xl-left font-weight-medium" v-text="props.item.cif"></td>
                        <td class="text-xl-left font-weight-medium" v-text="props.item.asociado"></td>
                        <td class="text-xl-left font-weight-medium" v-text="formatDate(props.item.created_at)"></td>
                        <td class="justify-center layout px-0">
                            <v-icon

                                    class="mr-2 green--text2"
                                    @click="showItem(props.item.expediente)"
                            >
                                visibility
                            </v-icon>
                        </td>
                    </template>
                    <template slot="pageText" slot-scope="props">
                        {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                    <template slot="no-data">
                        <v-alert :value="true" color="error" icon="warning">
                            No hay datos a mostrar :(
                        </v-alert>
                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>
        <div class="text-xs-center">
            <v-dialog
                    v-model="modal_buscar"
                    width="300"
            >
                <v-card>
                    <v-card-title
                            class="headlineblack--text"

                    >
                        Buscar expediente
                    </v-card-title>
                    <v-divider class="blue-darken-2"></v-divider>
                    <v-card-text>
                        <v-form ref="numero_expediente" v-model="valid">
                            <v-text-field
                                    v-model="numero_expediente"
                                    label="ingrese el numero"
                                    type="number"
                                    min="0"
                                    required
                                    :rules="reglasExpediente"
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
    </div>
</template>

<script>
    export default {
        name: "dashboardNotaries",
        data(){
            return{
                modal_buscar:false,
                valid:false,
                numero_expediente:'',
                reglasExpediente:[
                    v => !!v || 'Ingrese un número',
                    v => v.length <=10 || 'ingrese menos de 10 digitos',
                    v => /^[0-9]+$/.test(v)||'el número debe ser válido'
                ],

                search: '',
                pagination: {
                    rowsPerPage: 10
                },
                RegPorPagina:'Registros por página',
                headers: [
                    {text:'Expediente.', value:'expediente'},
                    {text:'Monto', value:'monto_credito'},
                    {text: 'Cif', value:'cif'},
                    {text: 'Asociado', value:'asociado'},
                    {text: 'Creado', value:'created_at'},
                    {text: 'Acciones', sortable:false}
                ]
            }
        },
        methods: {
            buscarExpediente(){
                if(this.$refs.numero_expediente.validate()){
                    window.location.hash='/expediente/'+this.numero_expediente;
                    this.modal_buscar=false;
                    this.$refs.numero_expediente.reset();
                    this.numero_expediente='';
                }
            },
            formatDate:function (date) {
                if(date == null || date == undefined){
                    return '-';
                }else{
                    let only_date=date.split(' ');
                    let fecha = only_date[0].split('-');

                    let monthNames = [
                        "Ene.", "Feb.", "Mar.",
                        "Abr.", "May.", "Jun.", "Jul.",
                        "Ago.", "Sep.", "Oct.",
                        "Nov.", "Dic."
                    ];

                    let day = fecha[2];
                    let monthIndex = fecha[1]-1;
                    let year = fecha[0];

                    return day + ' ' + monthNames[parseInt(monthIndex)] + ' ' + year;
                }
            },
            showItem(item){
                window.open('/notario/panel#/expediente/'+item);
            },
            reporte(){
                window.open('/notario/reportesinliquidar');
            }
        },
    }
</script>