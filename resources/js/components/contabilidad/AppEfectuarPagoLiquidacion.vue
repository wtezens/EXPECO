<template>
    <div>
        <v-form ref="form" v-model="valid" lazy-validation>
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
                        label="seleccione una fecha"
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

            <v-btn block flat class="green--text2"
                   :disabled="!valid"
                   @click="SubmitLiquidar"
            >
                Guardar
                <v-icon dark right>send</v-icon>
            </v-btn>
            <v-divider class="green"></v-divider>
        </v-form>
    </div>
</template>

<script>
    export default {
        name: "AppEfectuarPagoLiquidacion",
        props:[
            'CorrelativoLiquidacion'
        ],
        data:()=>{
            return{
                valid:true,
                fecha:null,
                menu:false,
                requiredOption:[
                    v => !!v || 'seleccione una fecha',
                ]
            }
        },
        methods:{
            SubmitLiquidar(){
                if(this.$refs.form.validate()){
                    this.$emit("agregarPago",false);
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,

                    })

                    swalWithBootstrapButtons({
                        title: '¿Desea pagar la liquidación No.'+this.CorrelativoLiquidacion+'?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Continuar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/contabilidad/pagar/liquidacion/'+this.CorrelativoLiquidacion,{
                                fecha_pago:this.fecha
                            })
                                .then(response=>{
                                    console.log(response.data);
                                    if(response.data.estatus==='fail'){
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='not empty'){
                                        swal({
                                            type:'error',
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
                            this.$emit("agregarPago",true);
                        }
                    })
                }
            },
            clear () {
                this.$refs.form.reset();
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

<style scoped>

</style>