<?php

namespace App\Http\Controllers;

use App\Models;
use App\Models\TB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class TBController extends Controller {
   #INDICADORES
    public function IndicadorAll(  ) {
    return $this->getRecords(TB\Indicador::class, ['TB_INDICADORES.*', 'CAT_PAISES.NOMBRE_PAIS', 'CAT_INDICADORES.NOMBRE_INDICADOR', 'CAT_FUENTE_INFORMACION.FUENTE_INFORMACION'],
                array(
                        ['left', 'CAT_PAISES', 'TB_INDICADORES.CODIGO_PAIS', '=', 'CAT_PAISES.CODIGO_PAIS'],
                        ['left', 'CAT_INDICADORES', 'TB_INDICADORES.CODIGO_INDICADOR', '=', 'CAT_INDICADORES.CODIGO_INDICADOR'],
                        ['left', 'CAT_FUENTE_INFORMACION', 'TB_INDICADORES.CODIGO_FUENTE', '=', 'CAT_FUENTE_INFORMACION.CODIGO_FUENTE']
                    ), '', request());
    }
    public function IndicadorInsert(  ) {
         return $this->insert(Indicador::class, array(
                    'CODIGO_FUENTE' => 'codigo_fuente',
                    'CODIGO_PAIS' => 'codigo_pais',
                    'CODIGO_INDICADOR' => 'codigo_indicador',
                    'ANIO' => 'anio',
                    'VALOR1' => 'valor1',
                    'VALOR2' => 'valor2'
            ), request());
    }
     public function IndicadorUpdate( $id ) {
         return $this->update(Indicador::class, $id, array(
                    'CODIGO_FUENTE' => 'codigo_fuente',
                    'CODIGO_PAIS' => 'codigo_pais',
                    'CODIGO_INDICADOR' => 'codigo_indicador',
                    'ANIO' => 'anio',
                    'VALOR1' => 'valor1',
                    'VALOR2' => 'valor2'
            ), request());
    }

    public function IndicadorDelete( $id   ) {
        return $this->delete( Indicador::class, $id, request() );
    }

    #PRODUCTOS
    public function ProductoAll(  ) {
        return $this->getRecords(Models\TB\Producto::class, ['TB_PRODUCTOS.*'],
            array(
                /*['left', 'TB_PRODUCTOS_X_SECTORES', 'TB_PRODUCTOS_X_SECTORES.CODIGO_PRODUCTO','=', 'TB_PRODUCTOS.CODIGO_PRODUCTO' ],
                ['left', 'CAT_SECTORES_ECONOMICOS', 'TB_PRODUCTOS_X_SECTORES.CODIGO_SECTOR', '=', 'CAT_SECTORES_ECONOMICOS.CODIGO_SECTOR'],*/
            ), '', request());
    }
    public function ProductoInsert(  ) {
        return $this->insert(TB\Producto::class, array(
            //'CODIGO_SECTOR' => 'codigo_sector',
            'NOMBRE_PRODUCTO' => 'nombre',
            'LOGO' => 'logo',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso'
        ), request());
    }
    public function ProductoUpdate( $id ) {
        return $this->update(TB\Producto::class, $id, array(
            //'CODIGO_SECTOR' => 'codigo_sector',
            'NOMBRE_PRODUCTO' => 'nombre',
            //'LOGO' => 'logo',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso'
        ), request());
    }
    public function ProductoDelete( $id   ) {
        return $this->delete( TB\Producto::class, $id, request() );
    }


    #DOCUMENTOS
    public function DocumentoAll(  ) {
        return $this->getRecords(Models\TB\Documento::class, ['TB_DOCUMENTOS.*', 'TB_PRODUCTOS.NOMBRE_PRODUCTO'],
            array(
               // ['left', 'CAT_SECTORES_ECONOMICOS', 'TB_DOCUMENTOS.CODIGO_SECTOR', '=', 'CAT_SECTORES_ECONOMICOS.CODIGO_SECTOR'],
                ['left', 'TB_PRODUCTOS', 'TB_PRODUCTOS.CODIGO_PRODUCTO', '=', 'TB_DOCUMENTOS.CODIGO_PRODUCTO']
            ), '', request());
    }
    public function DocumentoInsert(  ) {
        return $this->insert(Models\TB\Documento::class, array(
            'CODIGO_PRODUCTO' => 'codigo_producto',
            'DESCRIPCION_DOCUMENTO' => 'descripcion',
            'CONTENIDO' => 'contenido',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso'
        ), request());
    }
    public function DocumentoUpdate( $id ) {
        return $this->update(Models\TB\Documento::class, $id, array(
            'CODIGO_PRODUCTO' => 'codigo_producto',
            'DESCRIPCION_DOCUMENTO' => 'descripcion',
            'CONTENIDO' => 'contenido',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso'
        ), request());
    }

    # DOCUMENTOS X PALABRAS CLAVES
    public function DocumentoPalabraAll(  ) {
        return $this->getRecords(Models\TB\DocumentoPalabras::class, ['TB_PALABRAS_X_DOCUMENTO.*', 'TB_PALABRAS_CLAVE.PALABRA_CLAVE'],
            array(
                 ['left', 'TB_PALABRAS_CLAVE', 'TB_PALABRAS_CLAVE.ID_CLAVE', '=', 'TB_PALABRAS_X_DOCUMENTO.ID_CLAVE'],
               // ['left', 'TB_PRODUCTOS', 'TB_PRODUCTOS.CODIGO_PRODUCTO', '=', 'TB_DOCUMENTOS.CODIGO_PRODUCTO']
            ), '', request());
    }
    public function DocumentoPalabraInsert(  ) {
        return $this->insert(Models\TB\DocumentoPalabras::class, array(
            'CODIGO_DOCUMENTO' => 'CODIGO_DOCUMENTO',
            'ID_CLAVE' => 'ID_CLAVE',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }
    public function DocumentoPalabraUpdate( $id ) {
        return $this->update(Models\TB\DocumentoPalabras::class, $id, array(
            'CODIGO_DOCUMENTO' => 'CODIGO_DOCUMENTO',
            'ID_CLAVE' => 'ID_CLAVE',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }

    #DOCUMENTOS X SERVICIOS
    public function DocumentoServicioAll(  ) {
        return $this->getRecords(Models\TB\DocumentoServicio::class,
            array(
                'CAT_SERVICIOS.NOMBRE_SERVICIO',
                'TB_DOCUMENTOS_X_SERVICIO.*'),
            array(
                ['left', 'CAT_SERVICIOS', 'CAT_SERVICIOS.CODIGO_SERVICIO', '=', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_SERVICIO']
            ), '', request());
    }

    public function DocumentoServicioInsert(  ) {
        return $this->insert(Models\TB\DocumentoServicio::class, array(
            'CODIGO_DOCUMENTO' => 'CODIGO_DOCUMENTO',
            'CODIGO_SERVICIO' => 'CODIGO_SERVICIO',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }
    public function DocumentoServicioUpdate( $id ) {
        return $this->update(Models\TB\DocumentoServicio::class, $id, array(
            'CODIGO_DOCUMENTO' => 'CODIGO_DOCUMENTO',
            'CODIGO_SERVICIO' => 'CODIGO_SERVICIO',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }

    #DOCUMENTOS X GRUPOS
    public function DocumentoGrupoAll(  ) {
        return $this->getRecords(Models\TB\DocumentoGrupo::class,
            array(
                'TB_GRUPOS.NOMBRE_GRUPO',
                'TB_GRUPOS_X_DOCUMENTO.*'),
            array(
                ['left', 'TB_GRUPOS', 'TB_GRUPOS.CODIGO_GRUPO', '=', 'TB_GRUPOS_X_DOCUMENTO.CODIGO_GRUPO']
            ), '', request());
    }

    public function DocumentoGrupoInsert(  ) {
        return $this->insert(Models\TB\DocumentoGrupo::class, array(
            'CODIGO_DOCUMENTO' => 'CODIGO_DOCUMENTO',
            'CODIGO_GRUPO' => 'CODIGO_GRUPO',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }
    public function DocumentoGrupoUpdate( $id ) {
        return $this->update(Models\TB\DocumentoGrupo::class, $id, array(
            'CODIGO_DOCUMENTO' => 'CODIGO_DOCUMENTO',
            'CODIGO_GRUPO' => 'CODIGO_GRUPO',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }

    #PRODUCTOS X SECTORES
    public function ProductoSectorAll(  ) {
        return $this->getRecords(Models\TB\ProductoSector::class,
            array(
                'CAT_SECTORES_ECONOMICOS.SECTOR_ECONOMICO',
                'TB_PRODUCTOS_X_SECTORES.*'),
            array(
                ['left', 'CAT_SECTORES_ECONOMICOS', 'CAT_SECTORES_ECONOMICOS.CODIGO_SECTOR', '=', 'TB_PRODUCTOS_X_SECTORES.CODIGO_SECTOR']
                // ['left', 'TB_GRUPOS', 'TB_GRUPOS.CODIGO_GRUPO', '=', 'TB_DOCUMENTOS_X_SERVICIO.CODIGO_GRUPO'],

            ), '', request());
    }
    public function ProductoSectorInsert(  ) {
        return $this->insert(Models\TB\ProductoSector::class, array(
            'CODIGO_PRODUCTO' => 'CODIGO_PRODUCTO',
            'CODIGO_SECTOR' => 'CODIGO_SECTOR',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }
    public function ProductoSectorUpdate( $id  ) {
        return $this->update(Models\TB\ProductoSector::class, $id, array(
            'CODIGO_PRODUCTO' => 'CODIGO_PRODUCTO',
            'CODIGO_SECTOR' => 'CODIGO_SECTOR',
            'ESTATUS' => 'ESTATUS'
        ), request());
    }

    /*#listas**/
    public function PalabrasLista(  ) {
        return $this->dropdownRecords(TB\PalabraClave::class, [ 'ID_CLAVE as id', 'PALABRA_CLAVE as descripcion'],"PALABRA_CLAVE", request());
    }

}
