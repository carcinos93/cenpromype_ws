<?php

namespace App\Http\Controllers;

use App\Helpers\Auth;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DateTime;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     public function default($array, $value  ) {
        return ( is_array( $array ) ? $array : $value );

    }

   /*
    * @var  $request
    */
   private function opConvert($value) {
       $whereOP = "";
        switch ($value) {
           case "eq":
                $whereOP = "=";
               break;
           case "lt":
               $whereOP = ">";
               break;
            case "lk":
                $whereOP = "LIKE";
                break;
           default:
                $whereOP = "=";
               break;
        }
           return $whereOP;
   }

   private function sorts($klass , array $sorts, array $opts  = [] ) {
       $sortOptions = [];

       if (array_key_exists( 'sort' , $opts )) {
           $sortOptions = $opts['sort'];
       }

       if (!empty($sorts)) {
            foreach ( $sorts as $key => $value ){
                $field = $value['field'];
                $tipoOrder = $value['order']; // 1 ascedente, -1 descente
                $columnaOrden = $field;
                $order = $tipoOrder == 1 ? "ASC" : "DESC";
                if (!empty($opts)) {
                    if ( array_key_exists( $field, $opts )   ) {
                        $columnaOrden = $opts[ $field ];
                    }
                }
                $klass = $klass->orderBy( $columnaOrden, $order );
            }
       }
       return $klass;
   }

    /**
     * Funcion que retorna la consulta con las condiciones enviadas
     * @param BaseModel $klass
     * @param $filters
     * @return mixed
     */
   private function conditions( $klass, $filters, $opts = [] ) {

       $filtroGeneral = $klass->getFiltroGeneral();

       if (!empty( $filters )) {
           foreach ($filters as $key => $value) {

               $col = $value['col'];
               $op = $this->opConvert($value['op']);
               $v = $value['value'];

               if ($col == "GENERAL")
               {
                   if (! empty( $filtroGeneral ) ) {
                       $klass = $klass->whereRaw( "(CONCAT(`" . implode( '`,`' , $filtroGeneral ) . "`) LIKE ?) collate utf8_general_ci" , [  "%$v%" ] );
                   }

               } else
               {
                   $klass = $klass->where($col, $op,  $v);
               }


           }
       }
       return $klass;
   }

    /**
     * @param Model $klass Modelo de datos
     * @param $columns
     * @param array $joins
     * @param $orderBy
     * @param $request
     * @return array
     */
   public function getRecords($klass, $columns, $joins = [], $orderBy, $request, $opt = []) {

       $columnasString = '';
       #condicion
       $totalQuery = new $klass();
       $filtersStr = $request->get('filters',  '[]');
       $sortStr = $request->get('sorts', '[]');
       $filters = json_decode($filtersStr, true);
       $sorts  = json_decode($sortStr, true);

       $total = $this->conditions($totalQuery, $filters)->count();
       if ( empty( $columns ) ) {
           $columnasString = "*";
       } else {
           $columnasString = implode(",", $columns);
       }
       $consulta = new $klass();
       $consulta =  $this->conditions($consulta, $filters);
       if (!empty($joins)) {
           foreach ($joins as $key => $value) {
               $tipounion = $value[0];
               if ($tipounion == 'join') {
                   $consulta = $consulta->join( $value[1], $value[2], $value[3], $value[4] );
               } else if ($tipounion == 'right') {
                   $consulta = $consulta->rightJoin($value[1], $value[2],  $value[3], $value[4] );
               } else if ($tipounion == 'left') {
                   $consulta = $consulta->leftJoin( $value[1], $value[2],  $value[3], $value[4]  );
               }
           }
       }

       $consulta = $this->sorts($consulta,$sorts, $opt);
       $first = $request->input('first', 0);
       $rows =  $request->input('rows', 10);

       $first = $first == "null" ? 0 : $first;
       $rows = $rows == "null" ? 10 : $rows;

       $data = $consulta->select(DB::raw( $columnasString ))->skip( $first )->take( $rows );
      // $query = $consulta->select(DB::raw( $columnasString ))->skip( $request->get('first', 0) )->take( $request->get('rows', 5) )->toSql();
       return [ 'total' => $total, 'data' => $data->get()];
   }



   public function dropdownRecords($klass, $columns, $orderBy, $request) {
       return $klass::orderBy($orderBy, 'ASC')->select($columns[0], $columns[1])->get();
   }

    /**
     * @param Model $klass Modelo de datos
     * @param $insertColumns
     * @param Request $request objeto Request
     * @return array|null
     */
    public function insert($klass, $insertColumns , Request $request, array $opts = [] ) {
        $dataInsert = [];
        $__id = $request->input('__id');
        try {

            foreach ($insertColumns as $key => $value) {
                $dataInsert[ $key ] = $request->input(  $value );

                if ($request->hasFile( $value . "_file" )) {
                    $this->uploadFiles( $dataInsert,$key, $request->file($value . "_file"), $opts, $__id );
                }
                $dataInsert[ 'USUARIO_ADICION' ] = $this->getUserName();
            }
            $validacionDuplicados = $this->ValidarDuplicados( $klass, $dataInsert, true);

            if ($validacionDuplicados['valid'] == true) {
                $result = $klass::create( $dataInsert );
                if ($result) {
                    return $this->respuesta(true, 'Registro guardado', ['data' => $result ]);
                    //return ['success' => true, 'message' => ];
                }
            } else {
                return $this->respuesta(false,'El registro ya existe' );
            }
            return $result;
        } catch (\Exception $ex) {
            //echo $exc->getMessage();
            // logger('Fallo en insert');
            $this->log( $ex );
            return $this->respuesta(false,'Hubo un fallo al insertar registro ' );

        }
    }

   /**
    * Funcion de actualizacion de registros
    * @param Model $klass Modelo de datos
    * @param object $keyValue valor del registro
    * @param array $updateColumns columnas a actualizar
    * @param Request $request objeto Request
    * @return array
    */
   public function update($klass, $keyValue, array $updateColumns, Request $request, array $opts = []) {
          $dataUpdate = [];
          $__id = $request->input('__id');
       try {
            foreach ($updateColumns as $key => $value) {
           //var_dump();
           $dataUpdate[ $key ] = $request->input(  $value );
           $dataUpdate[ 'USUARIO_MODIFICACION' ] = $this->getUserName();

           if ($request->hasFile( $value . "_file" )) {
               $this->uploadFiles( $dataInsert,$key, $request->file($value . "_file"), $opts, $__id );
           }

        }
           $validacionDuplicados = $this->ValidarDuplicados( $klass, $dataUpdate, false, $keyValue );
            if ($validacionDuplicados['valid']) {
                $updated = $klass::where( $klass::KEY , '=',$keyValue)->update($dataUpdate);
                if ($updated) {
                    return ['success' => true, 'message' => 'Registro actualizado', 'validacion' => $validacionDuplicados];
                } else {
                    return ['success' => false, 'message' => 'El registro no se actualizo'];
                }
            } else {
                return ['success' => false, 'message' => 'El registro ya existe'];
            }

            //return $updated;
       } catch (\Exception $ex) {
           $this->log( $ex );
           return ['success' => false, 'message' => 'Hubo un fallo al actualizar registro'];
       }


   }

    /**
     * @param BaseModel $klass
     * @param array $values
     * @param false $isNew
     * @param null $id
     */
    public function ValidarDuplicados($klass,array $values, $isNew = false, $id = null) {
        $k = new $klass();
        $duplicados = $k->getNoDuplicados();
        $where = "";
          if (empty($duplicados)) {
              return ['valid' => true ];
          } else  {
              /** SE FILTRA EL ARREGLO DE DATOS, SEGUN LOS CAMPOS CONFIGURADOS**/
              $valoresFiltrados = array_filter( $values, function ($key) use ($duplicados) {
                    return in_array( $key, $duplicados  );
              }, ARRAY_FILTER_USE_KEY  );

              /**SE GENERA LA CONSULTA DINAMICA, NO SE PASAN VALORES **/
              $where = implode(" " ,(array_map( function ($key) {
                    return  "AND `$key` = ?";
              }, array_keys($valoresFiltrados) )));
              /**SE EXTRAEN LOS VALORES**/
              $valoresNuevos =   array_values( $valoresFiltrados );
              /**SE AGREGA EL VALOR SEL REGISTRO POR ULTIMO**/

              /**Si el registro es una actualizacion, se agrega la condicion del id
               para que este no sea tomado en cuenta **/
              if (!$isNew) {
                  array_push( $valoresNuevos, $id);
                  $where.=" AND `" . $k->getKeyName() . "` <>  ?";
              }
              /**
                condicion resultante: 1 = 1 AND [CAMPO1] = ? AND [CAMPO10] = ? .... [ID] <> ?
               * el orden es importante, en laravel para parametros no usan nombres sino signo ?, asi
               * que los valores y las signos deben ir en orden
               ***/
              /* 1 = 1 se agrega para evitar problema con los 'AND'  agregados luego **/
              $k =  $k->whereRaw( "1 = 1 " . $where    , $valoresNuevos );
              $total = $k->count();
              if ($total > 0) {
                  return ['valid' => false, 'message' => 'Registro duplicado'];
              } else {
                  return ['valid' => true];
              }

          }

    }


    /**
     * @param Model $klass
     * @param $id
     * @param Request $request
     * @param array $opts
     */
   public function delete($klass, $id, Request  $request, array $opts = []) {
       try {
           $klass::find( $id )->delete();
           return $this->respuesta(true, 'Registro borrado');
       } catch (\Exception $ex)
       {
           $this->log( $ex );
           return $this->respuesta(false, 'Hubo un fallo al borrar registro ');
       }


   }

    /**
     * Funcion que sube un archivo al directorio
     * @param $data
     * @param $key
     * @param $file \Illuminate\Http\UploadedFile
     * @param array $opts
     * @param null $__id
     * @return array|string[]
     */
   public function uploadFiles(&$data, $key ,$file, array $opts = [] , $__id = null ) {
       try {
           $ruta = config('sistema.uploads.path');
           if (array_key_exists('folderUpload', $opts)) {
               $ruta = $opts['folderUpload'];
           }
           //$file = $request->file($value . "_file");
           $info  = pathinfo( $file->getClientOriginalName());
           $nombreArchivo =  $info['filename'] . "_" . ($__id == null ? (new DateTime())->format("Ymd_His") : $__id)   .".".  $info['extension'];
           $archivo = "$ruta/$nombreArchivo";
           $data[$key] ="./$archivo";
           Storage::disk( config('sistema.uploads.storage') )->put($archivo, $file->get() );
           return [ "status" => "ok" ];
       } catch  (\Exception $ex) {
            $this->log( $ex );
           return ["status" => false, "message" => "Falla en la carga de imagen"];

       }

   }

   protected function respuesta( $success, $message, $extra = [] ) {
       $resp = [];
       $resp['success'] = $success;
       $resp['message'] = $message;
       if ( !empty ($extra ) ) {
           foreach ( $extra as $key => $value  ) {
               if ($key == '_root_') {
                   foreach ( $value as $key1 => $value1 ) {
                       $resp[$key1] = $value1;
                   }
               } else
               {
                   $resp[$key] = $value;
               }
           }
       }
       return $resp;
   }

   private function getUserName() {
       $token = request()->header('X-Authorization');
       if (Auth::Check($token)) {
           $data = Auth::GetData($token);
           return $data->NOMBRE_USUARIO;
       }
       return null;
   }

   protected function log(\Exception $ex) {
       logger('archivo: ' . $ex->getFile() . ', linea: ' . $ex->getLine() . ',error: ' . $ex->getMessage() );
   }
}
