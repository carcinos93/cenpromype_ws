<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> @yield('title') </title>
        
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/app_adm.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/primeicons.css')  }}" />
        @yield('styles')
    </head>
    <body>
        <section class="h-100">
                @yield('content')
                <div id="app">
                    <base-grid 
                        :rutas="{ 'datos': 'catalogos/paises'  }"
                        :controles="[  
                            { 'campo': 'NOMBRE_PAIS', 'titulo' : 'Nombre', 'tipo' : 'texto' },
                            { 'campo': 'FECHA_ADICION', 'titulo' : 'Fecha creación', 'tipo' : 'calendario' }, 
                            { 'campo': 'ISO2', 'titulo': 'ISO 2', 'tipo': 'lista', 'origenDatos': 'catalogos/catalogo/3/0?group=0' }
                        ]"
                        :conversiones="{ 'FECHA_ADICION': 'date'  }"
                        :configuracion="{ 
                            'dataTable': {  
                                    'columnas': [ 
                                    { 'titulo': 'ID', 'campo': 'CODIGO_PAIS' }, 
                                    {'titulo': 'Nombre', 'campo': 'NOMBRE_PAIS'},
                                    {'titulo': 'Superficie', 'campo': 'SUPERFICIE', 'filtros': ['number', ['sufijo', [ 'km.' ] ]]},
                                    {'titulo': 'Código de divisa', 'campo': 'CODIGO_DIVISA'},
                                    {'titulo': 'iso 2', 'campo': 'ISO2'},
                                    {'titulo': 'iso 3', 'campo': 'ISO3'},
                                    { 'titulo': 'Fecha creación', 'campo': 'FECHA_ADICION', 'filtros': [ ['date', ['DD/MM/yyyy'] ] ] }
                    ]  } }"></base-grid>
                </div>
        </section>
    </body>
    @yield('initialScript')
    <script src="{{asset('js/app_adm.js?v2.0.2')}}" async></script>
    @yield('scripts')

</html>
