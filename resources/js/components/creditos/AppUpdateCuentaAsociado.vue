<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
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
        <br>
        <v-divider class="green"></v-divider>
        <v-btn block color="primary"
               :disabled="!valid"
               @click="updateCuenta"
        >
            Guardar
        </v-btn>
    </v-form>
</template>

<script>
    export default {
        name: "AppUpdateCuentaAsociado",
        props:[
            'expediente',
        ],
        data:()=>{
            return{
                valid:true,
                cuenta:'',
                RulesAccount: [
                    v => !!v || 'ingrese la cuenta',
                    v => /^\d{9,10}$/.test(v)||'Min. 9 - Max. 10 dígitos'
                ]
            }

        },
        methods:{
            updateCuenta:function () {
                if(this.$refs.form.validate()){
                    this.$emit("updateCuenta",false);
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                        title: '¿Actualizar cuenta?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/creditos/expediente/'+this.expediente+'/cuenta',{
                                cuenta: this.cuenta
                            })
                                .then (response=>{
                                    if(response.data.estatus==='duplicate key'){
                                        swal({
                                            type:'error',
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='incorrect type value'){
                                        swal({
                                            type:'warning',
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='ok'){
                                        this.clear();
                                        swal({
                                            type: 'success',
                                            title: 'Datos actualizados correctamente.',
                                            showConfirmButton: true,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        });
                                        this.$emit("updated",true);
                                    }else if(response.data.estatus==='save_fail'){
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='fail'){
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
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
                                            text:'Es posible que el registro ya contenga un número de cuenta.',
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
                            this.$emit("updateCuenta",true);
                        }
                    })
                }
            },
            clear () {
                this.$refs.form.reset();
                this.cuenta='';
            }
        }
    }
</script>