<?php

namespace App\Models\TB;

use Illuminate\Database\Eloquent\Model;
use \App\Models\BaseModel;
class Usuarios extends BaseModel
{
    public $incrementing = true;
    protected $table = 'TB_USUARIOS';
    protected $primaryKey = 'ID';
    protected $fillable = ['NOMBRES', 'APELLIDOS' ,'PAIS', 'CORREO', 'PASSWORD', 'ACTIVO', 'FORMULARIOS'];
    const CREATED_AT = 'FECHA_CREACION';
    const UPDATED_AT = null;
    const KEY = 'ID';

    public function respuestas() {
        return $this->hasMany(UsuarioRespuestas::class, "ID_USUARIO", "ID"  );
    }
}
