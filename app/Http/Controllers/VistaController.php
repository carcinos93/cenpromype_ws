<?php

namespace App\Http\Controllers;

use App\Models;
use App\Models\Catalogos;
use App\Models\TB;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class VistaController extends Controller {

    
    /*** API ***/
    public function sectores( ) {
        return Catalogos\SectorEconomico::where('ESTATUS','=','ACTIVO')->get();
    }

    public function productos($sector) {
        $query = DB::table('TB_PRODUCTOS')->whereExists( function ($q) use ($sector) {
            $q->select(DB::raw(1))
                    ->from('TB_PRODUCTOS_X_SECTORES')
                    ->where('TB_PRODUCTOS_X_SECTORES.CODIGO_SECTOR', '=', $sector)
                    ->where('TB_PRODUCTOS_X_SECTORES.ESTATUS', '=', 1)
                    ->whereColumn('TB_PRODUCTOS_X_SECTORES.CODIGO_PRODUCTO', 'TB_PRODUCTOS.CODIGO_PRODUCTO');
            
        })->where('TB_PRODUCTOS.ESTATUS', '=', 'ACTIVO');
        
        $total = $query->count();
        
       $first = request()->input('first', 0);
       $rows =  request()->input('rows', 10);

       $first = $first == "null" ? 0 : $first;
       $rows = $rows == "null" ? 10 : $rows;

       $data = $query->skip( $first )->take( $rows )->get();
        
        return [ 'total' => $total, 'data' => $data ];
        
        /*return TB\Producto::select('TB_PRODUCTOS.*')->join('TB_PRODUCTOS_X_SECTORES', 'TB_PRODUCTOS.CODIGO_PRODUCTO', 'TB_PRODUCTOS_X_SECTORES.CODIGO_PRODUCTO')
            ->where('TB_PRODUCTOS_X_SECTORES.CODIGO_SECTOR', '=', $sector)
            ->where('TB_PRODUCTOS.ESTATUS', '=', 'ACTIVO')
            ->where('TB_PRODUCTOS_X_SECTORES.ESTATUS', '=', 1)
            ->get();*/
    }
    
    public function servicios($producto) {
         return Catalogos\Servicio::whereExists(function ($q) use ($producto) {
               $q->select(DB::raw(1))->from('TB_DOCUMENTOS_X_SERVICIO')
                ->join('TB_DOCUMENTOS', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_DOCUMENTO', 'TB_DOCUMENTOS.CODIGO_DOCUMENTO')
                ->where('TB_DOCUMENTOS.CODIGO_PRODUCTO', '=', $producto)
                ->where('TB_DOCUMENTOS.ESTATUS', '=', 'ACTIVO')
                ->where('TB_DOCUMENTOS_X_SERVICIO.ESTATUS', '=', 1)
               ->whereColumn('CAT_SERVICIOS.CODIGO_SERVICIO', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_SERVICIO');
        })->where('CAT_SERVICIOS.ESTATUS', '=', 'ACTIVO')->get();
    }
    
    public function informes($servicio, $producto) {
         $estatus = "ACTIVO";
        return TB\Documento::where('ESTATUS', '=', $estatus)->whereExists(function ($q) use ($servicio, $producto) {
            $q->select(DB::raw(1))->from('TB_DOCUMENTOS_X_SERVICIO','T1')
                ->whereColumn('T1.CODIGO_DOCUMENTO', 'TB_DOCUMENTOS.CODIGO_DOCUMENTO')
                ->where('TB_DOCUMENTOS.CODIGO_PRODUCTO','=', $producto)
                ->where('T1.CODIGO_SERVICIO', '=', $servicio)
                ->where('T1.ESTATUS','=', 1);
        })->get(["CODIGO_DOCUMENTO", "DESCRIPCION_DOCUMENTO", "RUTA_DOCUMENTO", "IMAGEN"]);
    }

    /*** VISTAS PARA PORTAL WORDPRESS ***/
    
    public function RenderInicial() {
        return $this->RenderSectores();
    }
    public function RenderSectores() {

        $sectores = $this->sectores();
        $url = config('sistema.paths.wordpress_sitio');  //'..';
        return view('sector/sectores' , ['sectores' => $sectores, 'url' => $url] );
    }

    public function RenderProductos($sector) {
       
        $dataSector = Catalogos\SectorEconomico::find($sector);
        $productos = $this->productos($sector);

        return view('sector/sector' , ['productos' => $productos, 'idsector' => $sector, 'sector' => $dataSector  ]);
    }
    
    public function RenderSector($sector) {
         $dataSector = Catalogos\SectorEconomico::find($sector);
        $productos = $this->productos($sector);

        return view('sector/sector' , ['productos' => $productos, 'idsector' => $sector, 'sector' => $dataSector  ]);
    }

    public function RenderServicios($idproducto , $idsector) {
        $producto =  TB\Producto::where('CODIGO_PRODUCTO', '=', $idproducto)->first();

        /*$sector = DB::table('TB_PRODUCTOS_X_SECTORES')
            ->where('CODIGO_PRODUCTO', '=', $idproducto)
            ->where('CODIGO_SECTOR','=', $idsector)
            ->first();*/
        //var_dump($sector);
        $urlVistaProducto = route('vista.sector', ['sector' =>  $idsector ]);
        $path = '../wp-content/uploads/2021/10/';
        $url = config('sistema.paths.wordpress_sitio');  //'..';

        //$servicios = TB\DocumentoServicio::where('CODIGO_PRODUCTO', '=', $idproducto)->get();
        /*$servicios = TB\DocumentoServicio::leftJoin( 'TB_DOCUMENTOS', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_DOCUMENTO', '=', 'TB_DOCUMENTOS.CODIGO_DOCUMENTO' )
            ->where('TB_DOCUMENTOS.CODIGO_PRODUCTO', '=', $idproducto )->get();*/


        /*$servicios = TB\DocumentoServicio::select('CAT_SERVICIOS.CODIGO_SERVICIO')
            ->join('CAT_SERVICIOS', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_SERVICIO', 'CAT_SERVICIOS.CODIGO_SERVICIO')
            ->join('TB_DOCUMENTOS', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_DOCUMENTO', 'TB_DOCUMENTOS.CODIGO_DOCUMENTO')
            ->where('TB_DOCUMENTOS.CODIGO_PRODUCTO', '=', $idproducto)
            ->where('TB_DOCUMENTOS.ESTATUS', '=', 'ACTIVO')
            ->where('CAT_SERVICIOS.ESTATUS', '=', 'ACTIVO')
            ->where('TB_DOCUMENTOS_X_SERVICIO.ESTATUS', '=', 1)

            ->distinct()
            ->get();*/
        $servicios = $this->servicios($idproducto);

        //echo $servicios;
        //echo $servicios;
        //echo json_encode($servicios);
        //$servicios = TB\DocumentoServicio::select('CODIGO_SERVICIO')->where('CODIGO_PRODUCTO', '=', $idproducto)->distinct()->get();


        return view( 'servicio/servicio' , ['servicios' => $servicios, 'urlVista' => $urlVistaProducto, 'producto' => $producto, 'url' => $url ] );
    }

    public function RenderInformes($idservicio, $idproducto) {
       
        $servicio = Catalogos\Servicio::find($idservicio);
       
        $informes = $this->informes($idservicio, $idproducto);
        return view('informe.informe', ['informes' => $informes, 'servicio' => $servicio]);

    }

    public function RenderDocumento($iddocumento) {
        $documento = TB\Documento::find( $iddocumento );
        return view('documento.documento', [ 'documento' => $documento ]);

        //return $documento['CONTENIDO'];
    }

    public function RenderOk() {
        return "ok";
    }


}
