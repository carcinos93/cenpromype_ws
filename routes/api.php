<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */
/*
  Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
  });
 */


/**
 * ** */
# metodos se las paginas del sitio
Route::get('/test', function () {
    return "funciona";
});

Route::post('login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('registro', [\App\Http\Controllers\PortalController::class, 'registro']);
Route::get('confirmar', [\App\Http\Controllers\PortalController::class, 'confirmar']);
Route::get('existeUsuario', [\App\Http\Controllers\PortalController::class, 'existeUsuario']);

Route::post('generar-pdf', [\App\Http\Controllers\TBController::class, 'GenerarDocumento' ]); //->middleware(['auditoria']);
Route::post('cargar-archivos',  'FileUploadController@cargaArchivos' );
Route::get('archivos-lista',  'FileUploadController@listFiles' );
Route::get('actualizar-cache-archivos', 'FileUploadController@updateCacheFiles' );

//Route::get('generar-noticias/{id}', 'NoticiasController@CargarNoticias');
Route::get('lista-noticias', 'NoticiasController@NoticiasAll');
Route::prefix('usuarios')->middleware(['auditoria'])->group( function () {
     //USUARIOS
     Route::get('/usuario', 'UsuarioController@UsuarioAll');
     Route::post('/usuario', 'UsuarioController@UsuarioInsert');
     Route::put('/usuario/{id}', 'UsuarioController@UsuarioUpdate');
     Route::put('/actualizar/password/{id}', 'UsuarioController@ActualizarPassword');
    //ROL
     Route::get('/rol', 'UsuarioController@RolAll');
     Route::post('/rol', 'UsuarioController@RolInsert');
     Route::put('/rol/{id}', 'UsuarioController@RolUpdate');

    //USUARIO X ROL
    Route::get('/usuario-rol', 'UsuarioController@UsuarioRolAll');
    Route::post('/usuario-rol', 'UsuarioController@UsuarioRolInsert');
    Route::put('/usuario-rol/{id}', 'UsuarioController@UsuarioRolUpdate');
    Route::delete('/usuario-rol/{id}', 'UsuarioController@UsuarioRolDelete');
    Route::get('menuUsuario', [\App\Http\Controllers\LoginController::class, 'MenuUsuario']);
});

Route::prefix('TB')->middleware(['phpini'])->group(function () {
    #INDICADOR
    Route::get('/indicador','TBController@IndicadorAll');
    Route::post('/indicador','TBController@IndicadorInsert');
    Route::put('/indicador/{id}', 'TBController@IndicadorUpdate');
    Route::delete('/indicador/{id}', 'TBController@IndicadorDelete');

    #PRODUCTOS
    Route::get('/producto','TBController@ProductoAll');
    Route::post('/producto','TBController@ProductoInsert');
    Route::put('/producto/{id}', 'TBController@ProductoUpdate');
    Route::delete('/producto/{id}', 'TBController@ProductoDelete');

    #DOCUMENTOS X SERVICIOS
    Route::get('/documento-servicio','TBController@DocumentoServicioAll');
    Route::post('/documento-servicio','TBController@DocumentoServicioInsert');
    Route::put('/documento-servicio/{id}', 'TBController@DocumentoServicioUpdate');
    #DOCUMENTO
    Route::get('/documento','TBController@DocumentoAll');
    Route::get('/documento/{id}','TBController@DocumentoFirst');
    Route::post('/documento','TBController@DocumentoInsert');
    Route::put('/documento/{id}', 'TBController@DocumentoUpdate');
    Route::delete('/documento/{id}', 'TBController@DocumentoDelete');

    #DOCUMENTO X PALABRAS
    Route::get('/documento-palabra','TBController@DocumentoPalabraAll');
    Route::post('/documento-palabra','TBController@DocumentoPalabraInsert');
    Route::put('/documento-palabra/{id}','TBController@DocumentoPalabraUpdate');

    #PRODUCTO X GRUPO
    Route::get('/documento-grupo','TBController@DocumentoGrupoAll');
    Route::post('/documento-grupo','TBController@DocumentoGrupoInsert');
    Route::put('/documento-grupo/{id}','TBController@DocumentoGrupoUpdate');

    #PRODUCTO X SECTORES
    Route::get('/producto-sector','TBController@ProductoSectorAll');
    Route::post('/producto-sector','TBController@ProductoSectorInsert');
    Route::put('/producto-sector/{id}','TBController@ProductoSectorUpdate');
    Route::delete('/producto-sector/{id}','TBController@ProductoSectorDelete');

    #menu
    Route::get('/menu','CatalogosController@MenuAll');
    Route::get('/menu/roles/{idrol}', function ($idrol) {
        return \Illuminate\Support\Facades\DB::table('TB_MENU_ROLES')->where('CODIGO_ROL','=',  $idrol)->get();
    });
    Route::get('/menu/{id}', function ($id) {
        return \App\Models\TB\Menu::find($id);
    });
    Route::post('/menu/roles/{idrol}','CatalogosController@MenuRolInsert');
    Route::put('/menu/menu-padre/{id}','CatalogosController@UpdateMenuPadre');


});

Route::prefix('catalogos')->group(function () {

    Route::get('/catalogo/{tipo}/{nivel}', function ($tipo, $nivel) {

        $catalogos =  \App\Models\Catalogos\Catalogo::where('TIPO_CATALOGO', '=', $tipo)
        ->where('NIVEL', '=', $nivel);
        if (request()->exists("padre")) {
            $catalogos = $catalogos->where('CATALOGO_PADRE', '=', request()->input('padre'));
        }

      
        return $catalogos->get();
        
    });

    Route::get('/formulario/{id}', function ($id) {
        return \App\Models\Catalogos\Formulario::with('preguntas')->find($id);
    });

    Route::get('/formulario/pregunta/{id}', function ($id) {
        $valor = request()->input('valor');
        $formulario = \App\Models\Catalogos\Formulario::with('preguntas')
        ->where('CAMPO_DEPENDE', '=', $id)
        ->where('VALOR_DEPENDE', '=', $valor)
        ->first();

        return $formulario ?? [ 'preguntas' => [] ];
    });

    //Rutas que requieren autorizacion
    Route::middleware(['auditoria'])->group(function () {
        /* PAISES**/
        Route::get('/paises','CatalogosController@PaisesAll');
        Route::post('/paises','CatalogosController@PaisesInsert');
        Route::put('/paises/{id}', 'CatalogosController@PaisesUpdate');
        Route::delete('/paises/{id}', 'CatalogosController@PaisesDelete');

        /**GRUPO INDICADOR**/
        Route::get('/grupo-indicador', 'CatalogosController@GrupoIndicadorAll');
        Route::post('/grupo-indicador', 'CatalogosController@GrupoIndicadorInsert');
        Route::put('/grupo-indicador/{id}', 'CatalogosController@GrupoIndicadorUpdate');
        Route::delete('/grupo-indicador/{id}', 'CatalogosController@GrupoIndicadorDelete');

        /**GRUPO INDICADOR**/
        Route::get('/indicador', 'CatalogosController@IndicadorAll');
        Route::post('/indicador', 'CatalogosController@IndicadorInsert');
        Route::put('/indicador/{id}', 'CatalogosController@IndicadorUpdate');
        Route::delete('/indicador/{id}', 'CatalogosController@IndicadorDelete');

        ///DEPARTAMENTOS
        Route::get('/departamentos', 'CatalogosController@DepartamentosAll');
        Route::post('/departamentos', 'CatalogosController@DepartamentosInsert');
        Route::put('/departamentos/{id}', 'CatalogosController@DepartamentosUpdate');
        Route::delete('/departamentos/{id}', 'CatalogosController@DepartamentosDelete');

        ///FUENTE DE INFORMACION
        Route::get('/fuente-informacion', 'CatalogosController@FuentesInformacionAll');
        Route::post('/fuente-informacion', 'CatalogosController@FuentesInformacionInsert');
        Route::put('/fuente-informacion/{id}', 'CatalogosController@FuentesInformacionUpdate');
        Route::delete('/fuente-informacion/{id}', 'CatalogosController@FuentesInformacionDelete');


        //ACTIVIDADES ECONOMICAS
        Route::get('/actividades-economicas', 'CatalogosController@ActividadesEconomicasAll');
        Route::post('/actividades-economicas', 'CatalogosController@ActividadesEconomicasInsert');
        Route::put('/actividades-economicas/{id}', 'CatalogosController@ActividadesEconomicasUpdate');
        Route::delete('/actividades-economicas/{id}', 'CatalogosController@ActividadesEconomicasDelete');

        //TIPO EMPRESAS
        Route::get('/tipo-empresa', 'CatalogosController@TipoEmpresaAll');
        Route::post('/tipo-empresa', 'CatalogosController@TipoEmpresaInsert');
        Route::put('/tipo-empresa/{id}', 'CatalogosController@TipoEmpresaUpdate');
        Route::delete('/tipo-empresa/{id}', 'CatalogosController@TipoEmpresaDelete');

        //SECTORES ECONOMICOS
        Route::get('/sector-economico', 'CatalogosController@SectorEconomicoAll');
        Route::post('/sector-economico', 'CatalogosController@SectorEconomicoInsert');
        Route::put('/sector-economico/{id}', 'CatalogosController@SectorEconomicoUpdate');
        Route::delete('/sector-economico/{id}', 'CatalogosController@SectorEconomicoDelete');

        //REGION
        Route::get('/region', 'CatalogosController@RegionAll');
        Route::post('/region', 'CatalogosController@RegionInsert');
        Route::put('/region/{id}', 'CatalogosController@RegionUpdate');
        Route::delete('/region/{id}', 'CatalogosController@RegionDelete');

        Route::get('/servicio', 'CatalogosController@ServicioAll');
        Route::post('/servicio', 'CatalogosController@ServicioInsert');
        Route::put('/servicio/{id}', 'CatalogosController@ServicioUpdate');
        Route::delete('/servicio/{id}', 'CatalogosController@ServicioDelete');
    });
    
});

Route::post('/traducir', 'TraductorController@Traducir');

Route::prefix('vista')->group(function () {
    Route::get('/sectores', 'VistaController@sectores');
    Route::get('/sectores/{sector}', function ($sector) {
        return App\Models\Catalogos\SectorEconomico::find( $sector  );
    });
    Route::get('/productos/{sector}', 'VistaController@productos')->name('api.vista.productos');
    Route::get('/servicios/{producto}', 'VistaController@servicios');
    Route::get('/informes/{producto}/{servicio}', 'VistaController@informes');
    
});

Route::prefix('listas')->group(function () {
     Route::get('/paises', 'CatalogosController@PaisesLista');
     Route::get("/tipo-instituciones", function () {
         return DB::table("CAT_TIPO_INSTITUCIONES")->selectRaw("CODIGO_TIPO_INST as id, TIPO_INSTITUCION as descripcion")->get();
     });

     Route::get('/empresa-sector', function () {
         $lang = request()->get('lang', 'es');
         return DB::table('CAT_SECTOR_EMPRESA')->selectRaw("CODIGO_SEC_EMP AS id, SECTOR_EMPRESA as descripcion_es, SECTOR_EMPRESA_EN as descripcion_en")->get();
     });

     Route::get('/empresa-actividad/{sector}', function ($sector) {
        $lang = request()->get('lang', 'es');
        return DB::table('TB_EMPRESA_ACTIVIDAD')->selectRaw("CODIGO_ACT AS id, ACTIVIDAD_ECONOMICA as descripcion_es, ACTIVIDAD_ECONOMINCA_EN as descripcion_en")->where('CODIGO_SEC_EMP', '=', $sector)->get();
    });

     Route::middleware(['auditoria'])->group(function () {
        Route::get('/grupo-indicadores', 'CatalogosController@GrupoIndicadoresLista');
        Route::get('/indicadores', 'CatalogosController@IndicadorLista');
        Route::get('/fuente-informacion', 'CatalogosController@FuenteInformacionLista');
        Route::get('/sectores', 'CatalogosController@SectorEconomicoLista');
        Route::get('/productos', 'CatalogosController@ProductoLista');
        Route::get('/servicios', 'CatalogosController@ServicioLista');
        Route::get('/grupos', 'CatalogosController@GrupoLista');
        Route::get('/documentos', 'CatalogosController@DocumentoLista');
        Route::get('/palabras', 'TBController@PalabrasLista');
       Route::get('/roles', function ( ) {
           return \App\Models\Usuarios\Rol::selectRaw('CODIGO_ROL as id, NOMBRE_ROL as descripcion')->get();
       });
     });
    
});



