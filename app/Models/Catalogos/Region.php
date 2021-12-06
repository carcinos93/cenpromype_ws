<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Region extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_REGIONES';
    protected $primaryKey = 'CODIGO_REGION';
    protected $fillable = ['NOMBRE_REGION', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_REGION';

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
