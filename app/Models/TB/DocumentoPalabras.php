<?php

namespace App\Models\TB;

use App\Models\BaseModel;
use App\Models\Catalogos\Servicio;
use Illuminate\Database\Eloquent\Model;


class DocumentoPalabras extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_PALABRAS_X_DOCUMENTO';
    protected $primaryKey = 'ID';
    protected $no_duplicados = ['CODIGO_DOCUMENTO', 'ID_CLAVE'];
    protected $fillable = ['CODIGO_DOCUMENTO','ESTATUS', 'ID_CLAVE','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

}
