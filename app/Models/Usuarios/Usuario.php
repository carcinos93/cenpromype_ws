<?php

namespace App\Models\Usuarios;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
class Usuario extends BaseModel
{

    public $incrementing = true;
    protected $table = 'CAT_USUARIOS';
    protected $primaryKey = 'CODIGO_USUARIO';
    protected $no_duplicados = [ 'CORREO_ELECTRONICO' ];
    protected $fillable = ['NOMBRE_USUARIO', 'CONTRASENIA'.'CORREO_ELECTRONICO', 'ESTADO', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_USUARIO';

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
