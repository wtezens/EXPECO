<template>
    <v-card>


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
                <v-card-title primary-title class="center grey lighten-2">
                    <div>
                        <h3 class="headline">Nuevo Asociado</h3>
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

    </v-card>
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
                /*RulesAccount: [
                    v => !!v || 'ingrese la cuenta',
                    v => /^\d{9,10}$/.test(v)||'Min. 9 - Max. 10 dígitos'
                ]*/
            }
        },
        methods: {
            submit(){
                if(this.$refs.form.validate()){
                    axios.post('/forms/asociado/store',{
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
                let asociado = {
                    cif: this.cif,
                    nombre: this.nombre,
                }
                return asociado;
            },
            clear () {
                this.$refs.form.reset();
                this.cif='';
                this.nombre='';
            }
        }
    }
</script>