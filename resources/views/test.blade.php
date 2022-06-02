@extends('layout.master') @section('initialScript')
<script>
        window.url_laravel = "{{ url('') }}/";
        
        window.swal = { close: function () {}  };
        cargando = function () {};
        window.lang = "{{ Request::get('lang', 'es') }}"
</script>
@endsection 
@section('content')

<div id="app" style="max-width: 1140px">
    <informes css-class-lista="p-col-12 p-h-100 informe" css-class-menu="p-col-4" css-class-informes="p-col-8" 
		urlbase="<?php echo $url_laravel; ?>">
                <template v-slot:imagen="slotprops">
                        <div class="p-col-3 p-as-center p-ml-2">
                                <img class="" style="width: 100%;height:auto"
                                        src="<?=get_site_url()?>/wp-content/uploads/imagenes/no-imagen.png" />
                        </div>
                </template>
                <template v-slot:contenido="slotprops">
                        <div class="p-col-8" style="font-size: 1vw">
                                <p class="color-naranja">
                                        informe n°{{ slotprops.informe.CODIGO_DOCUMENTO }}
                                </p>
                                <p class="p-text-white">
                                       {{ slotprops.informe.DESCRIPCION_DOCUMENTO }}
                                </p>

                        </div>
                </template>
        </informes>
</div>
@endsection()