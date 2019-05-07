<template>
    <v-layout row wrap my-4 justify-center>
            <v-flex xs12 sm8 md6  lg5 xl4>
                <v-alert
                        v-model="alertErrors"
                        color="error"
                        icon="warning"
                        dismissible
                        outline
                >
                    <li v-for="value in errors">
                        {{ reemplazarCadena(value)}}
                    </li>
                </v-alert>
                <v-card>
                    <v-card-title primary-title class="center diagradient">
                        <div>
                            <h3 class="headline white--text" v-if="New">Nuevo Registro</h3>
                            <h3 class="headline white--text" v-else>Actualizar Registro</h3>
                        </div>
                    </v-card-title>
                    <v-divider class="green"></v-divider>
                    <v-card-text>
                        <v-form id="form_partner" ref="form" v-model="valido" lazy-validation>
                            <v-text-field
                                    validate-on-blur
                                    autofocus
                                    ref="cif"
                                    label="Cif"
                                    prepend-icon="filter_1"
                                    v-model="cif"
                                    mask="######"
                                    counter="6"
                                    :rules="RulesCif"
                                    required
                            >
                            </v-text-field>
                            <v-text-field
                                    validate-on-blur
                                    ref="nombre"
                                    label="Nombre asociado"
                                    prepend-icon="person"
                                    v-model="nombre"
                                    :rules="RulesName"
                                    required
                            >
                            </v-text-field>
                            <div v-if="sin_cuenta"></div>
                            <v-text-field v-else
                                    validate-on-blur
                                    ref="cuenta"
                                    label="Numero de cuenta"
                                    prepend-icon="filter_1"
                                    v-model="cuenta"
                                    mask="##########"
                                    :rules="RulesAccount"
                                    counter="10"
                                    required
                            >
                            </v-text-field>
                            <v-checkbox
                                    label="No se dispone de la cuenta en este momento."
                                    v-model="sin_cuenta"
                                    color="red darken-4"
                            ></v-checkbox>
                            <v-btn block outline class="green--text2"
                            :disabled="!valido"
                            @click="submit"
                            >
                            guardar
                                <v-icon right dark>send</v-icon>
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-flex>
</v-layout>
</template>

<script>
    export default {
        props:[
            'New'
        ],
        data:()=>{
            return {
                valido:false,
                alertErrors:false,
                errors:[],
                sin_cuenta: false,

                cif:'',
                nombre:'',
                cuenta:'',
                RulesCif: [
                   v => !!v || 'ingrese el cif',
                   v => /^[1-9]\d{2,5}$/.test(v)||'Min. 3 - Max. 6 dígitos'
                ],
                RulesName: [
                    v => !!v || 'ingrese un nombre',
                    v => v.length <=60 || 'nombre muy largo',
                    v => /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\xDC\xFC\s-]{5,60}$/.test(v) || 'nombre inválido'
                ],
                RulesAccount: [
                    v => !!v || 'ingrese la cuenta',
                    v => /^\d{9,10}$/.test(v)||'Min. 9 - Max. 10 dígitos'
                ]
            }
        },
        methods: {
            submit(){
                if(this.$refs.form.validate()){
                     axios.post('/creditos/asociados',{
                        asociado: this.params()
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
                            } else if(response.data.estatus==='duplicate key'){
                                swal({
                                    type: 'error',
                                    title: 'Datos duplicados.',
                                    text:'El registro ya existe!',
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
            reemplazarCadena(cadena){
                return cadena.toString();
            },
            params(){
                let asociado;
                if(this.sin_cuenta){
                    asociado = {
                        cif: this.cif,
                        nombre: this.nombre,
                        sin_cuenta: true //no tiene cuenta
                    }
                }else{
                    asociado = {
                        cif: this.cif,
                        nombre: this.nombre,
                        cuenta: this.cuenta,
                        sin_cuenta:false //si tiene cuenta
                    }
                }

                return asociado;
            },
            clear () {
                this.$refs.form.reset();
                this.cif='';
                this.nombre='';
                this.cuenta='';
            }
        }
    }
</script>