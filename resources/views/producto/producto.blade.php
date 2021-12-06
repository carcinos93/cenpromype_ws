
<div class="elementor-container">
    <div class="p-grid p-jc-center">
        <div class="p-col-12 p-m-t-5">
            <h2 class="elementor-heading-title elementor-size-default p-text-center" >
                Descripcion del sector Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium asperiores dolores
            </h2>
            <div class="p-grid p-jc-end">
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
                                <!----><span class="ng-tns-c49-13 p-dropdown-label p-col-md p-pb-1 p-pt-1 p-col-12 p-inputtext p-placeholder ng-star-inserted color-blue">Selecciona una opción</span><!----><!----><!---->
                                <div role="button" aria-haspopup="listbox" class="p-dropdown-trigger bg-azul" aria-expanded="true"><span class="p-dropdown-trigger-icon ng-tns-c49-13 pi pi-caret-down p-text-white"></span></div>
                            </div>
                        </div>
                        <div class="p-col-12 p-col-md p-field">
                            <div class="btn-dinamico btn-2 p-d-flex p-text-center">
                                <span class="p-w-100" > Recursos gratuitos  </span>
                            </div>
                            <!--<button id="recursos"  > </button>-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col no-gutter p-col-12">
            <div class="p-grid">
                @foreach( $productos as $producto )
                    <div class="p-col-12 p-md-6">
                        <div class="elementor-icon-wrapper p-text-center">
                            <a  class="elementor-icon elementor-animation-bounce-in navegar-producto"  data-url="{{ route('vista.servicios', ['idproducto' => $producto['CODIGO_PRODUCTO'], 'idsector' => $idsector ])  }}" href="javascript:void(0)">
                                <img src="{{ $url }}/{{  $producto['LOGO']  }}?v2.0" style="width:100%;height: auto"  />

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
<script>

    $(function () {
        $(".navegar-producto").each(function (e) {

            const elem = $(this);
            elem.on('click', function () {
                const url = elem.attr("data-url");
                cargarServicios(url);
            });

        });
    });

    function cargarServicios(url){
        cargando('');
        /**
         * root2 esta definido en la vista sector/sector.blade.php
         * */
        $("#root2").load(url ,function(){
            swal.close();
        });
    }
</script>

<!--
<div class="elementor-container elementor-column-gap-default" style="
     ">
    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-1cf67905" data-id="1cf67905" data-element_type="column">
        <div class="elementor-widget-wrap elementor-element-populated">
            <section class="elementor-section elementor-inner-section elementor-element elementor-element-6fd96fb0 elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="6fd96fb0" data-element_type="section">
                <div class="elementor-container elementor-column-gap-default">
                    <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-21861db0" data-id="21861db0" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">

                            <section class="elementor-section elementor-inner-section elementor-element elementor-element-14b34dd9 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="14b34dd9" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default">
                                    foreach ($productos as $producto)
                                        <div class="elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-3b5254c4" data-id="3b5254c4" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div class="elementor-element elementor-element-7cc56afd elementor-view-framed elementor-shape-square elementor-widget elementor-widget-icon animated fadeIn" data-id="7cc56afd" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeIn&quot;}" data-widget_type="icon.default">

                                                                <img src="../{  $producto['LOGO'] }}" style="width:100%;height: auto"  />


                                                </div>
                                                <!-<section class="elementor-section elementor-inner-section elementor-element elementor-element-14b2e856 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="14b2e856" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                                    <div class="elementor-container elementor-column-gap-default">
                                                        <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-4fe7ad6e" data-id="4fe7ad6e" data-element_type="column">
                                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                                <div class="elementor-element elementor-element-26e9047d elementor-align-center elementor-widget elementor-widget-button" data-id="26e9047d" data-element_type="widget" data-widget_type="button.default">
                                                                    <div class="elementor-widget-container">
                                                                        <div class="elementor-button-wrapper">
                                                                            <a href="#" class="elementor-button-link elementor-button elementor-size-lg" role="button">
                                        <span class="elementor-button-content-wrapper">
                                            <span class="elementor-button-text">  { $producto['NOMBRE_PRODUCTO'] }}  </span>
                                        </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>->
                                            </div>
                                        </div>
                                    endforeach
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>-->





