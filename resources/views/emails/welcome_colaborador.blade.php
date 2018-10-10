@component('mail::message')
# Bienvenido al Sistema de Administración de Expedientes "EXPECO"

Lo primero que debe hacer es ir al siguiente link. <br>
@component('mail::button', ['url' => 'http://10.40.131.123:3000/colaborador/login'])
    Iniciar Sesión
@endcomponent

Seguidamente es cambiar su contraseña por primera vez.

Cooperativamente,<br>
ECOSABA R. L.,


@component('mail::panel')
    Este mensaje fue enviado de manera automática, no responda a esta dirección de correo.
@endcomponent
@endcomponent