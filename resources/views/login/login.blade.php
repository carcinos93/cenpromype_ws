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

</style>
<div id="app">
  
        <formulario :id-formulario="1"></formulario>
        <!--<formulario-registro :codigo-empresa="7">
            
        </formulario-registro>-->
</div>
@endsection()