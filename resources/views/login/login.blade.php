@extends('layout.master') @section('initialScript')
<script>
        window.url_laravel = "{{ url('') }}/";
        
        window.swal = { close: function () {}  };
        cargando = function () {};
        window.lang = "{{ Request::get('lang', 'es') }}"
</script>
@endsection 
@section('content')
<style>
.p-field label {  text-transform:lowercase !important; }
.p-field label:first-letter {  text-transform:uppercase !important; }
</style>
<div id="app">
  
        <formulario-registro :codigo-empresa="7">
            
        </formulario-registro>
</div>
@endsection()