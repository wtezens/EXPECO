<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-textarea
                validate-on-blur
                :rules="requiredOption"
                ref="rechazo"
                prepend-icon="font_download"
                name="input-7-1"
                label="ingrese la razón del rechazo"
                auto-grow
                v-model="razon_rechazo"
                counter="150"
        ></v-textarea>
        <v-btn block flat class="green--text2"
               :disabled="!valid"
               @click="addRechazo"
        >
            Guardar
            <v-icon dark right>send</v-icon>
        </v-btn>
        <v-divider class="green"></v-divider>
    </v-form>
</template>

<script>
    export default {
        name: "AppAgregarRechazo",
        props:[
            'expediente'
        ],
        data:()=>{
            return{
                valid:true,
                razon_rechazo:'',
                menu:false,
                requiredOption:[
                    v => !!v || 'ingrese una descripcion',
                    v => /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\xDC\xFC\s\d,-]{10,151}$/.test(v)||'min:10 - max:150, no caracteres especiales (!"#$&/()[]}{)'
                ]
            }
        },
        methods:{
            addRechazo:function () {
                if(this.$refs.form.validate()){
                    this.$emit("AddRechazo",false);
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,

                    })

                    swalWithBootstrapButtons({
                        title: '¿Está seguro de agregar este rechazo?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/notario/rechazo/'+this.expediente,{
                                rechazo:this.razon_rechazo,
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
                            this.$emit("AddRechazo",true);
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