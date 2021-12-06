<?php

namespace App\Models\TB;

use App\Models\BaseModel;
use App\Models\Catalogos\Servicio;
use Illuminate\Database\Eloquent\Model;


class DocumentoGrupo extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_GRUPOS_X_DOCUMENTO';
    protected $primaryKey = 'ID';
    protected $no_duplicados =['CODIGO_GRUPO', 'CODIGO_DOCUMENTO'];
    protected $fillable = ['CODIGO_GRUPO', 'CODIGO_DOCUMENTO','ESTATUS','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

}
