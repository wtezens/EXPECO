<template>
    <v-layout>
        <v-flex xs12>
            <v-toolbar flat color="teal">
                <v-toolbar-title class="white--text">Anticipos autorizados</v-toolbar-title>
                <v-divider
                        class="mx-2"
                        inset
                        vertical
                ></v-divider>
            </v-toolbar>
            <v-data-table
                    primary
                    :headers="headers"
                    :items="anticipos"
                    class="elevation-1 success"
                    :pagination.sync="pagination"
                    :rows-per-page-text="RegPorPagina"
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xl-left" v-text="props.item.id"></td>
                    <td class="text-xl-left" v-text="props.item.created_at"></td>
                    <td class="text-xl-left" v-text="props.item.cantidad"></td>
                    <td class="text-xl-left" v-text="props.item.credit_id"></td>
                </template>
                <template slot="pageText" slot-scope="props">
                    {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                </template>
                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        No hay datos a mostrar :(
                    </v-alert>
                </template>
            </v-data-table>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "AppListAnticipos",
        data:()=>{
            return{
                headers: [
                    {text:'Correlativo.', value:'id'},
                    {text: 'Ingresado', value:'created_at'},
                    {text: 'Monto', value:'cantidad'},
                    {text: 'Expediente', value:'credit_id'},
                ],
                pagination: {
                    rowsPerPage: 10
                },
                RegPorPagina:'Registros por página',
                anticipos:[]
            }
        },
        created(){
            this.listAnticipos();
        },
        methods:{
            listAnticipos(){
                axios.get('/contabilidad/anticipos/list')
                    .then(response=>{
                        if(response.data){
                            this.anticipos=response.data;
                        }
                    })
                    .catch(error=>{
                        if(error.response.status===422){
                            swal({
                                title:'Los datos enviados deben ser numéricos',
                                buttonsStyling:false,
                                confirmButtonClass:'v-btn primary'
                            })
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
                                title:error.toString()
                            })
                        }
                    })
            }
        }
    }
</script>
