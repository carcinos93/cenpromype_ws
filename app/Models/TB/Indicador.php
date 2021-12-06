<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Indicador extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_INDICADORES';
    protected $primaryKey = 'CODIGO_FUENTE';
    protected $fillable = ['CODIGO_PAIS', 'CODIGO_INDICADOR', 'ANIO', 'VALOR1', 'VALOR2','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_FUENTE';

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
