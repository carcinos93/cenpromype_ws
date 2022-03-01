<?php

use App\Models\Catalogos\SectorEconomico;
use Illuminate\Support\Facades\Route;
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
Route::get('/vistas/sectores/{sector}', function ($sector) { 
    $sectorData = SectorEconomico::find($sector);
    return view('sector.sectorNuevo', [ 
        'idsector' => $sector,
        'sector' => $sectorData
    ]);
})->name('vista.sector');

//Route::get('/vistas/productos/{sector}', 'VistaController@RenderProductos')->name('vista.productos');
Route::get('/vistas/servicios/{idproducto}/{idsector}', 'VistaController@RenderServicios')->name('vista.servicios');
Route::get('/vistas/informes/{idservicio}/{idproducto}', 'VistaController@RenderInformes')->name('vista.informes');
Route::get('/vistas/documento/{iddocumento}', 'VistaController@RenderDocumento')->name('vista.documento');
