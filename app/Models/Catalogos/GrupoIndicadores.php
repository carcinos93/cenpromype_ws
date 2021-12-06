<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class GrupoIndicadores extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_GRUPO_INDICADORES';
    protected $primaryKey = 'CODIGO_GRUPO_IND';
    protected $fillable = ['NOMBRE_GRUPO_IND', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_GRUPO_IND';
    /*public function getAuthIdentifierName()
    {
        return $this->CorreoVisitante;
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }*/

}
