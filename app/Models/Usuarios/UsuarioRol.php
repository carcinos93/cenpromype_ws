<?php

namespace App\Models\Usuarios;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioRol extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_ROLES_X_USUARIO';
    protected $no_duplicados = ['CODIGO_USUARIO', 'CODIGO_ROL'];
    protected $primaryKey = 'ID';
    protected $fillable = ['CODIGO_USUARIO', 'CODIGO_ROL','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';


}
