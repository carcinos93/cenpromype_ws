<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Departamento extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_DEPARTAMENTOS';
    protected $primaryKey = 'CODIGO_DEPARTAMENTO';
    protected $filtroGeneral = ['NOMBRE_DEPARTAMENTO'];
    protected $no_duplicados = ['NOMBRE_DEPARTAMENTO', 'CODIGO_PAIS'];
    protected $fillable = ['NOMBRE_DEPARTAMENTO','CODIGO_PAIS', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_DEPARTAMENTO';

    /*public function pais() {
        return $this->hasOne('\App\Models\Catalogos\Pais', '');
    }*/

    /*public function getAuthIdentifierName()
    {
        return $this->CorreoVisitante;
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }*/

}
