<style>
    .p-dropdown{display:inline-flex;cursor:pointer;position:relative;-webkit-user-select:none;-ms-user-select:none;user-select:none}.p-dropdown-clear-icon{position:absolute;top:50%;margin-top:-.5rem}.p-dropdown-trigger{display:flex;align-items:center;justify-content:center;flex-shrink:0}.p-dropdown-label{display:block;white-space:nowrap;overflow:hidden;flex:1 1 auto;width:1%;text-overflow:ellipsis;cursor:pointer}.p-dropdown-label-empty{overflow:hidden;visibility:hidden}input.p-dropdown-label{cursor:default}.p-dropdown .p-dropdown-panel{min-width:100%}.p-dropdown-panel{position:absolute;top:0;left:0}.p-dropdown-items-wrapper{overflow:auto}.p-dropdown-item{cursor:pointer;font-weight:normal;white-space:nowrap;position:relative;overflow:hidden}.p-dropdown-items{margin:0;padding:0;list-style-type:none}.p-dropdown-filter{width:100%}.p-dropdown-filter-container{position:relative}.p-dropdown-filter-icon{position:absolute;top:50%;margin-top:-.5rem}.p-fluid .p-dropdown{display:flex}.p-fluid .p-dropdown .p-dropdown-label{width:1%}
    .contenedor-dinamico .elemento-contenedor:hover {
        background-color: rgba(241, 138, 0, 1);
        transform: scale(1.4,1.4);
    }
    .elemento-contenedor {  border-radius: 5px; }

    .p-w-100 { width: 100% !important;  }
    .color-azul {  color: #135fa7 !important; }
    .p-dropdown {  border: 1px solid #135fa7;  }
    .border-blue {  border: 1px solid #135fa7;  }
    .p-text-white { color: white !important;  }
    .bg-azul {  background-color: #135fa7 !important; }
    .pi-2x { font-size: 2rem; }
    .pi-1_5x { font-size: 1.5rem; }
    .btn-dinamico {
        border: 1px solid #135fa7;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        cursor: pointer;
        color: white;
        border-radius: 5px;
    }
    .btn-2 {  background-color: rgba(241, 138, 0, 1);  }
    .p-button { color: #fff !important; /*padding: 15px 32px; !important;*/  }
    .p-position-absolute { position: absolute; }
    .p-position-relative { position: relative; }
    .bg-white { background-color: #ffffff
    }
    /*.p-input-icon-left > .p-inputtext { padding-left: 2rem;  }
    .p-input-icon-right > .p-inputtext { padding-right: 2rem;  }*/
    .contenedor-dinamico .elementor-icon { border:none !important; }
    @media (min-width: 768px) {
        .p-col-md { max-width: 100%; flex-basis: 0; flex-grow: 1; }
    }

</style>
<div class="elementor-container contenedor-dinamico">
    <div class="p-grid p-jc-center">
        <div class="no-gutter p-col-10 p-shadow-7 bg-white">
            <div class="p-grid p-ml-5 p-mr-5">
                @foreach( $sectores as $sector )
                    <div class="p-col-md p-col-12 p-text-center">
                            <div class="p-m-auto">
                                <div class="elementor-animation-bounce-in elemento-contenedor elementor-icon-wrapper p-text-center p-mt-3 p-mb-3 p-mr-1 p-ml-1">
                                    <a  class="navegar-elemento" data-url="{{ route('vista.productos', ['sector' => $sector['CODIGO_SECTOR']]) }}" href="javascript:void(0)">
                                        <img src="{{ $url }}/{{  $sector['LOGO'] }}?v3.1"  class="p-col-4 p-md-9" style="height: auto"  />
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

    $(function () {
        $(".navegar-elemento").each(function (e) {

            const elem = $(this);
            elem.on('click', function () {
                const url = elem.attr("data-url");
                cargarProductos(url);
            });

        });
    });

    function cargarProductos(url) {
        cargando('')
        $("#root2").load(url ,function(){
            swal.close();
        });
    }
</script>



