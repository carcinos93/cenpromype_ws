@extends('layout.master')
@section('initialScript')
@endsection
@section('content')
<div class="p-grid p-fluid">
    <div class="p-col-12 p-text-center">
        <h4> {{ $respuesta }}  </h4>
        <a href="{{ $url }}"> Regresar a portal </a>
    </div>
</div>
@endsection