<?php

namespace App\Models\Usuarios;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Rol extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_ROLES';
    protected $primaryKey = 'CODIGO_ROL';
    protected $no_duplicados = [ 'NOMBRE_ROL'];
    protected $filtroGeneral = ['NOMBRE_ROL'];
    protected $fillable = ['NOMBRE_ROL', 'ESTADO', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_ROL';

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
