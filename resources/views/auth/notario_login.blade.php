@extends('login')

@section('route')
    <v-flex>
        <v-btn block
               color="primary"
               @click="submitNotario"
               :disabled="!valido"
        >Ingresar</v-btn>
    </v-flex>
@endsection