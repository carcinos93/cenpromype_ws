<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class ActividadEconomica extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_ACTIVIDADES_ECONOMICAS';
    protected $primaryKey = 'CODIGO_ACTIVIDAD';
    protected $fillable = ['ACTIVIDAD_ECONOMICA', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_ACTIVIDAD';

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
