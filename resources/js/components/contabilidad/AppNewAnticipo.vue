<template>
    <v-layout row wrap my-4 justify-center>
        <v-flex xs12 sm8 md6  lg5 xl4>
            <v-snackbar
                    v-model="alertErrors"
                    :timeout="4500"
                    :color="snackbarColor"
                    :top="y==='top'"
            >
                <li v-for="value in errors" v-text="convertToString(value)">
                </li>
                <v-btn
                        color="white"
                        flat
                        @click="alertErrors = false"
                >
                    Cerrar
                </v-btn>
            </v-snackbar>

            <v-card>
                <v-card-title primary-title class="center blue-grey lighten-4">
                    <div>
                        <h3 class="headline black--text" v-if="New">Ingresar nuevo anticipo</h3>
                        <h3 class="headline white--text" v-else>Actualizar Registro</h3>
                    </div>
                </v-card-title>
                <v-divider class="green"></v-divider>
                <v-card-text>
                    <v-form id="form" ref="form" v-model="valido" lazy-validation>
                        <v-text-field
                                prepend-icon="filter_1"
                                validate-on-blur
                                ref="cif"
                                v-model="correlativo"
                                v-on:change="onChangeCorrelativo"
                                label="correlativo:"
                                mask="########"
                                required
                                :rules="RulesCorrelativo"
                        >
                        </v-text-field>
                        <v-text-field
                                prepend-icon="vpn_key"
                                validate-on-blur
                                ref="clave"
                                v-model="clave"
                                label="Ingrese la clave de validación:"
                                required
                                :rules="RulesKey"
                        >
                        </v-text-field>
                        <v-text-field
                                prepend-icon="filter_1"
                                validate-on-blur
                                ref="expediente"
                                v-model="expediente"
                                v-on:change="onChangeExpediente"
                                label="No. expediente:"
                                mask="##########"
                                required
                                :rules="expedienteRules"
                        >
                        </v-text-field>
                        <v-text-field
                                validate-on-blur
                                ref="saldo_aportacion"
                                label="ingrese el monto"
                                v-model="monto"
                                :rules="defaultMontoRules"
                                suffix="Q."
                                required
                                reverse
                        >
                        </v-text-field>
                        <v-btn block color="primary white--text"
                               :disabled="!valido"
                               @click="submit"
                        >
                            Enviar
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppNewAnticipo",
        props:[
            'New'
        ],
        data:()=>{
            return {
                //errors
                y:'top',
                snackbarColor:'red lighten-1',
                alertErrors:false,
                errors:[],
                valido:false,

                correlativo:'',
                expediente:'',
                clave:'',
                monto:'',
                //RULES
                RulesCorrelativo: [
                    v => !!v || 'ingrese el correlativo',
                    v => /^[1-9]\d{0,6}$/.test(v)||'Min. 1 - Max. 7 dígitos'
                ],
                expedienteRules:[
                    v => !!v || 'ingrese no. de expediente',
                    v => /^\d{0,10}$/.test(v)||'número no válido'
                ],
                RulesKey: [
                    v => !!v || 'ingrese una clave',
                    v => /^\S*$/.test(v)|| 'la clave no puede contener espacios'
                ],
                defaultMontoRules:[
                    v => !!v || 'ingrese monto',
                    v => /^\d{0,7}\.?\d{1,2}$/.test(v)||'monto inválido',
                    v => v.length <=10 || 'monto excedido'
                ],
            }
        },
        methods: {
            submit(){
                if(this.$refs.form.validate()){
                    axios.post('/contabilidad/anticipos/'+this.correlativo,{
                        clave:this.clave,
                        expediente:this.expediente,
                        monto:this.monto
                    })
                        .then(response =>{
                            if(response.data.estatus==='ok'){
                                swal({
                                    type: 'success',
                                    title: 'Datos guardados correctamente.',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                });
                                this.clear();
                            } else if(response.data.estatus==='fail'){
                                swal({
                                    type: 'error',
                                    title: 'La clave no coincide.',
                                    text:'Las credenciales enviadas no son las correctas!',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(response.data.estatus==='duplicate key'){
                                swal({
                                    type: 'error',
                                    title: 'Datos duplicados.',
                                    text:'El crédito ya ha sido ingresado en un anticipo anterior!',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else if(response.data.estatus==='incorrect type value'){
                                swal({
                                    type: 'error',
                                    title: 'Valores incorrectos.',
                                    text:'El tipo de valor esperado es incorrecto',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                        .catch(error =>{
                            if(error.response.data.errors){
                                this.errors = error.response.data.errors;
                                this.alertErrors=true;
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
                                    text:'No pudimos completar la acción con los datos enviados.\n' +
                                        'Verifique que los datos no se hayan utilizado anteriormente.',
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
                        });
                }
            },
            onChangeExpediente:function () {
                if(this.ValidateExpediente(this.expediente)){
                    axios.get('/contabilidad/verificar/expediente/'+this.expediente)
                        .then(response => {
                            if(response.data.status === 'fail'){
                                swal({
                                    title: 'El expediente no ha sido registrado',
                                    type: 'warning',
                                    showCloseButton:true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else{

                            }
                        })
                        .catch(error => {
                            swal({
                                title: error.toString(),
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        });
                }else{
                    swal({
                        title:'expediente incorrecto',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
                }
            },
            onChangeCorrelativo:function () {
                if(this.ValidateCorrelativo(this.correlativo)){
                    axios.get('/contabilidad/verificar/correlativo/'+this.correlativo)
                        .then(response => {
                            if(response.data.status === 'fail'){
                                swal({
                                    title: 'El correlativo no ha sido registrado',
                                    type: 'warning',
                                    showCloseButton:true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }else{

                            }
                        })
                        .catch(error => {
                            swal({
                                title: error.toString(),
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
                        });
                }else{
                    swal({
                        title:'expediente incorrecto',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
                }
            },
            ValidateCorrelativo:function (correlativo) {
                let expreg = /^\d{1,10}$/;

                if(expreg.test(correlativo)) return true
                else return false;
            },
            ValidateExpediente:function (expediente) {
                let expreg = /^\d{1,10}$/;

                if(expreg.test(expediente)) return true
                else return false;
            },
            reemplazarCadena(cadena){
                return cadena.toString();
            },
            clear () {
                this.$refs.form.reset();
                this.expediente='';
                this.correlativo='';
                this.clave='';
                this.monto='';
            }
        }
    }
</script>
