<template>
    <v-layout row wrap my-1 justify-center>
        <v-flex xs12>
            <v-card>
                <v-card-title primary-title class="center blue-grey lighten-4">
                    <div>
                        <h3 class="headline">Búsqueda de asociado</h3>
                    </div>
                </v-card-title>
                <v-divider class="green"></v-divider>
                <v-card-text>
                    <v-form  ref="form" v-model="valido" lazy-validation>
                        <v-layout row wrap>
                            <v-flex xs12 sm8 md5 lg3 d-flex px-1 py-1>
                                <v-text-field
                                        validate-on-blur
                                        ref="cif"
                                        label="Ingresar cif"
                                        prepend-icon="filter_1"
                                        v-model="cif"
                                        mask="######"
                                        counter="6"
                                        :rules="RulesCif"
                                        required
                                >
                                </v-text-field>
                            </v-flex>
                            <v-flex xs3 pt-2>
                                <v-btn color="primary"
                                        @click="BuscarAsociado"
                                >
                                    <v-icon>search</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-card-text>
                <v-card-text v-if="hayDatos">
                    <v-flex xs12 sm12>
                        <v-card>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-card-title class="teal lighten-2">
                                        <div>
                                            <h3 class="headline mb-0">Asociado</h3>
                                        </div>
                                    </v-card-title>
                                    <v-layout row wrap>
                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue--text" v-text="DatosCliente.id"></p>
                                        </v-flex>
                                        <v-flex xs10 sm5 md3 pa-2>
                                            <p v-text="DatosCliente.nombre"></p>
                                        </v-flex>
                                        <v-flex xs12 sm5 md3 pa-2>
                                            <p>Cuenta No. <span class="blue--text" v-text="DatosCliente.cuenta"></span></p>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                            <v-divider class="pink darken-4"></v-divider>
                            <v-layout>
                                <v-flex xs12>
                                    <v-data-table
                                            primary
                                            :headers="headers"
                                            :items="DatosCliente.list_of_credits"
                                            class="elevation-1 success"
                                            :pagination.sync="pagination"
                                            :rows-per-page-text="RegPorPagina"
                                    >
                                        <template slot="items" slot-scope="props">
                                            <td class="text-xl-left" v-text="props.item.id"></td>
                                            <td class="text-xl-left" v-text="props.item.monto_credito"></td>
                                            <td class="text-xl-left" v-text="props.item.monto_ampliacion"></td>
                                            <td class="text-xl-left" v-text="props.item.agency_id"></td>
                                            <td class="text-xl-left" v-text="formatDate(props.item.created_at)"></td>
                                            <td class="justify-center layout px-0">
                                                <v-icon

                                                        class="mr-2 amber--text text--darken-2"
                                                        @click="showItem(props.item.id)"
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
                        </v-card>
                    </v-flex>
                </v-card-text>
                <v-card-text v-else="hayDatos">
                    No hay datos disponibles.
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppVerAsociado",
        data:()=>{
            return {
                valido:true,
                hayDatos:false,
                cif:'',
                RulesCif: [
                    v => !!v || 'ingrese el cif',
                    v => /^[1-9]\d{2,5}$/.test(v)||'Min. 3 - Max. 6 dígitos'
                ],
                DatosCliente:[],
                pagination: {
                    rowsPerPage: 10
                },
                RegPorPagina:'Registros por página',
                headers: [
                    {text:'Expediente.', value:'id'},
                    {text: 'Monto base', value:'monto_credito'},
                    {text: 'Monto Ampliacion', value:'monto_ampliacion'},
                    {text: 'Agencia', value:'agency_id'},
                    {text: 'Fecha ingreso', value:'created_at'},
                    {text: 'Acciones', sortable:false}
                ]
            }
        },
        mounted(){

        },
        methods:{
            BuscarAsociado:function () {
                if(this.$refs.form.validate()){
                    axios.get('/creditos/listado/asociado/'+this.cif)
                        .then(response=>{
                            if(response.data != ""){
                                this.DatosCliente = response.data;
                                this.hayDatos = true;
                            }else{
                                swal({
                                    type:'warning',
                                    title:'Cif no encontrado.',
                                    text:'No hay datos disponibles.',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                        .catch(error=>{
                            if(error.response.status===422){
                                swal({
                                    title:'Los datos enviados deben ser numéricos',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(error.response.status===403){
                                swal({
                                    type:'error',
                                    title:'403. Forbidden',
                                    text:'No tiene autorización para realizar esta acción.',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(error.response.status===404){
                                swal({
                                    type:'error',
                                    title:'Fallo en la operación.',
                                    text:'No pudimos completar la acción con los datos enviados.',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else{
                                swal({
                                    title:error.toString()
                                })
                            }
                        });
                }else{
                    swal({
                        title:'Ingrese el cif',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
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
                window.open('/creditos/panel#/expediente/'+item);
            }
        }
    }
</script>