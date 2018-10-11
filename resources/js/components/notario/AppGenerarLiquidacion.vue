<template>
    <v-layout row wrap my-1 justify-center>
        <v-flex xs12>
            <v-card>
                <v-card-title primary-title class="center diagradient">
                    <div>
                        <h3 class="headline white--text">GENERAR LIQUIDACIÓN</h3>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-form  ref="form" v-model="valido" lazy-validation>
                        <v-layout row wrap>
                            <v-flex xs12 sm8 md5 lg4 d-flex px-1 py-1>
                                <v-select
                                        validate-on-blur
                                        v-bind:items="agencias"
                                        itemText="descripcion"
                                        item-value="numero"
                                        label="Seleccione una agencia:"
                                        v-model="agencia"
                                        :rules="requiredOption"
                                ></v-select>
                            </v-flex>
                            <v-flex xs3 pt-2>
                                <v-btn  color="primary"
                                        @click="agenciaExpedientes"
                                >
                                    Obtener datos
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-card-text>
                <v-card-text v-if="hayDatos">
                    <v-form ref="frm" v-model="valido2" lazy-validation>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-select
                                        :menu-props="offsetY"
                                        validate-on-blur
                                        v-bind:items="envio"
                                        item-text="expediente"
                                        item-value="expediente"
                                        label="Seleccione los expedientes a liquidar"
                                        v-model="ExpedientesAenviar"
                                        multiple
                                        chips
                                >
                                    <template slot="selection" slot-scope="data">
                                        <v-chip
                                                color="light-blue darken-4"
                                                text-color="white"
                                                :selected="data.selected"
                                                :key="JSON.stringify(data.item)"
                                                close
                                                class="chip--select-multi"
                                                @input="data.parent.selectItem(data.item)"
                                        >
                                            <v-avatar>
                                                <v-icon>check_circle</v-icon>
                                            </v-avatar>
                                            {{data.item.expediente}}
                                        </v-chip>
                                    </template>
                                    <template slot="item" slot-scope="data">
                                        <template v-if="typeof data.item !== 'object'">
                                            <v-list-tile-content v-text="data.item"></v-list-tile-content>
                                        </template>
                                        <template v-else>
                                            <v-list-tile-content>
                                                <v-list-tile-title v-html="'Expediente: '+data.item.expediente"></v-list-tile-title>
                                                <v-list-tile-sub-title v-html="'Cif: ' + data.item.cif + '-----' + data.item.asociado"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                    </template>
                                </v-select>
                            </v-flex>
                            <v-flex xs12 sm6 md3>
                                <v-text-field validate-on-blur
                                              ref="no_liquidacion"
                                              v-model="Numero_liquidacion"
                                              mask="######"
                                              label="Número de Liquidación"
                                              required
                                              :rules="RulesNumber"
                                              prepend-icon="filter_1"
                                >
                                </v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs3>
                                <v-btn flat class="green--text2"
                                        @click="GenerarLiquidacion"
                                >
                                    Generar Liquidación
                                    <v-icon dark right>send</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-card-text>
                <v-card-text v-else="hayDatos" class="red--text text--darken-3">
                    No hay datos disponibles.
                </v-card-text>

            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppGenerarLiquidacion",
        data:()=>{
            return {
                valido:true,
                valido2:true,
                hayDatos:false,
                agencias:[],
                offsetY:'offset-y',

                agencia:'',
                agencia_liquidacion:'',
                envio:[],
                ExpedientesAenviar:[],
                Numero_liquidacion:'',
                RulesNumber: [
                    v => !!v || 'ingrese el número de liquidación',
                    v => /^[1-9]\d{0,5}$/.test(v)||'No. de escritura correcto?'
                ],
                requiredOption:[
                    v => !!v || 'seleccione una opción'
                ]
            }
        },
        mounted(){
            axios.get('/notario/getAgencias')
                .then(res => {
                    this.agencias =res.data;
                })
                .catch(error => {
                    swal({
                        title: error.toString()
                    })
                });
        },
        methods:{
            agenciaExpedientes:function () {
                if(this.$refs.form.validate()) {
                    axios.get('/notario/creditos/liquidacion/'+this.agencia)
                        .then(response => {
                            if(response.data.length>0){
                                this.envio =response.data;
                                this.hayDatos= true;
                                this.agencia_liquidacion=this.agencia;
                            }else{
                                this.hayDatos=false;
                            }

                        })
                        .catch(error => {
                            swal({
                                title: error.toString()
                            })
                        });
                }
            },
            GenerarLiquidacion:function () {
                if(this.ExpedientesAenviar.length>0 && this.$refs.frm.validate()){
                    axios.post('/notario/creditos/liquidacion',{
                        datos:this.ExpedientesAenviar,
                        agencia:this.agencia_liquidacion,
                        liquidacion:this.Numero_liquidacion
                    })
                        .then(response=>{
                            if(response.data.estatus==='ok'){
                                this.ExpedientesAenviar=[];
                                this.hayDatos=false;
                                swal({
                                    type: 'success',
                                    title: 'Envio generado correctamente.',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                });
                                window.open('/notario/liquidacion/'+response.data.route);

                            } else if(response.data.estatus==='duplicate key'){
                                swal({
                                    type: 'error',
                                    title: 'Datos duplicados.',
                                    text:'Verifique el número de liquidación!',
                                    showConfirmButton: true,
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            } else if(response.data.estatus==='a foreign key constraint fails'){
                                swal({
                                    type: 'error',
                                    title: 'Violación de Integridad.',
                                    text:'No se puede añadir o actualizar una fila secundaria.',
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
                        .catch(error=>{
                            if(error.response.status===422){
                                swal({
                                    title:'Los datos enviados deben ser numéricos',
                                    buttonsStyling:false,
                                    confirmButtonClass:'v-btn primary'
                                })
                            }
                        })
                }else{
                    swal({
                        type:'warning',
                        title:'Complete los campos',
                        buttonsStyling:false,
                        confirmButtonClass:'v-btn primary'
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>