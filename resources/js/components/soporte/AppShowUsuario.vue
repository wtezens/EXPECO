<template>
   <div>
       <v-layout row wrap my-1 justify-center>
           <v-flex xs12>
               <v-card>
                   <v-card-title primary-title class="center blue-grey lighten-4">
                       <div>
                           <h3 class="headline white&#45;&#45;text">Búsqueda de colaborador</h3>
                       </div>
                   </v-card-title>
                   <v-divider class="green"></v-divider>
                   <v-card-text>
                       <v-form  ref="form" v-model="valido" lazy-validation>
                           <v-layout row wrap>
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
                               <v-flex xs3 pt-2>
                                   <v-btn flat color="primary"
                                          @click="getListado"
                                   >
                                       <v-icon>search</v-icon>
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
                       <v-toolbar-title>Datos del usuario</v-toolbar-title>
                       <v-spacer></v-spacer>
                   </v-toolbar>
                   <v-list two-line>
                       <template >
                           <v-list-tile ripple>
                               <v-list-tile-content>
                                   <v-list-tile-title>Nombres y Apellidos</v-list-tile-title>
                                   <v-list-tile-sub-title>{{user.nombres}} {{user.apellidos}}</v-list-tile-sub-title>
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
                                   <v-list-tile-sub-title>{{user.email}}</v-list-tile-sub-title>
                               </v-list-tile-content>
                               <v-list-tile-action>
                                   <v-list-tile-action-text></v-list-tile-action-text>
                                   <v-icon v-if=""></v-icon>
                               </v-list-tile-action>
                           </v-list-tile>
                           <v-divider></v-divider>
                           <v-list-tile ripple>
                               <v-list-tile-content>
                                   <v-list-tile-title>Agencia</v-list-tile-title>
                                   <v-list-tile-sub-title>{{user.agency.nombre}}</v-list-tile-sub-title>
                               </v-list-tile-content>
                               <v-list-tile-action>
                                   <v-list-tile-action-text></v-list-tile-action-text>
                                   <v-icon v-if=""></v-icon>
                               </v-list-tile-action>
                           </v-list-tile>
                           <v-divider></v-divider>
                           <v-list-tile ripple>
                               <v-list-tile-content>
                                   <v-list-tile-title>Departamento</v-list-tile-title>
                                   <v-list-tile-sub-title>{{user.role.descripcion}}</v-list-tile-sub-title>
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
                                   <v-list-tile-sub-title>{{formatEstado(user.estado)}}</v-list-tile-sub-title>
                               </v-list-tile-content>
                               <v-list-tile-action>
                                   <v-btn v-if="user.estado==1" class="white--text green-2 py-1 px-2 user-active add-pointer"
                                          @click.prevent.default="switchStateUser(user)">Activo</v-btn>
                                   <v-btn v-else class="white--text red lighten-1 py-1 px-2 user-active add-pointer"
                                          @click.prevent.default="switchStateUser(user)">Inactivo</v-btn>
                               </v-list-tile-action>
                           </v-list-tile>
                           <v-divider></v-divider>
                           <v-list-tile ripple>
                               <v-list-tile-content>
                                   <v-list-tile-title>Fecha Creada</v-list-tile-title>
                                   <v-list-tile-sub-title>{{formatDate(user.created_at)}}</v-list-tile-sub-title>
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
                                   <v-list-tile-sub-title>{{formatDate(user.updated_at)}}</v-list-tile-sub-title>
                               </v-list-tile-content>
                               <v-list-tile-action>
                                   <v-list-tile-action-text></v-list-tile-action-text>
                                   <v-icon v-if=""></v-icon>
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
        name: "AppShowUsuario",
        data:()=> {
            return {
                valido: true,       //
                hayDatos: false,    //formulario a mostrar
                email: '',          //
                user: [],           //Array de datos de usuario
                emailRules: [       //Reglas del correo
                    v => !!v || 'ingrese correo',
                    v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'el correo no es válido'
                ],
            }
        },
        show(){
            this.getListado();
        },

        methods:{
            /* -- Regla de validacion del Email -- */
            ValidateEmail:function (email) {
                let expreg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(expreg.test(email)) return true
                else return false;
            },
            /* -- Metodo para obtener los datos del usuario y mostrarlo en la vista -- */
            getListado: function(){
                if(this.$refs.form.validate()) {
                    axios.post('/soporte/user/show', {
                        email:this.email
                    })
                        .then(response => {
                            console.log(response.data)
                            if (response.data.total > 0) {
                                this.user = response.data.datos;
                                this.hayDatos = true;

                            } else {
                                swal({
                                    type: 'warning',
                                    title: 'E-mail no encontrado.',
                                    text: 'No hay datos disponibles.',
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                swal({
                                    title: 'Los datos enviados no deben ser númericos',
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            } else if (error.response.status === 404) {
                                swal({
                                    type: 'error',
                                    title: 'Fallo en la operación.',
                                    text: 'No pudimos completar la acción con los datos enviados.',
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            } else {
                                swal({
                                    title: error.toString()
                                })
                            }
                        });
                }else {
                    swal({
                        title: 'Ingrese el email correctamente',
                        buttonsStyling: false,
                        confirmButtonClass: 'v-btn primary'
                    })
                }
            },
            /*showItem(item){
                window.open('/soporte/user/list/'+item);
            },*/
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
            },
            /* --- Formateamos el estado --- */
            formatEstado:function(estado){
                if(estado == 0){
                    return 'Inactivo';
                }else{
                    return 'Activo';
                }
            },
            /* --- Funcion para cambiar el estado del Usuario --- */
            switchStateUser: function () {
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'v-btn info',
                    cancelButtonClass: 'v-btn error',
                    buttonsStyling: false,
                })
                swalWithBootstrapButtons({
                    title: '¿Desea cambiar el estado?',
                    text: 'Usuario: '+this.user.email,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value){
                        /* --- Ruta que se encargara de realizar el cambio --- */
                        axios.post('/soporte/user/'+this.user.id+'/estado',{
                            email: this.user.email,
                        }).then(response =>{
                            if(response.data.estado==='ok'){
                                swal({
                                    type: 'success',
                                    title: response.data.descripcion,
                                    showConfirmButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                                this.user.estado = response.data.current_state
                                // console.log(response.data.current_state)
                            }else if (response.data.estado==='error') {
                                swal({
                                    type: 'error',
                                    title: response.data.descripcion,
                                    showConfirmButton: true,
                                    buttonsStyling: false,
                                    confirmButtonClass: 'v-btn primary'
                                })
                            }
                        })
                            /* --- Posibles errores --- */
                            .catch(error=> {
                                if(error.response.data.errors){
                                    swal({
                                        type:'error',
                                        title: '419. Unprocesable Entity.',
                                        text:'No podemos realizar la acción solicitada.',
                                        buttonStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }else if (error.response.status === 403){
                                    swal({
                                        type: 'error',
                                        title: '403. Forbidden',
                                        text: 'No tiene autorización para realizar esta acción.',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }else if (error.response.status === 404) {
                                    swal({
                                        type: 'error',
                                        title: '404. Fallo en la operación.',
                                        text: 'No pudimos encontrar la ruta solicitada',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }else {
                                    swal({
                                        title: error.toString(),
                                        buttonsStyling: false,
                                        confirmButtonClass: 'v-btn primary'
                                    })
                                }
                            })
                    }else if (result.dismiss === swal.DismissReason.cancel) {
                        swal({
                            title: 'Cancelado',
                            type:  'error',
                            confirmButtonText: 'Aceptar'
                        })
                        // console.log(this.user.estado)
                    }
                })
            }
        }
    }
</script>
