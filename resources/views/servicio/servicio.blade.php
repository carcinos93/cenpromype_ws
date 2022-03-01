
<style>
    .contenedor-logo svg { width: 100%; height: 100% }
    /*.contenedor-logo svg .RECUADRO { fill: #ffffff; stroke: rgb(51, 85, 154);
    }*/

    .contenedor-logo.activo { background-color: #135fa7; }
    .contenedor-logo svg text, .contenedor-logo svg tspan { font-size: 25px !important; }
    .contenedor-logo.activo svg text  { fill: white !important; stroke: white !important;  }
    .contenedor-logo.activo svg text tspan  { fill: white !important; stroke: white !important;  }
    
    .navegar-servicio { padding-top: 4rem }
</style>
<input type="hidden" id="urlVista" value="{{ $urlVista }}"  />
<div class="p-d-flex">
    <div class="p-grid p-jc-center">
        <!--<div class="p-col-12 p-m-b-4 p-text-center" >
            <div  id="regresar-productos" class="btn-dinamico btn-2 p-m-auto" style="width: 250px"> REGRESAR A RUBROS</div>

        </div>-->
        <!--<div class="p-col-12">
            <img src="{{ $url }}/{{  $producto['LOGO']  }}?v2.0" style="width:100%;height: auto"  />
        </div>-->
        <div class="p-col-12">
            <h2> ¿QUÉ DESEAS BUSCAR? </h2>
        </div>
        <div class="col no-gutter p-col-12 p-shadow-7 bg-white">
            <div class="p-grid">
                @foreach( $servicios as $servicio )
                    <div class="p-col-12 p-md-4 p-pt-0">
                        <div class="p-text-center">
                            <!-- elementor-animation-bounce-i -->
                            <a data-logo="{{ Wordpress::recurso($servicio['LOGO']) }}" data-idservicio="{{ $servicio['CODIGO_SERVICIO'] }}"
                               data-url="{{ route('vista.informes', ['idservicio' => $servicio['CODIGO_SERVICIO'], 'idproducto' => $producto['CODIGO_PRODUCTO'] ])  }}"  class="elementor-icon navegar-servicio p-border-2 p-shadow-7" href="javascript:void(0)">
                                <div class="p-mb-3 p-mr-5 p-ml-5 p-text-center" id="contenedor-logo{{$servicio['CODIGO_SERVICIO']}}">
                                    <img src="{{ Wordpress::recurso($servicio['LOGO']) }}?v1.0" style="max-width:100%;height: auto"  />
                                </div>
                                <div class="p-d-block">
                                        <div style="font-size: 1.4rem;line-height: 1.5rem;display: inline-table">
                                            <div style="display: table-caption">
                                                <span class="p-text-bold">  {{ $servicio['NOMBRE_SERVICIO'] }}  </span>
                                            </div>

                                        </div>
                                 </div>  
                                <!--<div class="contenedor-logo" id="contenedor-logo{$servicio->servicio['CODIGO_SERVICIO']}"></div>-->
                               <!-- <img src=".{  $servicio->servicio['LOGO']  }" style="width:100%;height: auto"  />-->

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="p-col-12 p-mt-5">
            <div class="p-d-flex">
                <div class="color-azul p-ml-md-5 p-ml-1 p-d-flex" style="align-items: center"> <i class="pi-2x pi pi-search p-mr-2"></i>  <b class="color-azul"> Buscar por: </b> </div>
                <div class="p-ml-4">
                    <div class="ng-tns-c49-13 p-dropdown p-component p-dropdown-open p-dropdown-clearable">
                        <div class="p-hidden-accessible ng-tns-c49-13"><input type="text" readonly="" aria-haspopup="listbox" role="listbox"  placeholder="" aria-activedescendant="p-highlighted-option" aria-expanded="true" data-tskb-is-on="vrai"></div>
                        <!----><span class="ng-tns-c49-13 p-dropdown-label p-inputtext p-placeholder ng-star-inserted color-blue">Selecciona una opción</span><!----><!----><!---->
                        <div role="button" aria-haspopup="listbox" class="p-dropdown-trigger bg-azul" aria-expanded="true"><span class="p-dropdown-trigger-icon ng-tns-c49-13 pi pi-caret-down p-text-white"></span></div>
                        <div onoverlayanimationend="" class="ng-trigger ng-trigger-overlayAnimation ng-tns-c49-13 p-dropdown-panel p-component ng-star-inserted" style="z-index: 1001; transform-origin: center top; top: 40px; left: 0px;">
                            <!----><!---->
                            <div class="p-dropdown-items-wrapper p-d-none" style="max-height: 200px;">
                                <ul role="listbox" class="p-dropdown-items " id="pr_id_2_list">
                                    <!---->
                                    <p-dropdownitem class="p-element ng-tns-c49-13 ng-star-inserted" style="">
                                        <li role="option" pripple="" class="p-ripple p-element p-dropdown-item" id="" aria-label="New York" aria-selected="false">
                                            <span class="ng-star-inserted">New York</span><!----><!----><span class="p-ink" style="height: 177px; width: 177px; top: -75px; left: -31.5px;"></span>
                                        </li>
                                    </p-dropdownitem>
                                    <p-dropdownitem class="p-element ng-tns-c49-13 ng-star-inserted" style="">
                                        <li role="option" pripple="" class="p-ripple p-element p-dropdown-item" id="" aria-label="Rome" aria-selected="false">
                                            <span class="ng-star-inserted">Rome</span><!----><!----><span class="p-ink"></span>
                                        </li>
                                    </p-dropdownitem>
                                    <p-dropdownitem class="p-element ng-tns-c49-13 ng-star-inserted" style="">
                                        <li role="option" pripple="" class="p-ripple p-element p-dropdown-item" id="" aria-label="London" aria-selected="false">
                                            <span class="ng-star-inserted">London</span><!----><!----><span class="p-ink"></span>
                                        </li>
                                    </p-dropdownitem>
                                    <p-dropdownitem class="p-element ng-tns-c49-13 ng-star-inserted" style="">
                                        <li role="option" pripple="" class="p-ripple p-element p-dropdown-item" id="" aria-label="Istanbul" aria-selected="false">
                                            <span class="ng-star-inserted">Istanbul</span><!----><!----><span class="p-ink"></span>
                                        </li>
                                    </p-dropdownitem>
                                    <p-dropdownitem class="p-element ng-tns-c49-13 ng-star-inserted" style="">
                                        <li role="option" pripple="" class="p-ripple p-element p-dropdown-item" id="" aria-label="Paris" aria-selected="false">
                                            <span class="ng-star-inserted">Paris</span><!----><!----><span class="p-ink"></span>
                                        </li>
                                    </p-dropdownitem>
                                    <!----><!----><!----><!----><!----><!----><!----><!----><!----><!---->
                                </ul>
                            </div>
                            <!---->
                        </div>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
        <div class="p-col-12 p-mt-2">
            <div id="root_informes"></div>
        </div>
    </div>
</div>
<script>

    $(function () {
        $(".navegar-servicio").each(function (e) {
            const elem = $(this);
            const id = elem.attr("data-idservicio");
            const url = elem.attr("data-url");
            const logo = elem.attr("data-logo") + "?v1.2";
          /*  $.get({
                url: logo,
                dataType: 'text'
            }, function (data) {
                $("#contenedor-logo" + id).html( data.replace('id="RECUADRO"', 'class="RECUADRO"')
                        .replace('id="Recuadro"', 'class="RECUADRO"')
                        .replace( /(st[0-9]{1,3})/gm,  '$1\_'  + id)
                );
            });*/

            elem.on('click', function () {
                $(".navegar-servicio").removeClass("bg-naranja p-text-white");
                $(".contenedor-logo").each(function () {
                    $(this).removeClass('activo');
                } );
                $("#contenedor-logo" + id ).addClass('activo').parent("a").addClass("bg-naranja p-text-white");
                
                //$("#contenedor-logo" + id + ' svg  .RECUADRO').css({ "fill" :  "rgb(51, 85, 154)" })
                //$("#contenedor-logo" + id + ' > svg > text').css({ "color" :  "white" })
                cargarInformes(url);
            });
        });
        $("#regresar-productos").on('click', function (e) {
            const url = $("#urlVista").val();
            /** esta funcion esta definida en vista sector */
            cargarProductos( url );
        });
    });

    function cargarInformes(url){
        cargando('');
        $("#root_informes").load(url ,function(){
            $("html, body").animate({
                   scrollTop: $("#root_informes").offset().top 
             });
            swal.close();
        });
    }
</script>




