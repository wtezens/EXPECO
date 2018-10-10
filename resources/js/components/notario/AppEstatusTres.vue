<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field validate-on-blur
                      ref="no_escritura"
                      v-model="escritura"
                      mask="#####"
                      label="Número de escritura"
                      required
                      :rules="RulesNumber"
                      prepend-icon="filter_1"
        >
        </v-text-field>

        <v-menu
                ref="menu"
                :close-on-content-click="false"
                v-model="menu"
                :nudge-right="40"
                :return-value.sync="fecha"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
        >
            <v-text-field
                    slot="activator"
                    v-model="fecha"
                    label="Fecha de Escritura"
                    prepend-icon="event"
                    readonly
                    :rules="requiredOption"
            ></v-text-field>
            <v-date-picker v-model="fecha" no-title scrollable :max="current_date" locale="es-mx">
                <v-spacer></v-spacer>
                <v-btn flat color="primary" @click="menu = false">Cancelar</v-btn>
                <v-btn flat color="primary" @click="$refs.menu.save(fecha)">Aceptar</v-btn>
            </v-date-picker>
        </v-menu>

        <v-divider class="green"></v-divider>
        <v-btn block color="primary"
               :disabled="!valid"
               @click="agregarEstatus3"
        >
            Guardar
        </v-btn>
    </v-form>
</template>

<script>
    export default {
        name: "AppEstatusTres",
        props:[
            'expediente'
        ],
        data:()=>{
            return{
                valid:true,
                escritura:'',
                fecha:null,
                menu:false,
                RulesNumber: [
                    v => !!v || 'ingrese el numero de escritura',
                    v => /^[1-9]\d{0,4}$/.test(v)||'No. de escritura correcto?'
                ],
                requiredOption:[
                    v => !!v || 'seleccione una fecha',
                ]
            }
        },
        methods:{
            agregarEstatus3:function () {
                if(this.$refs.form.validate()){
                    this.$emit("agregarEstatus3",false);
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,

                    })

                    swalWithBootstrapButtons({
                        title: '¿Agregar nuevo estatus?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/notario/creditos/estatus3/'+this.expediente,{
                                escritura:this.escritura,
                                fecha_escritura:this.fecha
                            })
                                .then(response=>{
                                    if(response.data.estatus==='fail'){
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='ok'){
                                        this.clear();
                                        swal({
                                            type: 'success',
                                            title: 'Datos guardados correctamente.',
                                            showConfirmButton: true,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        });
                                        this.$emit("updated",true);
                                    }else{
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
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
                                            text:'No pudimos completar la acción con los datos enviados.',
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
                            this.$emit("agregarEstatus3",true);
                        }
                    })


                }
            },
            clear () {
                this.$refs.form.reset();
                this.fecha='';
                this.escritura='';
            },
        },
        computed:{
            current_date(){
                let today = new Date();
                let dd = today.getDate();
                let mm = today.getMonth()+1; //January is 0!
                let yyyy = today.getFullYear();

                if(dd<10) {
                    dd = '0'+dd
                }

                if(mm<10) {
                    mm = '0'+mm
                }

                today = yyyy + '-' + mm + '-' + dd;
                return today.toString();
            }
        }
    }
</script>
