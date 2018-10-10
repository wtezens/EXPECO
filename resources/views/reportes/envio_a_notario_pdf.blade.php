@extends('layouts.reportes')

@section('content')
    <h3 style="color:white;">REPORTE DE NOTARIO</h3>
    <table class="table table-sm">
        <thead class="encabezado">
            <tr>
                <th class="encabezado" style="width: 95px;">Expediente</th>
                <th class="encabezado" style="width: 90px;">Cif</th>
                <th class="encabezado">Asociado</th>
                <th class="encabezado" style="width: 80px;">Escrituras</th>
                <th class="encabezado" style="width: 80px;">Contratos</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reporte as $expediente)
            <tr>
                <td >{{ $expediente->expediente }}</td>
                <td >{{ $expediente->cif }}</td>
                <td >{{ $expediente->asociado }}</td>
                <td >{{ $expediente->escrituras }}</td>
                <td >{{ $expediente->contratos}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection