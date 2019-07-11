<template>
    <div class="white elevation-3">
        <v-snackbar
            v-model="snackbar"
            :bottom="'bottom' === 'bottom'"
            :right="'right' === 'right'"
            :timeout="timeout"
            :color="color"
        >
            Usuario actualizado.
            <v-btn
                color="white"
                flat
                @click="snackbar = false"
            >
                Cerrar
            </v-btn>
        </v-snackbar>
        <v-toolbar flat color="white">
            <v-toolbar-title>Usuarios</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field
                class="pt-2 elevation-0 fields"
                v-model="search"
                append-icon="search"
                label="buscar..."
                single-line
                clearable
                solo
            ></v-text-field>
        </v-toolbar>
        <v-divider class="pink darken-3"></v-divider>
        <v-data-table
            :headers="headers"
            :items="users"
            :expand="expand"
            item-key="id"
            :pagination.sync="pagination"
            :rows-per-page-text="RegPorPagina"
            :search="search"
        >
            <template slot="items" slot-scope="props">
                <tr class="user-row">
                    <td v-text="props.item.id"></td>
                    <td @click="props.expanded = !props.expanded" class="text-xs-left user-link" v-text="props.item.email"></td>
                    <td class="text-xs-left" v-text="props.item.surname+', ' + props.item.name"></td>
                    <td class="text-xs-left" v-text="props.item.role.description"></td>
                    <td class="text-xs-left">
                        <span v-if="props.item.active==1" class="white--text green-2 py-1 px-2 user-active add-pointer"
                              @click.prevent.default="switchStateUser(props.item)">Activo</span>
                        <span v-else class="white--text red lighten-2 py-1 px-2 user-active add-pointer"
                              @click.prevent.default="switchStateUser(props.item)">Inactivo</span>
                    </td>
                    <td class="justify-center layout px-0">
                        <v-btn flat icon color="red">
                            <v-icon>delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
            <template slot="expand" slot-scope="props">
                <v-card flat>
                    <v-card-text>
                        <td class="text-xs-right">
                            <span class="font-weight-bold">Creado: </span>
                            <span v-text="getDate(props.item.created_at)"></span>
                        </td>
                        <td class="text-xs-right">
                            <span class="font-weight-bold">Actualizado por última vez: </span>
                            <span v-text="getDate(props.item.updated_at)"></span>
                        </td>
                    </v-card-text>
                </v-card>
            </template>
            <template v-slot:pageText="props">
                {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
        </v-data-table>
    </div>
</template>

<script>
    export default {
        name: "users-table",
        props: {
            users: {
                type: Array,
                default: new Array(),
                description:`El componente se muestra los datos de los usuarios`,
                token:`<AppUsersTable :users="users_data"></AppUsersTable>`,
            }
        },
        data () {
            return {
                expand: false,
                search: '',
                pagination: {
                    rowsPerPage: 25
                },
                RegPorPagina: 'regs. por pág.',
                headers: [
                    {
                        text: 'ID',
                        align: 'left',
                        value: 'id'
                    },
                    { text: 'correo', value: 'email' },
                    { text: 'nombre', value: 'name' },
                    { text: 'rol', value: 'role.description' },
                    { text: 'estado', value: 'active' },
                    { text: 'acciones', sortable:false}
                ],
                editedIndex:-1,

                snackbar: false,
                timeout: 4000,
                color: 'success'

            }
        },
        methods: {
            getDate(date){
                let datetime = date.split(' ');
                return datetime[0];
            },
            switchStateUser (user) {
                this.editedIndex = this.$root.users.indexOf(user);

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'v-btn info',
                    cancelButtonClass: 'v-btn error',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: '¿Desea cambiar el estado?',
                    text: 'Usuario: '+user.email,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/soporte/usuario/'+user.id+'/state',{
                            email: user.email
                        })
                            .then(response => {
                                if(response.data.status==='ok'){
                                    this.$root.users[this.editedIndex].active = response.data.state;
                                    this.editedIndex = -1;
                                    this.snackbar = true;
                                }
                                else {
                                    swal({
                                        type:'error',
                                        title:response.data.description,
                                        buttonsStyling:false,
                                        confirmButtonClass:'v-btn primary'
                                    })
                                }
                            })
                            .catch(error=>{
                                if(error.response.data.errors){
                                    swal({
                                        type:'error',
                                        title:'419. Unprocessable Entity.',
                                        text:'No podemos realizar la accion solicitada.',
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
                                        title:'404. Fallo en la operación.',
                                        text:'No pudimos encontrar la ruta solicitada',
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
            }
        }
    }
</script>

<style scoped>
    .user-row > .user-link {
        font-weight: bold;
    }
    .user-row > .user-link:hover {
        color: #00599b;
        cursor: pointer;
    }

</style>
