<style>

    .btn-3 {  background-color: #f3f3f4; color: #135fa7 !important; border: 1px solid #135fa7; }

    .p-grid .pi { font-size: 1.5rem; }
    .position-relative { position: relative; }
    .p-hidden { display: none; }
    #contendor-iframe { position: absolute; width: 100%; height: 100%; top: 0; left: 0 }
    #contenedor-html[src="#"] { display: none }
    .pointer-click .pi { cursor: pointer }
</style>
<input type="hidden" id="sectorId" value=""  />

<div class="elementor-container p-shadow-7">
    <div class="p-grid p-jc-center p-mt-3">
        <div class="p-col-12">
            <div class="p-grid p-jc-start">
                <div class="p-col-8 p-md-6">
                    <div class="btn-dinamico btn-2 p-text-center" style="text-transform: capitalize">
                        {{  $servicio['NOMBRE_SERVICIO']  }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col no-gutter p-col-12">
            <div class="p-grid p-ml-5">
                @foreach( $informes as $informe )
                    <div data-url="{{ route('vista.documento', [ 'iddocumento' => $informe['CODIGO_DOCUMENTO'] ] ) }}" class="p-col-11 p-md-8 btn-dinamico btn-3 documento-visor" >
                        <b> {{ $informe['DESCRIPCION_DOCUMENTO']  }}</b>
                    </div>
                    <div class="p-col-12" style="padding-bottom: 0.2rem"></div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div id="contendor-iframe" class="p-hidden bg-white">
    <div class="p-d-block p-mt-5">
        <div class="p-grid p-jc-end pointer-click">
            <div class="p-col-6 p-md-2">
                <div class="p-grid">
                    <div class="p-col">
                        <i class="pi pi-file-pdf"></i>
                    </div>
                    <div class="p-col">
                        <i class="pi pi-print "></i>
                    </div>
                    <div class="p-col">
                        <i class="pi pi-envelope"></i>
                    </div>
                    <div class="p-col">
                        <i class="pi pi-arrow-circle-left ejecutar-evento" data-evento="regresarInforme" ></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <iframe frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" src="/" id="contenedor-html"></iframe>
</div>
<script>
    var mostrarIframe = false;
    $(function () {
        $(".documento-visor").each(function (e) {
            const elem = $(this);
            elem.on('click', function () {
                const url = elem.attr("data-url");
                cargarDocumento(url);
            });
        });

        $("#contendor-iframe .ejecutar-evento").each(function (e) {
            const elem = $(this);
            elem.on('click', function () {
                const evento =  elem.attr("data-evento");
                if (typeof window[evento] == "function") {
                    window[evento]();
               }
            });
        });
        /**
         * este evento se ejecuta cuando se hace un cambio en la propiedad src del iframe
         * */
        $("#contendor-iframe iframe").on('load',function (e) {
           //ajuste de altura
            if (mostrarIframe) {
                $("#content").addClass('position-relative');
                $("#contendor-iframe").removeClass("p-hidden");
            } else {
                $("#contendor-iframe").addClass("p-hidden");
                $("#content").removeClass('position-relative');
            }

            $("#contendor-iframe").height($(this).contents().height());
            swal.close();
        });

        $("#content").append( $("#contendor-iframe") );
    });
    function regresarInforme() {
        cargando('') //en el evento de load del iframe se realiza el cierre del evento cargando
        mostrarIframe = false;
        //"/~oqmdev/cenpromype_ws/vistas/ok"
        $("#contenedor-html").attr("src", "{{ route('vista.ok') }}"  );
    }
    function cargarDocumento( url ) {
        cargando('')
        mostrarIframe = true;
        ///~oqmdev/cenpromype_ws/vistas/documento/
        $("#contenedor-html").attr("src", url);

    }

</script>




