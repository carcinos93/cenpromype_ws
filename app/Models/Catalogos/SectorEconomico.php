<?php

namespace App\Models\Catalogos;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;


class SectorEconomico extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_SECTORES_ECONOMICOS';
    protected $primaryKey = 'CODIGO_SECTOR';
    protected $fillable = ['SECTOR_ECONOMICO','DESCRIPCION','IDENTIFICADOR', 'LOGO', 'ESTATUS','ACCESO', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_SECTOR';

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
