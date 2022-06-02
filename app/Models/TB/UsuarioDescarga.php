<?php

namespace App\Models\TB;

use Illuminate\Database\Eloquent\Model;
use \App\Models\BaseModel;

class UsuarioDescarga extends BaseModel
{
    public $incrementing = true;
    protected $table = 'TB_USUARIO_DESCARGA';
    protected $primaryKey = 'ID';
    protected $fillable = ['DOCUMENTO', 'ID_USUARIO', 'FECHA_CREACION'];
    const CREATED_AT = 'FECHA_CREACION';
    const UPDATED_AT = null;
    const KEY = 'ID';
    

    public function usuario() {
        return $this->hasOne(Usuarios::class, "ID", "ID_USUARIO"  );
    }
}
