<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "AppLogout",
        props:[
            'redirect'
        ],
        mounted(){
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'v-btn info',
                cancelButtonClass: 'v-btn error',
                buttonsStyling: false,

            })

            swalWithBootstrapButtons({
                title: '¿Desea cerrar la sesión?',
                text: "Debe iniciar sesión de nuevo para ingresar.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Salir',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                allowOutsideClick:false,
                allowEscapeKey:false,
            }).then((result) => {
                if (result.value) {
                    window.location='/colaborador/logout';
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    window.location=this.redirect;
                }
            })
        }
    }
</script>