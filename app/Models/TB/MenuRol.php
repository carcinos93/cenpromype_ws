<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuRol extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_MENU_ROLES';
    protected $primaryKey = 'ID';
    protected $fillable = ['CODIGO_ROL', 'CODIGO_MENU','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';


}
