<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class TipoEmpresa extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_TIPO_EMPRESAS';
    protected $primaryKey = 'CODIGO_TIPO_EMPRESA';
    protected $fillable = ['TIPO_EMPRESA', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_TIPO_EMPRESA';

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
