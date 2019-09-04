import AppFooter from "./components/AppFooter";

require('./vuetify');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Vuetify from 'vuetify'

Vue.use(Vuetify);


/**
 * COMPONENTS
 */
import AsociadoCreate from './components/historicos/AppAsociadoCreate'
Vue.component('app-asociado-create', AsociadoCreate);

/**
 * HISTORICOS
 */

const historicos = new Vue({
    el: '#historicos',
    data: ()=> {
        return {
            alertErrors:false,
            dialog_asociado_create:false,
            errors:[],
            valido: true,
            dialog: true,

            snackbar: false,
            timeout: 9000,
            color: '',

            nombre_asociado: '',

            notario: null,
            agencia: null,
            credito: '',
            cif: '',
            cuenta: '',
            monto_prestamo: '',
            monto_ampliacion: '',
            gasto_cobrado: '',
            contratos: '',
            escrituras: '',
            Registrado: '',
            Desembolso: '',
            numero_de_escritura: '',
            fecha_de_escrituracion: '',
            timbre_notarial: '',
            gasto_papeleria: '',
            consulta_electronica: '',
            honorario_notario:'',
            honorario_registro: '',
            diferencia: '',
            ajuste_liquidacion: '',
            fecha_creacion: '',

            //Estatus
            estatus_1: '',
            estatus_2: '',
            estatus_3: '',
            estatus_4: '',
            estatus_5: '',
            estatus_6: '',
            estatus_7: '',
            estatus_8: '',
            estatus_9: '',
            estatus_10: '',

            cantidad_anticipo: '',

            RulesNumber: [
                v => !!v || 'ingrese el número de crédito',
                v => /^\d{8,11}$/.test(v)||'numero de crédito muy corto'
            ],
            RulesCif: [
                v => !!v || 'ingrese el cif',
                v => /^[1-9]\d{2,6}$/.test(v)||'Min. 3 - Max. 6 dígitos'
            ],
            RulesCuenta: [
                v => !!v || 'ingrese la cuenta',
                v => /^\d{9,10}$/.test(v)||'Min. 9 - Max. 10 dígitos'
            ],
            defaultMontoRules:[
                v => !!v || 'ingrese monto',
                v => /^\d{0,7}\.?\d{1,2}$/.test(v)||'monto inválido',
                v => v.length <=10 || 'monto excedido'
            ],
            defaultTimbreRules:[
                v => !!v || 'ingrese monto',
                v => /^\d{0,4}\.?\d{1,2}$/.test(v)||'monto inválido',
                v => v<300.01 || 'monto inválido'
            ],
            defaultCantidadRules:[
                v => !!v || 'ingrese un dato',
                v => /^\d{0,2}$/.test(v)||'cantidad inválida',
                v => v.length <=2 || 'cantidad excedida'
            ],
            RulesNumberEscritura: [
                v => !!v || 'ingrese el numero de escritura',
                v => /^[1-9]\d{0,4}$/.test(v)||'No. de escritura correcto?'
            ],
            requiredOption:[
                v => !!v || 'este elemento es requerido',
            ]
        };
    },
    created(){

    },
    methods:{
        onChangeCif:function () {
            this.nombre_asociado='';
            if(this.ValidateCif(this.cif)){
                axios.get('/forms/partner/'+this.cif)
                    .then(response => {
                        if(response.data.status === 'ok'){
                            this.nombre_asociado = response.data.nombre;
                            this.color = 'success';
                            this.snackbar = true;
                        }else{
                            this.snackbar = true;
                            this.color = 'error';
                            this.nombre_asociado = 'No registrado';
                            this.cif = '';
                        }
                    })
                    .catch(error => {
                        swal({
                            title: this.OnErrorMessages(error.response),
                            text:'Ref. Asociado - Code: ' + error.response.status,
                            buttonsStyling:false,
                            confirmButtonClass:'v-btn error'
                        })
                    });
            }else{
                swal({
                    title:'cif incorrecto',
                    buttonsStyling:false,
                    confirmButtonClass:'v-btn error'
                })
            }
        },
        ValidateCif:function (cif) {
            let expreg = /^[1-9]\d{2,5}$/;

            if(expreg.test(cif)) return true
            else return false;
        },

        process_dates(date){
            if (!date){
                return;
            }
            let array = date.split("/");
            let fecha = array[2]+"-"+array[1]+"-"+array[0];
            return fecha;
        },
        process(){
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'v-btn info',
                cancelButtonClass: 'v-btn error',
                buttonsStyling: false,

            })

            swalWithBootstrapButtons({
                title: '¿Guardar el registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    axios.post('/forms/store',{
                        notario: this.notario,
                        agencia: this.agencia,
                        credito: this.credito,
                        cif: this.cif,
                        cuenta_ahorro: this.cuenta,
                        monto_prestamo: this.monto_prestamo,
                        monto_ampliacion: this.monto_ampliacion,
                        gasto_cobrado: this.gasto_cobrado,
                        contratos: this.contratos,
                        escrituras: this.escrituras,
                        registrado: this.Registrado,
                        desembolso: this.Desembolso,
                        numero_de_escritura: this.numero_de_escritura,
                        fecha_de_escrituracion: this.process_dates(this.fecha_de_escrituracion),
                        timbre_notarial: this.timbre_notarial,
                        gasto_papeleria: this.gasto_papeleria,
                        consulta_electronica: this.consulta_electronica,
                        honorario_notario: this.honorario_notario,
                        honorario_registro: this.honorario_registro,
                        diferencia: this.diferencia,
                        ajuste_liquidacion: this.ajuste_liquidacion,
                        fecha_creacion: this.process_dates(this.fecha_creacion),
                        //Estatus
                        estatus_1: this.process_dates(this.estatus_1),
                        estatus_2: this.process_dates(this.estatus_2),
                        estatus_3: this.process_dates(this.estatus_3),
                        estatus_4: this.process_dates(this.estatus_4),
                        estatus_5: this.process_dates(this.estatus_5),
                        estatus_6: this.process_dates(this.estatus_6),
                        estatus_7: this.process_dates(this.estatus_7),
                        estatus_8: this.process_dates(this.estatus_8),
                        estatus_9: this.process_dates(this.estatus_9),
                        estatus_10: this.process_dates(this.estatus_10),
                        cantidad_anticipo: this.cantidad_anticipo,
                    })
                        .then(response=>{
                            /*if(response.data.estatus==='fail'){
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
                            }*/
                            console.log(response);

                        })
                        .catch(error=>{
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

                }
            })

        },
        /*Codigos de Errores
            * var @error HTTP*/
        OnErrorMessages(error){
            switch (error.status) {
                case 404:
                    return 'No se ha podido encontrar el recurso solicitado.';
                    break;
                case 403:
                    return 'No tiene acceso para acceder a este recurso.';
                    break;
                case 419:
                    return 'Su sessión ha expirado, recargue la página.';
                    break;
                case 500:
                    return 'Error del servidor.';
                    break;
                default:
                    return error.statusText;
                    break;
            }
        },
        reemplazarCadena(cadena){
            return cadena.toString();
        },
    }
});
