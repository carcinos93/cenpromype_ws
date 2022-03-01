<style>
    

</style>
<div class="elementor-container contenedor-dinamico">
    <div class="p-grid p-w-100 p-m-0 p-jc-center">
        <div class="no-gutter p-col-10 p-shadow-7 bg-white">
            <div class="p-grid p-ml-5 p-mr-5">
                @foreach( $sectores as $sector )
                    <div class="p-col-md p-col-12 p-text-center">
                            <div class="p-m-auto">
                                <div class="elementor-animation-bounce-in elemento-contenedor elementor-icon-wrapper p-text-center p-mt-3 p-mb-3 p-mr-1 p-ml-1">
                                    <a  class="navegar-elemento" href="{{ Wordpress::url("productos", [ 'sector' => $sector['CODIGO_SECTOR'] ]) }}" data-url="{{ route('vista.sector', ['sector' => $sector['CODIGO_SECTOR']]) }}">
                                        <img  src="{{ Wordpress::recurso( $sector['LOGO'] )  }}?v3.1"  class="p-col-4 p-md-9" style="height: auto"  />
                                    </a>
                                    <div class="p-d-block">
                                        <div style="font-size: 1.4rem;line-height: 1.5rem;display: inline-table">
                                            <div style="display: table-caption">
                                                <span class="p-text-bold">  {{ $sector['SECTOR_ECONOMICO'] }}  </span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
<div class="elementor-container p-mt-4">
    <div class="p-grid p-jc-center">
        <div class="p-col-12 p-md-10">
            <div id="root2"></div>
        </div>
    </div>

</div>

<script>

    jQuery(function () {
        /*$(".navegar-elemento").each(function (e) {

            const elem = $(this);
            elem.on('click', function () {
                const url = elem.attr("data-url");
                cargarProductos(url);
            });

        });*/
    });
    
    function cargarProductos(url) {
        cargando('');
        jQuery("#root2").load(url ,function(){
            swal.close();
        });
    }
</script>



