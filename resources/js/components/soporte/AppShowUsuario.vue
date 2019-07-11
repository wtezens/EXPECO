<template>
    <v-layout row wrap my-1 justify-center>
        <v-flex xs12>
            <v-card>
                <v-card-title primary-title class="center diagradient">
                    <div>
                        <h3 class="headline white--text">Búsqueda de colaborador</h3>
                    </div>
                </v-card-title>

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


                <v-card-text v-if="hayDatos">
                    <v-flex xs12 sm12>
                            <v-container grid-list-md>
                                <!--<v-layout row wrap>
                                    <v-flex xs12 sm12>
                                    <v-card-title class="blue-grey lighten-4">
                                        <div>
                                            <h3 class="headline mb-0">Datos del Colaborador</h3>
                                        </div>
                                    </v-card-title>
                                    <v-divider class="green"></v-divider>

                                    <v-layout row wrap v-for="item in users">

                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue&#45;&#45;text2" v-text="item.nombres"></p>
                                        </v-flex>
                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue&#45;&#45;text2" v-text="item.apellidos"></p>
                                        </v-flex>
                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue&#45;&#45;text2" v-text="item.email"></p>
                                        </v-flex>
                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue&#45;&#45;text2" v-text="item.role"></p>
                                        </v-flex>
                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue&#45;&#45;text2" v-text="item.agency"></p>
                                        </v-flex>
                                        <v-flex xs2 sm2 md2 pa-2>
                                            <p class="blue&#45;&#45;text2" v-text="item.estado"></p>
                                        </v-flex>
&lt;!&ndash;                                        <v-flex xs2 sm2 md2 pa-2>&ndash;&gt;
&lt;!&ndash;                                            <p class="blue&#45;&#45;text2" v-text="(item.role_id)->with('role:id,descripcion')"></p>&ndash;&gt;
&lt;!&ndash;                                        </v-flex>&ndash;&gt;
                                    </v-layout>
                                    </v-flex> v-for="item in users"
                                </v-layout>-->
                                <table class="mb-2">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>E-mail</th>
                                        <th>Agencia</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in agency ">
                                        <th v-text="item.nombre"></th>
                                        <th v-text="item.apellidos"></th>
                                        <th v-text="item.email"></th>
                                        <th v-text="item.agency_id+','+item.nombre"></th>
                                        <th v-text="item.role+','+item.descripcion"></th>
                                        <th v-text="item.estado"></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </v-container>
                    </v-flex>
                </v-card-text>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppShowUsuario",
        data:()=> {
            return {
                valido: true,
                hayDatos: false, //formulario a mostrar
                email: '',
                nombres: '',
                agency_id: '',
                agency: [],
                emailRules: [
                    v => !!v || 'ingrese correo',
                    v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'el correo no es válido'
                ],
                props:{
                    users:{
                        type: Array,
                        default: new Array,
                        note: 'contiene el datos'
                    }
            },
            }
        },
        show(){
            this.getListado();
        },

        methods:{
            ValidateEmail:function (email) {
                let expreg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if(expreg.test(email)) return true
                else return false;
            },
            getListado: function(){
              if(this.$refs.form.validate()) {
                  axios.post('/soporte/users/list', {
                      email: this.email
                  })
                      .then(response => {
                          console.log(response.data)
                          if (response.data.total > 0) {
                              this.users = response.data;
                              this.agency = response.data;
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
            showItem(item){
                window.open('/soporte/users#/list/'+item);
            }
        }
    }
</script>
<style scoped>
    table{
        /*background-color:rgba(255,255,255,0.5);*/
        border-collapse:collapse;
        width:100%;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    th,td{
        padding:0;
    }
    thead{
        background-color:#00903E;
        /*border-bottom: solid 2px #003269;*/
        color:white;
        text-align:center;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }

    tbody tr {
        color:#000;
        text-align:center;
    }
    tr{
        color: #fff;
        font-size: 1rem;
    }
</style>
