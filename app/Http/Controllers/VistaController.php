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

    public function RenderInicial() {
        return $this->RenderSectores();
    }
    public function RenderSectores() {

        $sectores = Catalogos\SectorEconomico::where('ESTATUS','=','ACTIVO')->get();
        //$url = "http://72.167.226.188/~oqmdev/portalcenpromype";
        $url = config('sistema.paths.wordpress_sitio');  //'..';
        return view('sector/sector' , ['sectores' => $sectores, 'url' => $url] );
    }

    public function RenderProductos($sector) {
        $url = config('sistema.paths.wordpress_sitio');  //'..';
        $productos = TB\Producto::select('TB_PRODUCTOS.*')->join('TB_PRODUCTOS_X_SECTORES', 'TB_PRODUCTOS.CODIGO_PRODUCTO', 'TB_PRODUCTOS_X_SECTORES.CODIGO_PRODUCTO')
            ->where('TB_PRODUCTOS_X_SECTORES.CODIGO_SECTOR', '=', $sector)
            ->where('TB_PRODUCTOS.ESTATUS', '=', 'ACTIVO')
            ->where('TB_PRODUCTOS_X_SECTORES.ESTATUS', '=', 1)
            ->get();

        return view('producto/producto' , ['productos' => $productos, 'url' => $url, 'idsector' => $sector]);
    }

    public function RenderServicios($idproducto , $idsector) {
        $producto =  TB\Producto::where('CODIGO_PRODUCTO', '=', $idproducto)->first();

        $sector = DB::table('TB_PRODUCTOS_X_SECTORES')
            ->where('CODIGO_PRODUCTO', '=', $idproducto)
            ->where('CODIGO_SECTOR','=', $idsector)
            ->first();
        //var_dump($sector);
        $urlVistaProducto = route('vista.productos', ['sector' =>  $sector->CODIGO_SECTOR ]);
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
        $servicios = Catalogos\Servicio::whereExists(function ($q) use ($idproducto) {
               $q->select(DB::raw(1))->from('TB_DOCUMENTOS_X_SERVICIO')
                ->join('TB_DOCUMENTOS', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_DOCUMENTO', 'TB_DOCUMENTOS.CODIGO_DOCUMENTO')
                ->where('TB_DOCUMENTOS.CODIGO_PRODUCTO', '=', $idproducto)
                ->where('TB_DOCUMENTOS.ESTATUS', '=', 'ACTIVO')
                ->where('TB_DOCUMENTOS_X_SERVICIO.ESTATUS', '=', 1)
               ->whereColumn('CAT_SERVICIOS.CODIGO_SERVICIO', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_SERVICIO');
        })->where('CAT_SERVICIOS.ESTATUS', '=', 'ACTIVO')->get();

        //echo $servicios;
        //echo $servicios;
        //echo json_encode($servicios);
        //$servicios = TB\DocumentoServicio::select('CODIGO_SERVICIO')->where('CODIGO_PRODUCTO', '=', $idproducto)->distinct()->get();


        return view( 'servicio/servicio' , ['servicios' => $servicios, 'urlVista' => $urlVistaProducto, 'producto' => $producto, 'url' => $url ] );
    }

    public function RenderInformes($idservicio, $idproducto) {
        $estatus = "ACTIVO";
        $servicio = Catalogos\Servicio::find($idservicio);
        $informes = TB\Documento::where('ESTATUS', '=', $estatus)->whereExists(function ($q) use ($idservicio, $idproducto) {
            $q->select(DB::raw(1))->from('TB_DOCUMENTOS_X_SERVICIO','T1')
                ->whereColumn('T1.CODIGO_DOCUMENTO', 'TB_DOCUMENTOS.CODIGO_DOCUMENTO')
                ->where('TB_DOCUMENTOS.CODIGO_PRODUCTO','=', $idproducto)
                ->where('T1.CODIGO_SERVICIO', '=', $idservicio)
                ->where('T1.ESTATUS','=', 1);
        })->get();
        //$informes = [];
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
