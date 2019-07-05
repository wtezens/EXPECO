@component('mail::message')
# Sistema de Administración de Expedientes

Estimado(a) Licenciado(a): <br>{{$credito->notary->nombre}}


## Aviso de Inscripción Registral

Se ha actualizado un nuevo caso. <br>
El contrato número {{$credito->numero_escritura}} fue actualizado en fecha reciente, por lo que dicho
contrato esta listo para su devolución y proceder a su respectiva inscripción.

- Le recordamos que para cualquier consulta puede comunicarse al número de teléfono **6644-9500**






Cooperativamente,<br>
ECOSABA R. L.,


@component('mail::panel')
> **NOTA CONFIDENCIAL:** Este correo electrónico se envía por un servidor automático, por favor no responda.

> **NOTA CONFIDENCIAL:** La información contenida en este correo electrónico es confidencial y solo puede ser utilizada por la persona a la cual está dirigido. Si no es el destinatario autorizado, cualquier retención, difusión, distribución, copia total o parcial de este mensaje esta prohibida. Si por error recibe este correo, favor reenviarlo y borrarlo inmediatamente.

> **CONFIDENTIAL NOTE:** The information in this E-mail is intended to be confidential and only for use of the individual to whom it is addressed. If you are not the intended recipient, any total o partial retention, dissemination,distribution or copying of this message is strictly prohibited. If you receibe this message in error, please immediately send it back and delete the message.
@endcomponent
@endcomponent