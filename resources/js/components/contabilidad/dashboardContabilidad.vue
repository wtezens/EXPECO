<template>
    <div>
        <v-layout row justify-center mb-4>
            <v-flex xs12 sm10 md9 lg8 xl8 pa-1>
                <v-card>
                    <v-card-title primary-title
                                  class="diagradient center elevation-4" >
                        <div>
                            <h6 class="headline white--text">SISTEMA DE CONTROL DE EXPEDIENTES</h6>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap class="d-flex">
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="purple--text text--darken-4" style="font-size:35px;">payment</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Anticipos</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button green--text2"
                                   :to="{name:'anticipo.new'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo anticipo</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button green--text2"
                                   :to="{name:'anticipo.show'}"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver anticipos</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="blue--text text--darken-1" style="font-size:35px;">attach_money</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Pago Liquidación</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'liquidar.create'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Pagar Liquidacion</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'liquidar.show'}"
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver liquidados</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="red--text text--darken-1" style="font-size:35px;">assessment</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Reporte General</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <!--v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   :to="{name:'liquidar.show'}"
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo anticipo</span>
                        </v-tooltip-->
                        <v-spacer></v-spacer>
                        <v-btn depressed small slot="activator" class="navbar_button green--text2"
                               @click="reporte_general"
                        >
                            <!--v-icon>get_app</v-icon-->
                            Solicitar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm6 md3 pa-1 class="d-flex">
                <v-card class="elevation-3 hover bt-box-card">
                    <v-card-title primary-title>
                        <div>
                            <v-icon class="green--text text--darken-1" style="font-size:35px;">done</v-icon>
                        </div>
                        <h3 class="title center  mb-0">Ajuste por Liquidación</h3>
                    </v-card-title>
                    <v-card-text class="headline center">
                        <p ></p>
                        <div class="pl-1 pr-1">
                            <v-progress-linear
                                    color="blue-grey lighten-4"
                                    :value="100"
                                    class="my-0"
                                    height="2"
                            ></v-progress-linear>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   @click=""
                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                            <span>Nuevo anticipo</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom class="px-3">
                            <v-btn icon slot="activator" class="navbar_button blue--text"
                                   @click=""
                            >
                                <v-icon>visibility</v-icon>
                            </v-btn>
                            <span>Ver anticipos</span>
                        </v-tooltip>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <!--Layout Acciones-->
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
                                               @click="dialog=!dialog"
                                        >Reporte Espec&iacute;fico</v-btn>
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

        <!--Reporte Especifico-->
        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title
                        class="headline grey lighten-2"
                >
                    Seleccione una agencia y un notario
                </v-card-title>
                <v-card-text>
                    <v-form id="reporte" ref="form" v-model="valido" lazy-validation>
                        <v-flex xs12>
                            <v-select
                                    validate-on-blur
                                    v-bind:items="$root.agencias"
                                    item-text="nombre"
                                    item-value="id"
                                    label="Agencia:"
                                    v-model="agencia"
                                    :rules="requiredOption"
                            ></v-select>
                        </v-flex>
                        <v-flex xs12>
                            <v-select
                                    validate-on-blur
                                    v-bind:items="$root.notarios"
                                    item-text="nombre"
                                    item-value="id"
                                    label="Notario:"
                                    v-model="notario"
                                    :rules="requiredOption"
                            ></v-select>
                        </v-flex>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            class="warning"
                            text
                            @click="reporte_especifico"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "dashboardContabilidad",
        data(){
            return{
                valido: true,
                dialog:false,
                requiredOption:[
                    v => !!v || 'Este campo es requerido',
                ],
                notario:'',
                agencia:'',
            }
        },
        created(){

        },
        methods:{
            reporte_general(){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'v-btn info',
                    cancelButtonClass: 'v-btn error',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: '¿Solicitar Reporte General?',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.get('/contabilidad/reporte/general')
                            .then (response=>{
                                if(response.data.estatus==='ok') {
                                    swal({
                                        type: 'success',
                                        title: response.data.descripcion,
                                        text:'Espere un momento mientras se procesa su solicitud',
                                        showConfirmButton: true,
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    });
                                }
                            })
                            .catch(error=>{
                                if(error.response.data.errors){
                                    this.$emit("errors",error.response.data.errors);
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
                                        text:'Woops! No se pudo encontrar la ruta especificada.',
                                        buttonsStyling:false,
                                        confirmButtonClass:'v-btn primary'
                                    })
                                }else{
                                    swal({
                                        title:error.toString(),
                                        buttonsStyling:false,
                                        confirmButtonClass:'v-btn primary'
                                    })
                                }
                            })
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            reporte_especifico(){
                if(this.$refs.form.validate()){
                    this.dialog=false;
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                        title: '¿Solicitar Reporte Especifico?',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/contabilidad/reporte/especifico',{
                                agencia: this.agencia,
                                notario: this.notario
                            })
                                .then (response=>{
                                    if(response.data.estatus==='ok') {
                                        swal({
                                            type: 'success',
                                            title: response.data.descripcion,
                                            text:'Espere un momento mientras se procesa su solicitud',
                                            showConfirmButton: true,
                                            buttonsStyling: false,
                                            confirmButtonClass: 'v-btn primary'
                                        });
                                    }
                                    this.notario='';
                                    this.agencia='';
                                    this.$refs.form.reset();
                                })
                                .catch(error=>{
                                    if(error.response.data.errors){
                                        this.$emit("errors",error.response.data.errors);
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
                                            text:'Woops! No se pudo encontrar la ruta especificada.',
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else{
                                        swal({
                                            title:error.toString(),
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }
                                })
                        } else if (
                            // Read more about handling dismissals
                            result.dismiss === swal.DismissReason.cancel
                        ) {
                            this.notario='';
                            this.agencia='';
                            this.$refs.form.reset();
                        }
                    })
                }
            },
            showItem(item){
                window.open('/colaborador/creditos#/expediente/'+item);
            },
            reporte(){
                window.open('/colaborador/reportesinliquidar');
            }
        }
    }
</script>

<style scoped>
    /*.hover{
        cursor: pointer;
    }*/
</style>