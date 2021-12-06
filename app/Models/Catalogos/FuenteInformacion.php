<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class FuenteInformacion extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_FUENTE_INFORMACION';
    protected $primaryKey = 'CODIGO_FUENTE';
    protected $fillable = ['FUENTE_INFORMACION', 'FECHA_ADICION', 'USUARIO_ADICION'];
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
