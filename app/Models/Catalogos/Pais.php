<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Pais extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_PAISES';
    protected $primaryKey = 'CODIGO_PAIS';
    protected $tablaDescripcion = "Pais";
    protected $filtroGeneral = ['NOMBRE_PAIS'];
    protected $fillable = ['NOMBRE_PAIS', 'SUPERFICIE', 'CODIGO_DIVISA','ISO2', 'ISO3', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_PAIS';

    /*public function getAuthIdentifierName()
    {
        return $this->CorreoVisitante;
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }*/

}
