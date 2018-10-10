<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field validate-on-blur
                      ref="monto_registro"
                      v-model="monto_registro"
                      label="Monto registral"
                      required
                      suffix="Q."
                      :rules="MontoRules"
                      prepend-icon="filter_1"
                      reverse
        >
        </v-text-field>
        <v-text-field validate-on-blur
                      ref="consulta_electronica"
                      v-model="consulta_electronica"
                      label="Consulta Electronica"
                      required
                      suffix="Q."
                      :rules="MontoRules"
                      prepend-icon="filter_1"
                      class="pb-1"
                      reverse
        >
        </v-text-field>
        <v-divider class="green"></v-divider>
        <v-btn block color="primary"
               :disabled="!valid"
               @click="InscripcionExpediente"
        >
            Guardar
        </v-btn>
    </v-form>
</template>

<script>
    export default {
        name: "AppIncripcionExpediente",
        props:[
            'expediente',
            'monto_credito',
            'gastos_cobrados'
        ],
        data:()=>{
            return{
                valid:true,
                monto_registro:'',
                consulta_electronica:'',
                MontoRules:[
                    v => !!v || 'ingrese monto',
                    v => /^\d{0,7}\.?\d{1,2}$/.test(v)||'monto inválido',
                    v => v.length <=10 || 'monto excedido'
                ]
            }
        },
        methods:{
            roundedNumeric(value, decimals){
                return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
            },
            clear(){
                this.$refs.form.reset();
                this.monto_registro='';
                this.consulta_electronica='';
            }
            ,
            InscripcionExpediente:function () {
                if(this.$refs.form.validate()){
                    this.$emit("inscripcion",false);
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,

                    })

                    swalWithBootstrapButtons({
                        title: '¿Agregar incripción de expediente?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/notario/creditos/inscripcion/'+this.expediente,{
                                monto_registro:this.monto_registro,
                                consultas:this.consulta_electronica,
                                diferencia:this.Diferencia
                            })
                                .then(response=>{
                                    if(response.data.estatus==='fail'){
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='ok'){
                                        swal({
                                            type: 'success',
                                            title: 'Datos guardados correctamente.',
                                            showConfirmButton: true,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        });
                                        this.$emit("updated",true);
                                        this.clear();
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
                            this.$emit("inscripcion",true);
                        }
                    })
                }
            },
        },
        computed:{
            TimbreNotarial:function () {
                let porcentaje=0.002;
                let monto = parseFloat(this.monto_credito) * porcentaje;
                let entero = parseInt(monto);
                let decimal = monto - entero;
                if(monto>300) {
                    return 300;
                }else if(entero<=299 & decimal>0){
                    return entero + 1;
                }else{
                    return entero;
                }
            },
            MontoHonorariosNotario: function () {
                //Parseamos la cadena a punto Flotante
                let MontoPrestamo=parseFloat(this.monto_credito);

                if (MontoPrestamo >=2000 && MontoPrestamo <=5000.99){
                    return 125.00;
                }else if(MontoPrestamo >=5001 && MontoPrestamo <=9999.99){
                    return 150.00;
                }else if(MontoPrestamo >=10000 && MontoPrestamo <=20000.99){
                    return 225.00;
                }else if(MontoPrestamo >=20001 && MontoPrestamo <=30000.99){
                    return 250.00;
                }else if(MontoPrestamo >=30001 && MontoPrestamo <=50000.99){
                    return 400.00;
                }else if(MontoPrestamo >=50001 && MontoPrestamo <=100000.99){
                    return 500.00;
                }else if(MontoPrestamo >=100001 && MontoPrestamo <=200000.99){
                    return 600.00;
                }else if(MontoPrestamo >=200001 && MontoPrestamo <=300000.99){
                    return 700.00;
                }else if(MontoPrestamo >=300001 && MontoPrestamo <=400000.99){
                    return 800.00;
                }else if(MontoPrestamo >=400001 && MontoPrestamo <=899999.99){
                    return 1000.00;
                }else if(MontoPrestamo >900000) {
                    return 1000.00;
                }
            },
            MontoIVA:function () {
                /**
                 * SOBRE LOS HONORARIOS
                 */
                let iva= 0.12;
                let monto=this.MontoHonorariosNotario*iva
                return this.roundedNumeric(monto,2);
            },
            GastosProtocolo:function () {
                let protocolo=95.00;
                return protocolo;
            },
            Diferencia:function () {
                let dif = this.gastos_cobrados - this.TimbreNotarial - this.GastosProtocolo -
                this.consulta_electronica - this.MontoHonorariosNotario - this.MontoIVA -
                this.monto_registro;

                return this.roundedNumeric(dif,2);
            }
        }
    }
</script>
