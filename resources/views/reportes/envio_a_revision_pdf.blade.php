@extends('layouts.reportes')

@section('content')
    <h3  style="margin-top: 80px">REPORTE DE NOTARIO</h3>
    <table class="table">
        <thead class="encabezado">
            <tr>
                <th class="encabezado" style="width: 90px;">Expediente</th>
                <th class="encabezado" style="width: 80px;">Contrato</th>
                <th class="encabezado" style="width: 80px;">Fecha</th>
                <th class="encabezado">Asociado</th>
                <th class="encabezado" style="width: 120px;">Monto</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reporte as $expediente)
            <tr>
                <td >{{ $expediente->expediente }}</td>
                <td >{{ $expediente->escritura }}</td>
                <td >{{ $expediente->fecha }}</td>
                <td >{{ $expediente->asociado }}</td>
                <td >Q. {{ $expediente->monto_credito }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection