@extends('layouts.reportes')

@section('content')
    @php
        function nombremes($mes){
            setlocale(LC_TIME, 'spanish');
            $nombre = strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));
            return $nombre;
        }

        /**
        *Compara la fecha actual respecto a la fecha del contrato
        * @param $date string
        **@return string
        */
        function EqualDate($date = null){
            $today = new DateTime("now");

            /**diferencia de días entre la fecha del contrato respecto a la fecha actual*/
            if($today->diff(date_create($date))->d < 1){
                return 'de esta misma fecha';
            }

            $day = date('d');
            $month = nombremes(date('m'));
            $year = date('Y');

            return 'de fecha '.$day.' de '. $month.' de '.$year;
        }
    @endphp
    <h3  style="margin-top: 175px">REPORTE DE NOTARIO</h3>
    <!--p class="text-right">San Juan Sacatepéquez, {{nombremes(date('m'))}} {{date('d')}} de {{date('Y')}}</p-->
    <h4>Señores</h4>
    <h4>ECOSABA R. L.,</h4>
    <h4>Agencia {{$nota->agency->nombre}}</h4>
    <p>Por este medio informo a ustedes que el dia de hoy el(la) Señor(a) <strong>{{$nota->partner->nombre}},</strong>
    firmo la escritura pública número {{$nota->numero_escritura}} {{EqualDate($nota->fecha_escritura)}}, contrato correspondiente a <strong>MUTUO CON GARANTIA HIPOTECARIA,</strong>
        por lo que se formalizó la Solicitud realizada por el(la) asociado(a).
    </p>
    <p>Observaciones:</p>
    @php
    if(isset($_GET['o'])){
        echo $_GET['o'];
    }
    @endphp

@endsection