<template>
    <div>
        <v-layout row wrap my-1 justify-center>
            <v-flex xs12 pb-2>
                <v-card>
                    <v-card-title primary-title class="center blue-grey lighten-4">
                        <div>
                            <h3 class="headline white&#45;&#45;text">Búsqueda de Notario</h3>
                        </div>
                    </v-card-title>
                    <v-divider class="green"></v-divider>

                    <v-card-text>
                        <v-form  ref="form" v-model="valido" lazy-validation>
                            <v-layout row wrap>
                                <v-spacer></v-spacer>
                                <v-flex xs12 sm8 md5 lg4 d-flex px-1 py-1>
                                    <v-text-field
                                        validate-on-blur
                                        autofocus
                                        ref="email"
                                        prepend-icon="email"
                                        v-model="email"
                                        label="correo"
                                        :rules="emailRules"
                                        required
                                        @keypress.enter.prevent="getListado"
                                    >
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs4 pt-2>
                                    <!--                            habilitar este código para mostrar un botón de Buscar-->
                                    <v-btn  color="primary"
                                            @click="getListado"
                                    >
                                        Buscar
                                    </v-btn>
                                    <v-btn outline color="error"
                                           @click="clear"
                                    >
                                        <v-icon dark>cancel</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 sm6 offset-sm3>
                <v-card v-if="hayDatos">
                    <v-toolbar color="diagradient" dark>
                        <v-toolbar-title>Datos del Notario</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-list two-line>
                        <template >
                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>Nombres</v-list-tile-title>
                                    <v-list-tile-sub-title>{{notary.nombre}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-list-tile-action-text></v-list-tile-action-text>
                                    <v-icon v-if=""></v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>E-mail</v-list-tile-title>
                                    <v-list-tile-sub-title>{{notary.email}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-list-tile-action-text></v-list-tile-action-text>
                                    <v-icon v-if=""></v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>Teléfono</v-list-tile-title>
                                    <v-list-tile-sub-title>{{notary.telefono}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-list-tile-action-text></v-list-tile-action-text>
                                    <v-icon v-if=""></v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>Dirección</v-list-tile-title>
                                    <v-list-tile-sub-title>{{notary.direccion}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-list-tile-action-text></v-list-tile-action-text>
                                    <v-icon v-if=""></v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-divider></v-divider>

                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>Estado</v-list-tile-title>
                                    <v-list-tile-sub-title>{{formatEstado(notary.estado)}}</v-list-tile-sub-title>
                                </v-list-tile-content>

                                <v-list-tile-action>
                                    <v-btn v-if="notary.estado == 1" class="white--text green-2 py-1 px-2 user-active add-pointer"
                                    @click.prevent.default="switchStateNotary(notary)">Activo
                                    </v-btn>
                                    <v-btn v-else class="white--text red py-1 px-2 user-active add-pointer"
                                    @click.prevent.default="switchStateNotary(notary)">Inactivo
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-divider></v-divider>

                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>Fecha Creada</v-list-tile-title>
                                    <v-list-tile-sub-title>{{formatDate(notary.created_at)}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-list-tile-action-text></v-list-tile-action-text>
                                    <v-icon v-if=""></v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile ripple>
                                <v-list-tile-content>
                                    <v-list-tile-title>Última fecha</v-list-tile-title>
                                    <v-list-tile-sub-title>{{formatDate(notary.updated_at)}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-list-tile-action-text></v-list-tile-action-text>
                                </v-list-tile-action>
                            </v-list-tile>
                        </template>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>


<script>
    export default {
        name: "AppShowNotario",
        data:()=> {
            return {
                hayDatos: false,
                valido:true,        //validación del formulario
                email: '',
                notary: [],
                emailRules: [
                    v => !!v || 'ingrese correo',
                    v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'el correo no es válido'
                ],
            }
        },
        show(){
            this.getListado();
        },
        methods: {

            ValidateEmail:function (email) {
                let expreg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(expreg.test(email)) return true
                else return false;
            },
            getListado: function () {
                if (this.$refs.form.validate()) {
                    axios.post('/soporte/notario/show', {
                        email: this.email
                    })
                        .then(response => {
                            // console.log(response.data.datos)
                            if (response.data.total > 0) {
                                this.notary = response.data.datos;
                                this.hayDatos = true;
                            } else {
                                swal({
                                    type: 'warning',
                                    title: 'E-mail no encontrado.',
                                    text: 'No hay datos disponibles.',
                                    buttonsStyling: 'false',
                                    confirmButtonClass: 'v-btn primary'
                                })
                            }
                        })
                        .catch(error => {
                            if (error.response.data.errors) {
                                swal({
                                    type: 'error',
                                    title: '419. Unprocesable Entity.',
                                    text: 'No podemos realizar la acción solicitada.',
                                    buttonStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            } else if (error.response.status === 403) {
                                swal({
                                    type: 'error',
                                    title: '403. Forbidden',
                                    text: 'No tiene autorización para realizar esta acción.',
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            } else if (error.response.status === 404) {
                                swal({
                                    type: 'error',
                                    title: '404. Fallo en la operación.',
                                    text: 'No pudimos encontrar la ruta solicitada',
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            } else {
                                swal({
                                    title: error.toString(),
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            }
                        })
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal({
                        title: 'Cancelado',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    })
                }
            },
            formatEstado:function (active) {
                if(active == 0){
                    return'Inactivo';
                }else {
                    return 'Activo';
                }
            },

            switchStateNotary: function () {
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'v-btn info',
                    cancelButtonClass: 'v-btn error',
                    buttonsStyling: false,
                })
                swalWithBootstrapButtons({
                    title:'¿Desea cambiar el estado?',
                    text: 'Usuario: '+this.notary.email,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/soporte/notario/'+this.notary.id+'/estado',{
                            email: this.notary.email
                        }).then(response => {
                            if(response.data.estado === 'ok'){
                                swal({
                                    type: 'success',
                                    title: response.data.descripcion,
                                    showConfirmButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                                this.notary.estado=response.data.current_state

                            }else if (response.data.estado === 'error'){
                                swal({
                                    type: 'error',
                                    title: response.data.descripcion,
                                    showConfirmButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            }
                        }).catch(error => {
                                // console.log(error)
                                if (error.response.data.errors) {
                                    swal({
                                        type: 'error',
                                        title: '419. Unprocessable Entity.',
                                        text: 'No podemos realizar la accion solicitada.',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                } else if (error.response.status === 403) {
                                    swal({
                                        type: 'error',
                                        title: '403. Forbidden',
                                        text: 'No tiene autorización para realizar esta acción.',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                } else if (error.response.status === 404) {
                                    swal({
                                        type: 'error',
                                        title: '404. Fallo en la operación.',
                                        text: 'No pudimos encontrar la ruta solicitada',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                } else {
                                    swal({
                                        title: error.toString(),
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }
                            })
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                      swal({
                          type: 'error',
                          title: 'Cancelado',
                          confirmButtonClass: 'v-btn primary'
                      })
                        // console.log(this.notary.estado)
                    }
                })
            },
            clear: function () {
                this.$refs.form.reset();
                this.name = "";
                this.$emit("clear", true)
            },
            formatDate:function (date) {
                if(date == null || date == undefined){
                    return ' ';
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
            }
        }
    }
</script>
