<?php

namespace App\Http\Controllers;

use App\Models\Catalogos;
use App\Models\TB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class CatalogosController extends Controller
{

    public function GrupoIndicadorInsert()
    {
        return $this->insert(Catalogos\GrupoIndicadores::class, array(
            'NOMBRE_GRUPO_IND' => 'nombre'
        ), request());
    }

    public function GrupoIndicadorUpdate($id)
    {
        return $this->update(Catalogos\GrupoIndicadores::class, $id, array(
            'NOMBRE_GRUPO_IND' => 'nombre'
        ), request());
    }

    public function GrupoIndicadorAll()
    {
        return $this->getRecords(Catalogos\GrupoIndicadores::class, [], [], '', request());
    }

    public function GrupoIndicadorDelete($id)
    {
        return $this->delete(Catalogos\GrupoIndicadores::class, $id, request());
    }


    #PAISES
    public function PaisesAll()
    {
        return $this->getRecords(Catalogos\Pais::class, [], [], '', request());
    }

    public function PaisesInsert()
    {
        return $this->insert(Catalogos\Pais::class, array(
            'NOMBRE_PAIS' => 'nombre',
            'SUPERFICIE' => 'superficie',
            'CODIGO_DIVISA' => 'codigo_divisa',
            'ISO2' => 'iso2',
            'ISO3' => 'iso3',
        ), request());
    }

    public function PaisesUpdate($id)
    {
        return $this->update(Catalogos\Pais::class, $id, array(
            'NOMBRE_PAIS' => 'nombre',
            'SUPERFICIE' => 'superficie',
            'CODIGO_DIVISA' => 'codigo_divisa',
            'ISO2' => 'iso2',
            'ISO3' => 'iso3',
        ), request());
    }

    public function PaisesDelete($id)
    {
        return $this->delete(Catalogos\Pais::class, $id, request());
    }

    #DEPARTAMENTOS
    public function DepartamentosAll()
    {
        return $this->getRecords(Catalogos\Departamento::class, ['CAT_DEPARTAMENTOS.*', 'CAT_PAISES.NOMBRE_PAIS'],
            array(['left', 'CAT_PAISES', 'CAT_DEPARTAMENTOS.CODIGO_PAIS', '=', 'CAT_PAISES.CODIGO_PAIS']), '', request());
    }

    public function DepartamentosInsert()
    {
        return $this->insert(Catalogos\Departamento::class, array(
            'NOMBRE_DEPARTAMENTO' => 'nombre',
            'CODIGO_PAIS' => 'codigo_pais'
        ), request());
    }

    public function DepartamentosUpdate($id)
    {
        return $this->update(Catalogos\Departamento::class, $id, array(
            'NOMBRE_DEPARTAMENTO' => 'nombre',
            'CODIGO_PAIS' => 'codigo_pais'
        ), request());
    }

    public function DepartamentosDelete($id)
    {
        return $this->delete(Catalogos\Departamento::class, $id, request());
    }

    #FUENTES DE INFORMACION
    public function FuentesInformacionAll()
    {
        return $this->getRecords(Catalogos\FuenteInformacion::class, [], [], '', request());
    }

    public function FuentesInformacionInsert()
    {
        return $this->insert(Catalogos\FuenteInformacion::class, array(
            'FUENTE_INFORMACION' => 'fuente_informacion'
        ), request());
    }

    public function FuentesInformacionUpdate($id)
    {
        return $this->update(Catalogos\FuenteInformacion::class, $id, array(
            'FUENTE_INFORMACION' => 'fuente_informacion'
        ), request());
    }

    public function FuentesInformacionDelete($id)
    {
        return $this->delete(Catalogos\FuenteInformacion::class, $id, request());
    }

    #INDICADOR
    public function IndicadorAll()
    {
        return $this->getRecords(Catalogos\Indicador::class, ['CAT_INDICADORES.*', 'CAT_GRUPO_INDICADORES.NOMBRE_GRUPO_IND AS GRUPO_IND'], array([
            'left', 'CAT_GRUPO_INDICADORES', 'CAT_GRUPO_INDICADORES.CODIGO_GRUPO_IND', '=', 'CAT_INDICADORES.CODIGO_GRUPO_IND'
        ]), '', request());
    }

    public function IndicadorInsert()
    {
        return $this->insert(Catalogos\Indicador::class, array(
            'NOMBRE_INDICADOR' => 'nombre',
            'UNIDAD_MEDIDA' => 'unidad',
            'CODIGO_GRUPO_IND' => 'grupo_ind',
            'ETIQUETA1' => 'etiqueta1',
            'ETIQUETA2' => 'etiqueta2'
        ), request());
    }

    public function IndicadorUpdate($id)
    {
        return $this->update(Catalogos\Indicador::class, $id, array(
            'NOMBRE_INDICADOR' => 'nombre',
            'UNIDAD_MEDIDA' => 'unidad',
            'CODIGO_GRUPO_IND' => 'grupo_ind',
            'ETIQUETA1' => 'etiqueta1',
            'ETIQUETA2' => 'etiqueta2'
        ), request());
    }

    public function IndicadorDelete($id)
    {
        return $this->delete(Catalogos\Indicador::class, $id, request());
    }

    #ACTIVIDADES ECONOMICAS
    public function ActividadesEconomicasAll()
    {
        return $this->getRecords(Catalogos\ActividadEconomica::class, [], [], '', request());
    }

    public function ActividadesEconomicasInsert()
    {
        return $this->insert(Catalogos\ActividadEconomica::class, array(
            'ACTIVIDAD_ECONOMICA' => 'actividad_economica'
        ), request());
    }

    public function ActividadesEconomicasUpdate($id)
    {
        return $this->update(Catalogos\ActividadEconomica::class, $id, array(
            'ACTIVIDAD_ECONOMICA' => 'actividad_economica'
        ), request());
    }

    public function ActividadesEconomicasDelete($id)
    {
        return $this->delete(Catalogos\ActividadEconomica::class, $id, request());
    }

    #TIPO DE EMPRESA
    public function TipoEmpresaAll()
    {
        return $this->getRecords(Catalogos\TipoEmpresa::class, [], [], '', request());
    }

    public function TipoEmpresaInsert()
    {
        return $this->insert(Catalogos\TipoEmpresa::class, array(
            'TIPO_EMPRESA' => 'tipo_empresa'
        ), request());
    }

    public function TipoEmpresaUpdate($id)
    {
        return $this->update(Catalogos\TipoEmpresa::class, $id, array(
            'TIPO_EMPRESA' => 'tipo_empresa'
        ), request());
    }

    public function TipoEmpresaDelete($id)
    {
        return $this->delete(Catalogos\TipoEmpresa::class, $id, request());
    }

    #SECTORES ECONOMICOS
    public function SectorEconomicoAll()
    {
        return $this->getRecords(Catalogos\SectorEconomico::class, [], [], '', request());
    }

    public function SectorEconomicoInsert()
    {
        return $this->insert(Catalogos\SectorEconomico::class, array(
            'SECTOR_ECONOMICO' => 'sector_economico',
            'DESCRIPCION' => 'descripcion',
            'IDENTIFICADOR' => 'identificador',
            'LOGO' => 'logo',
            'BANNER' => 'banner',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso',
        ), request());
    }

    public function SectorEconomicoUpdate($id)
    {
        return $this->update(Catalogos\SectorEconomico::class, $id, array(
            'SECTOR_ECONOMICO' => 'sector_economico',
            'DESCRIPCION' => 'descripcion',
            'IDENTIFICADOR' => 'identificador',
            'LOGO' => 'logo',
            'BANNER' => 'banner',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso',
        ), request());
    }

    public function SectorEconomicoDelete($id)
    {
        return $this->delete(Catalogos\SectorEconomico::class, $id, request());
    }

    #REGIONES
    public function RegionAll()
    {
        return $this->getRecords(Catalogos\Region::class, [], [], '', request());
    }

    public function RegionInsert()
    {
        return $this->insert(Catalogos\Region::class, array(
            'NOMBRE_REGION' => 'nombre_region'
        ), request());
    }

    public function RegionUpdate($id)
    {
        return $this->update(Catalogos\Region::class, $id, array(
            'NOMBRE_REGION' => 'nombre_region'
        ), request());
    }

    public function RegionDelete($id)
    {
        return $this->delete(Catalogos\Region::class, $id, request());
    }

    #SERVICIOS
    public function ServicioAll()
    {
        return $this->getRecords(Catalogos\Servicio::class, [], [], '', request());
    }

    public function ServicioInsert()
    {
        return $this->insert(Catalogos\Servicio::class, array(
            'NOMBRE_SERVICIO' => 'nombre',
            'DESCRIPCION' => 'descripcion',
            'LOGO' => 'logo',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso'
        ), request());
    }

    public function ServicioUpdate($id)
    {
        return $this->update(Catalogos\Servicio::class, $id, array(
            'NOMBRE_SERVICIO' => 'nombre',
            'DESCRIPCION' => 'descripcion',
            'LOGO' => 'logo',
            'ESTATUS' => 'estatus',
            'ACCESO' => 'acceso'
        ), request());
    }

    public function ServicioDelete($id)
    {
        return $this->delete(Catalogos\Servicio::class, $id, request());
    }


    /*MENU*/
    public function UpdateMenuPadre($id) {
        
       return $this->update(TB\Menu::class, $id, ['ID_MENU_PADRE' => 'MENU_PADRE' ], request());


    }
    public function MenuAll() {
        $data = [];
        $menu = TB\Menu::selectRaw( DB::raw("CODIGO_MENU AS id,ETIQUETA as label,1 as is_group,0 as draggable, 0 as droppable , ETIQUETA as data,'pi pi-folder-open' expandedIcon, 'pi pi-folder' as collapsedIcon, true as expanded"))
            ->where('ID_MENU_PADRE', '=', 0)
            ->get();
        foreach ( $menu as $value ) {
            $value['children'] = TB\Menu::selectRaw( DB::raw("CODIGO_MENU as id, 0 as is_group , 0 as droppable,ETIQUETA as label, ETIQUETA as data,'fa fa-file-o' expandedIcon, 'fa fa-file-o' as collapsedIcon"))
                ->where('ID_MENU_PADRE', '=',  $value['id'] )
                ->orderBy("DESCRIPCION", "ASC")
                ->get();
            array_push( $data, $value );
        }

        return $data;
    }
    public function MenuRolInsert($idrol) {
        $seleccionados =  json_decode( request()->input('seleccionados', '[]'), true);
        $quitados = json_decode( request()->input('quitados', '[]') , true);

        DB::beginTransaction();
        try {
            TB\MenuRol::whereIn('CODIGO_MENU', $quitados )
                ->where('CODIGO_ROL', '=', $idrol)
                ->delete();
            $arr =  array_map( function ($value) use ($idrol) {
                return  [ 'CODIGO_ROL' => $idrol, 'CODIGO_MENU' => $value ,'USUARIO_ADICION' => 'PRUEBAS'   ];
            }, $seleccionados );

            TB\MenuRol::insert( $arr );
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->log( $ex );
            return $this->respuesta( false, 'Fallo al actualizar menu' );
        }

        DB::commit();

       return $this->respuesta( true, 'Menu actualizado' );

    }

    /** dropdowns***/
    public function PaisesLista()
    {
        return $this->dropdownRecords(Catalogos\Pais::class, ['CODIGO_PAIS as id', 'NOMBRE_PAIS as descripcion'], "NOMBRE_PAIS", request());
    }

    public function IndicadorLista()
    {
        return $this->dropdownRecords(Catalogos\Indicador::class, ['CODIGO_INDICADOR as id', 'NOMBRE_INDICADOR as descripcion'], "NOMBRE_INDICADOR", request());
    }

    public function FuenteInformacionLista()
    {
        return $this->dropdownRecords(Catalogos\FuenteInformacion::class, ['CODIGO_FUENTE as id', 'FUENTE_INFORMACION as descripcion'], "FUENTE_INFORMACION", request());
    }

    public function GrupoIndicadoresLista()
    {
        return $this->dropdownRecords(Catalogos\GrupoIndicadores::class, ['CODIGO_GRUPO_IND as id', 'NOMBRE_GRUPO_IND as descripcion'], "NOMBRE_GRUPO_IND", request());
    }


    public function SectorEconomicoLista()
    {
        return $this->dropdownRecords(Catalogos\SectorEconomico::class, ['CODIGO_SECTOR as id', 'SECTOR_ECONOMICO as descripcion'], "SECTOR_ECONOMICO", request());
    }


    public function ProductoLista()
    {
        return $this->dropdownRecords(TB\Producto::class, ['CODIGO_PRODUCTO as id', 'NOMBRE_PRODUCTO as descripcion'], "NOMBRE_PRODUCTO", request());
    }

    public function ServicioLista()
    {
        return $this->dropdownRecords(Catalogos\Servicio::class, ['CODIGO_SERVICIO as id', 'NOMBRE_SERVICIO as descripcion'], "NOMBRE_SERVICIO", request());
    }

    public function GrupoLista()
    {
        return $this->dropdownRecords(TB\Grupo::class, ['CODIGO_GRUPO as id', 'NOMBRE_GRUPO as descripcion'], "NOMBRE_GRUPO", request());
    }


    public function DocumentoLista(  ) {
        return $this->dropdownRecords(TB\Documento::class, [ 'CODIGO_DOCUMENTO as id', 'DESCRIPCION_DOCUMENTO as descripcion'],"DESCRIPCION_DOCUMENTO", request());
    }




    /* Indicadores**/




    /*public function insert( $klass, $insertColumns, $request) {
        return parent::insert( $klass, $insertColumns, $request);
    }*/

    /*public function update($klass, $keyValue, $updateColumns, $request) {
        return parent::update($klass, $keyValue, $updateColumns, $request);
    }*/








}
