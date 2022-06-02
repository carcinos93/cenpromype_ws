<style>

    .btn-3 {  background-color: #f3f3f4; color: #135fa7 !important; border: 1px solid #135fa7; }

    .p-grid .pi { font-size: 1.5rem; }
    .position-relative { position: relative; }
    .p-hidden { display: none; }
    .contendor-iframe {width: 100%;}
    #contenedor-html[src="#"] { display: none }
    .pointer-click .pi { cursor: pointer }
    .informes .p-card > div:hover {
        background-color: rgba(255, 255, 255, 0.35) !important;
        cursor: pointer;
    }
</style>
<input type="hidden" id="sectorId" value=""  />

<div class="elementor-container informes">
    <div class="p-grid p-jc-center p-mt-3 p-w-100">
        @foreach( $informes as $informe )
           <div class="p-col-4" >
               <div class="p-card documento-visor bg-azul" data-titulo="informe n°{{ $informe['CODIGO_DOCUMENTO'] }}"  style="height:100%; " data-informe="{{ Wordpress::recurso( $informe['RUTA_DOCUMENTO']) }}" data-url="{{ route('vista.documento', [ 'iddocumento' => $informe['CODIGO_DOCUMENTO'] ] ) }}" >
                <div style="background-color: transparent;" class="p-h-100"> 
                <div class="p-card-header p-text-center">
                       <img class="p-mt-4" src="{{ Wordpress::recurso( $informe['IMAGEN'] ) }}"/>
                   </div>
                   <div class="p-card-body">
                       <div class="p-card-title color-naranja">
                              informe n°{{ $informe['CODIGO_DOCUMENTO'] }}
                           </div>
                       <div class="p-card-content p-text-white">

                        {{ $informe['DESCRIPCION_DOCUMENTO'] }}
                       </div>
                       <div class="p-card-footer p-text-white">
                           <span class="p-p-2" style="background-color: #f38a1e">Ver mas</span>
                       </div>
                   </div>
                </div>  
               </div>
            </div>
          
        @endforeach
    </div>
</div>
<input type="hidden" value="" id="informePDF"/>
<div class="p-hidden bg-white contendor-iframe">
    <div class="p-d-block p-mt-5">
        <div class="p-grid p-jc-end pointer-click">
            <div class="p-col-6 p-md-2">
                <div class="p-grid">
                    <div class="p-col">
                        <i class="pi pi-file-pdf ejecutar-evento"  data-evento="verInformePDF"></i>
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
    <iframe frameborder="0" style="overflow:hidden !important;height:100%;width:100%;" onload="cargaDocumento()"  height="100%" width="100%" src="{{ route('vista.ok') }}"></iframe>
</div>
<script>
    var mostrarIframe = false;
    $(function () {
   /** si no existe el elemento contenedor del iframe entonces se agrega y se le añade una clase
        * esto se realiza ya que al cargar de nuevos los productos vuelve a crear el contenedor del iframe
        **/
        if ($("#primary .contendor-iframe.principal").length == 0 ) {
            $(".contendor-iframe").addClass("principal"); //se añade una clase
            $("#primary").append( $(".contendor-iframe.principal") ); //se agrega el contenedor
        }

        $(".documento-visor").each(function (e) {
            const elem = $(this);
            elem.on('click', function () {
                const url = elem.attr("data-url");
                $("#informePDF").val(elem.attr("data-informe"));
                cargarDocumento(url);

                jQuery("#navegacion-ruta").data('breadcrumb').addItem({
                    label: elem.attr('data-titulo'),
                    id: 'documento'
                });

            });
        });

        $(".contendor-iframe.principal .ejecutar-evento").each(function (e) {
            const elem = $(this);
            elem.on('click', function () {
                const evento =  elem.attr("data-evento");
                if (typeof window[evento] == "function") {
                    window[evento]( elem );
               }
            });
        });
        /**
         * este evento se ejecuta cuando se hace un cambio en la propiedad src del iframe
         * */
        
        
        /*$("").on('load',function (e) {
            
            var $this = this;
            var that = $(this);
               
           
           //ajuste de altura
           
        });*/
     
    });
    
    function cargaDocumento(e) {
     
             try {
                      
                        setTimeout(function () {
                        $this = $(".contendor-iframe.principal iframe");
                        if (mostrarIframe) {
                        //$("#content").addClass('position-relative');
                        $(".contendor-iframe.principal").removeClass("p-hidden");
                        $("#main").addClass("p-hidden");
                        $("#listaInformes").addClass("p-hidden");
                    } else {
                        $(".contendor-iframe.principal").addClass("p-hidden");
                        //$("#content").removeClass('position-relative');
                        $("#listaInformes").removeClass("p-hidden");
                        $("#main").removeClass("p-hidden");


                        $("html, body").animate({
                            scrollTop: $("#root_informes").offset().top 
                        });


                    }
                    $this.height($this.contents().height());
                    swal.close();
                }, 1500);
                } catch (e) {
                    console.log(e);
                    swal.close();
                }

    }
    
    function regresarInforme() {
        cargando(''); //en el evento de load del iframe se realiza el cierre del evento cargando
        mostrarIframe = false;
        //"/~oqmdev/cenpromype_ws/vistas/ok"
        $(".contendor-iframe.principal iframe").attr("src", "{{ route('vista.ok') }}"  );
        jQuery("#navegacion-ruta").data('breadcrumb').remove( "#documento" );

        
    }

    function verInformePDF() {
        var url = $("#informePDF").val();
        cargarDocumento( url );
    }
    function cargarDocumento( url ) {
        cargando('');
        mostrarIframe = true;
        $(".contendor-iframe.principal iframe").height("100%");
        if (url.includes("pdf")) {
            $(".contendor-iframe.principal iframe").height("100vh");
        }
        ///~oqmdev/cenpromype_ws/vistas/documento/
        $(".contendor-iframe.principal iframe").attr("src", url);

    }

</script>




