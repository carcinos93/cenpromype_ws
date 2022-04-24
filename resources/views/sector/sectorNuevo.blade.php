
<style>
    #listaProductos svg text, #listaProductos svg span { font-family: inherit !important; font-size: 0.85rem; color:black }
    #listaProductos svg { width: 100%; height:100%}
    #listaProductos svg path[id*="linea"] { stroke-width: 4px;}
    #listaProductos svg foreignObject, #listaProductos svg foreignObject span { line-height: 1rem !important }
    #navegacionRutaContenedor { max-width:1140px; margin: 0 auto; }
</style>
<div class="elementor-container" id="navegacionRutaContenedor">
    <div id="navegacion-ruta" class="p-text-uppercase"></div> 
</div>
<div class="elementor-container sector-contenedor" id="app">
    <div class="p-grid p-jc-center">
        <div  class="p-col-12">
            <div id="navegacion-ruta" class="p-text-uppercase"></div> 
        </div>
        <div class="p-col-12 p-text-center" >
            <rotor-imagenes :tiempo="5000" :deshabilitar-botones="true" imagenes="{{ $sector->BANNER }}" 
                urlbase="{{ Wordpress::index() }}">
                <template v-slot:texto="{ data }">
                    <div v-if="data.texto != ''" style="position: absolute;color: rgb(70, 70, 70);width: 100%;font-size: 1.5rem;font-weight: bold;height: 100%;">
                        <div style="height: 100%;text-align: center;" class="p-d-flex">
                            <div style="width: 82%;" class="p-d-flex p-p-4 p-as-center p-m-auto p-text-justify">
                                 <span style="line-height: normal !important" v-html="data.texto"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </rotor-imagenes>
            <!--<img src="{{ Wordpress::recurso( $sector->BANNER )  }}" class="img-fluid"  />-->
        </div>
        <div class="p-col-12 p-m-t-5" id="sector-descripcion">
            <h2 class="elementor-heading-title elementor-size-default p-text-justify" >

                {{ $sector->DESCRIPCION }}
            </h2>
            <!--<div class="p-grid p-jc-end">
                <div class="p-col-12 p-md-9">
                    <div class="p-fluid p-formgrid p-grid p-text-center">
                        <div class="p-col-12 p-col-md p-field">
                            <div class="p-inputgroup border-blue">
                                <input type="text" placeholder="Buscar" class="color-azul p-pb-2 p-pt-2 p-col-md p-col-11" />
                                <span class="p-inputgroup-addon bg-azul p-text-white">
                                     <i class="pi pi-search"></i>
                                </span>
                            </div>

                        </div>
                        <div class="p-col-12 p-col-md p-field">
                            <div class="ng-tns-c49-13 p-dropdown p-component p-dropdown-open p-dropdown-clearable">
                                <div class="p-hidden-accessible ng-tns-c49-13"><input type="text" readonly="" aria-haspopup="listbox" role="listbox"  placeholder="" aria-activedescendant="p-highlighted-option" aria-expanded="true" data-tskb-is-on="vrai"></div>
                                <span class="ng-tns-c49-13 p-dropdown-label p-col-md p-pb-1 p-pt-1 p-col-12 p-inputtext p-placeholder ng-star-inserted color-blue">Selecciona una opción</span>
                                <div role="button" aria-haspopup="listbox" class="p-dropdown-trigger bg-azul" aria-expanded="true"><span class="p-dropdown-trigger-icon ng-tns-c49-13 pi pi-caret-down p-text-white"></span></div>
                            </div>
                        </div>
                        <div class="p-col-12 p-col-md p-field">
                            <div class="btn-dinamico btn-2 p-d-flex p-text-center">
                                <span class="p-w-100" > Recursos gratuitos  </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

        </div>
        <div class="col no-gutter p-col-12">
            <div class="p-col-12">
                <productos svg="{{ Wordpress::uploads('imagenes/listaProductos.svg?v1.2') }}"
                data-source="{{ route('api.vista.productos', ['sector' => $idsector ])}}"
                loading='{{ Wordpress::uploads("js/load.gif") }}'
                idsector="{{ $idsector }}"
                url-base= "{{Wordpress::index()}}"
                ></productos>
            </div>
          
        </div>

    </div>
</div>
<script>

    jQuery(function () {
        jQuery("#primary").prepend( $("#navegacionRutaContenedor") );


         var idSector = "{{ $idsector }}";
	 //var filtros = [{"value":idSector,"col":"CODIGO_PAIS","op":"eq"}];		
        
            jQuery("html, body").delay(3000).animate({
                scrollTop: jQuery("#sector-descripcion").offset().top - 120
            });
        
           /// 
            jQuery("#navegacion-ruta").breadcrumb({
            activeItemClass: 'color-naranja',
            inactiveItemClass: 'color-azul',
            items: [
                { label: "INICIO", url: '{{ Wordpress::url("sectores") }}', cssClass: "color-azul", "id": "bread-inicio" },
                { label: "{{ $sector->SECTOR_ECONOMICO }}", cssClass: "color-azul", "id" : "bread-sector" }
            ]
        });
        
        jQuery(".navegar-producto").each(function (e) {

            const elem = jQuery(this);
            elem.on('click', function () {
                const url = elem.attr("data-url");
                cargarServicios(url);

            });

        });
    });
    function scrollLocal(elem) {
        jQuery("html, body").animate({
            scrollTop: jQuery(elem).offset().top - jQuery("div.elementor[data-elementor-type='header']").height()
        });
    }
    function cargarServicios(url) {
        cargando('');
        /**
         * root2 esta definido en la ls
         * */
         jQuery("#root2").load(url, function () {
            jQuery("html, body").animate({
                scrollTop: jQuery("#root2").offset().top
            });
            swal.close();
        });
    }
</script>