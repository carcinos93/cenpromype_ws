<?php

namespace App\Models\TB;
use App\Models\BaseModel;

class Documento extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_AUDITORIA_USUARIOS';
    protected $primaryKey = 'ID';
    protected $fillable = ['USUARIO', 'URL', 'IP', 'PAGINA', 'NAVEGADOR','METADATA','FECHA_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = null;
    const KEY = 'ID';
    

}
