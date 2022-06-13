<?php

use App\Exports\RegistroExport;
use App\Jobs\NoticiasConsulta;
use App\Models\Catalogos\SectorEconomico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return abort(404, 'No autorizado');
});


Route::get('administrativo', function () {
    return view('administrativo.index');
});

Route::get('job', function (){
    for ($i = 1, $total = 10; $i <= $total; $i++)
    {
        $job = (new NoticiasConsulta( $i ))->delay(60 * $i);
        dispatch($job);
    }
    //$job = (new NoticiasConsulta())->delay()

    return "listo";
});

Route::get('/inicio', function () {
    return view('login.login');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/vistas/ok', 'VistaController@RenderOk')->name('vista.ok');
Route::get('/vistas/inicial', 'VistaController@RenderInicial')->name('vista.inicial');
Route::get('/vistas/sectores', 'VistaController@RenderSectores')->name('vista.sectores');

//Route::get('/vistas/sectores/{sector}', 'VistaController@RenderSector')->name('vista.sector');
Route::get('/vistas/sectores/{sector}/{isLogged}', function ($sector, $isLogged) { 
    $sectorData = SectorEconomico::find($sector);
    return view('sector.sectorNuevo', [ 
        'idsector' => $sector,
        'sector' => $sectorData,
        'isLogged' => $isLogged
    ]);
})->name('vista.sector');

//Route::get('/vistas/productos/{sector}', 'VistaController@RenderProductos')->name('vista.productos');
Route::get('/vistas/servicios/{idproducto}/{idsector}', 'VistaController@RenderServicios')->name('vista.servicios');
Route::get('/vistas/informes/{idservicio}/{idproducto}', 'VistaController@RenderInformes')->name('vista.informes');
Route::get('/vistas/documento/{iddocumento}', 'VistaController@RenderDocumento')->name('vista.documento');

Route::get('/vistas/reporte/registro/{formulario}', function ($formulario) {
    $fecha = (new DateTime())->format("Ymd_His");
    return Excel::download( new RegistroExport($formulario), "registro_$fecha.xlsx");
});

// test
Route::get('/vistas/reporte/registro', function () {
    $preguntas = \App\Models\Catalogos\Pregunta::
     where("ID_FORMULARIO",'=', 1)
    ->where('ACTIVO', '=', '1')
    ->orderBy("ID_FORMULARIO")
    ->orderBy('ORDEN')
    ->get();

    $usuarios = \App\Models\TB\Usuarios::with([ 'respuestas' => function ($q) {
        $q->join('CAT_PREGUNTAS AS T2', 'T2.ID', 'TB_USUARIO_RESPUESTAS.ID_PREGUNTA' )
        ->where('T2.ID_FORMULARIO', '=', 1)
        ->orderBy('T2.ID_FORMULARIO')
        ->orderBy('T2.ORDEN');
    } ])->get();


    return view('excel.registro', ['preguntas' => $preguntas, 'usuarios' => $usuarios]);
});