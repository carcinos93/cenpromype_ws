<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Grupo extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_GRUPOS';
    protected $primaryKey = 'CODIGO_GRUPO';
    protected $fillable = ['NOMBRE_GRUPO','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_GRUPO';

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
