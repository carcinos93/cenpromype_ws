<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Servicio extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_SERVICIOS';
    protected $primaryKey = 'CODIGO_SERVICIO';
    protected $fillable = ['NOMBRE_SERVICIO', 'DESCRIPCION', 'LOGO','ESTATUS', 'ACCESO', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_SERVICIO';



    /*public function getAuthIdentifierName()
    {
        return $this->CorreoVisitante;
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }*/

}
