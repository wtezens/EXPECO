@extends('login')

@section('route')
    <v-flex xs12>
        <v-btn block
               color="primary"
               @click="submitColaborador"
               :disabled="!valido"
        >Ingresar</v-btn>
    </v-flex>
@endsection