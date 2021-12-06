<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Indicador extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_INDICADORES';
    protected $primaryKey = 'CODIGO_INDICADOR';
    protected $fillable = ['NOMBRE_INDICADOR', 'UNIDAD_MEDIDA', 'CODIGO_GRUPO_IND', 'ETIQUETA1', 'ETIQUETA2', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_INDICADOR';
    /*public function getAuthIdentifierName()
    {
        return $this->CorreoVisitante;
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }*/

}
