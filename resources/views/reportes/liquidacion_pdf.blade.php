@extends('layouts.reportes')

@section('content')
    <h2></h2>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="table" border="1">
        <thead class="encabezado">
        <tr>
            <th class="encabezado">No.</th>
            <th class="encabezado">Expe-<br>diente</th>
            <th class="encabezado">No. Escri-<br>tura</th>
            <th class="encabezado">Fecha Escri-<br>tura</th>
            <th class="encabezado">Nombre asociado(a)</th>
            <th class="encabezado">Cif</th>
            <th class="encabezado">Cuenta ahorro</th>
            <th class="encabezado">No. crédito</th>
            <th class="encabezado">Monto</th>
            <th class="encabezado">Timbres</th>
            <th class="encabezado">Gasto protocolo</th>
            <th class="encabezado">Consulta Elec.</th>
            <th class="encabezado">Honorarios</th>
            <th class="encabezado">IVA</th>
            <th class="encabezado">Registro</th>
            <th class="encabezado">Total</th>
            <th class="encabezado">Anticipo</th>
            <th class="encabezado">Total a pagar</th>
        </tr>
        </thead>
        <tbody >
        <?php $i=1; ?>
        @foreach($datos_credito as $credito)
            <tr >
                <td >{{ $i }}</td>
                <td >{{ $credito->expediente }}</td>
                <td >{{ $credito->escritura }}</td>
                <td >{{ $credito->fecha_escritura }}</td>
                <td >{{ $credito->nombre }}</td>
                <td >{{ $credito->cif }}</td>
                <td >{{ $credito->cuenta }}</td>
                <td >{{ $credito->credito_id }}</td>
                <td ><span class="pull-left">Q.</span>{{ $credito->monto_credito }}</td>
                <td ><span class="pull-left">Q.</span>{{ $credito->timbre_notarial }}</td>
                <td ><span class="pull-left">Q.</span>{{ $credito->gasto_papeleria }}</td>
                <td ><span class="pull-left">Q.</span>{{ $credito->consulta_electronica }}</td>
                <td ><span class="pull-left">Q.</span>{{ $credito->honorario_notario }}</td>
                <td ><span class="pull-left">Q.</span>{{ number_format((float)$credito->honorario_notario * 0.12,2,'.','') }}</td>
                <td ><span class="pull-left">Q.</span>{{ $credito->honorario_registro }}</td>

                <td ><span class="pull-left">Q.</span>{{ number_format((float)$credito->timbre_notarial + $credito->gasto_papeleria +
                $credito->consulta_electronica + $credito->honorario_notario +
                ($credito->honorario_notario * 0.12) + $credito->honorario_registro,2,'.','')}}</td>

                <td ><span class="pull-left">Q.</span>{{ number_format((float)$credito->cantidad,2,'.','') }}</td>
                <td ><span class="pull-left">Q.</span>{{ number_format((float)$credito->timbre_notarial + $credito->gasto_papeleria +
                $credito->consulta_electronica + $credito->honorario_notario +
                ($credito->honorario_notario * 0.12) + $credito->honorario_registro -
                $credito->cantidad,2,'.','')}}</td>
            </tr>
            <?php $i++ ?>
        @endforeach

        @php
            $total_monto=0; //suma montos
            $total_timbre=0;    //suma timbres notariales
            $total_gasto=0; //suma gastos de protocolo
            $total_consulta=0;  //suma consultas electronicas
            $total_honorario=0; //suma honorarios notario
            $total_iva=0;   //suma iva
            $total_registro=0;  //suma registro general de l propiedad
            $total_anticipo=0;  //suma anticipos
            $total_total=0; //subtotal a pagar
            $total_a_pagar=0;

            foreach ($datos_credito as $credito){
                $total_monto += $credito->monto_credito;
                $total_timbre += $credito->timbre_notarial;
                $total_gasto += $credito->gasto_papeleria;
                $total_consulta += $credito->consulta_electronica;
                $total_honorario += $credito->honorario_notario;
                $total_iva += $credito->honorario_notario*0.12;
                $total_registro += $credito->honorario_registro;

                $total_total += $credito->timbre_notarial + $credito->gasto_papeleria +
                    $credito->consulta_electronica + $credito->honorario_notario +
                    $credito->honorario_notario * 0.12 + $credito->honorario_registro;
                $total_anticipo += $credito->cantidad;
            }
            $total_a_pagar += $total_total - $total_anticipo;
        @endphp

            <tr>
                <td colspan="8">Suma de Totales</td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_monto,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_timbre,2,'.','')}}
                </td>

                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_gasto,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_consulta,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_honorario,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_iva,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_registro,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_total,2,'.','')}}

                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_anticipo,2,'.','')}}
                </td>
                <td><span class="pull-left">Q.</span>
                    {{number_format((float)$total_a_pagar,2,'.','')}}
                </td>
            </tr>
            <tr>
                <td colspan="10"></td>
                <td colspan="2">Correlativo:</td>
                <td>{{$datos_liquidacion->correlativo}}</td>
                <td colspan="3">Agencia</td>
                <td>{{$datos_liquidacion->agency_id}}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    
    <div class="container">
        <a href="{{route('descarga.liquidacion', $datos_liquidacion->correlativo)}}" class="v-btn primary">
            Descargar
        </a>
    </div>

@endsection