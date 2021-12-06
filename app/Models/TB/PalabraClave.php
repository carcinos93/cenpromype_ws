<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class PalabraClave extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_PALABRAS_CLAVE';
    protected $primaryKey = 'ID_CLAVE';
    protected $fillable = ['PALABRA_CLAVE', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID_CLAVE';

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
