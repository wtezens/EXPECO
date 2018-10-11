<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field validate-on-blur
                      ref="numero_credito"
                      v-model="credito"
                      mask="###########"
                      label="Número de crédito"
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
                    label="Fecha de desembolso"
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
               @click="agregarDesembolso"
        >
            Guardar
            <v-icon dark right>send</v-icon>
        </v-btn>
        <v-divider class="green"></v-divider>
    </v-form>
</template>

<script>
    export default {
        name: "AppAgregarDesembolso",
        props:[
            'expediente',
            'monto_ampliacion'
        ],
        data:()=>{
            return{
                valid:true,
                fecha:null,
                credito:'',
                menu:false,
                RulesNumber: [
                    v => !!v || 'ingrese el número de crédito',
                    v => /^\d{8,11}$/.test(v)||'numero de crédito muy corto'
                ],
                requiredOption:[
                    v => !!v || 'seleccione una fecha',
                ]
            }
        },
        methods:{
            agregarDesembolso:function () {
                if(this.$refs.form.validate()){
                    this.$emit("agregarDesembolso",false);
                    const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'v-btn info',
                        cancelButtonClass: 'v-btn error',
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                        title: '¿Agregar Desembolso?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            axios.post('/creditos/desembolso/expediente/'+this.expediente,{
                                credito:this.credito,
                                fecha:this.fecha,
                                gastos:this.GastosProtocolo,
                                honorarios:this.MontoHonorariosNotario,
                                timbres:this.TimbreNotarial
                            })
                                .then(response=>{
                                    if(response.data.estatus==='fail'){
                                        swal({
                                            title:response.data.descripcion,
                                            buttonsStyling:false,
                                            confirmButtonClass:'v-btn primary'
                                        })
                                    }else if(response.data.estatus==='incorrect type value'){
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
                                    }else if(response.data.estatus==='save_fail'){
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
                            this.$emit("agregarDesembolso",true);
                        }
                    })
                }
            },
            roundedNumeric(value, decimals){
                return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
            },
            clear () {
                this.$refs.form.reset();
                this.credito='';
            }
        },
        computed:{
            TimbreNotarial:function () {
                let porcentaje=0.002;
                let monto = parseFloat(this.monto_ampliacion) * porcentaje;
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
                let MontoPrestamo=parseFloat(this.monto_ampliacion);

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