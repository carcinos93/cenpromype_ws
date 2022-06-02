<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends BaseModel
{
    public $incrementing = true;
    protected $table = 'CAT_PREGUNTAS';
    protected $primaryKey = 'ID';
    protected $filtroGeneral = ['PREGUNTA'];
    protected $no_duplicados = ['PREGUNTA','ID_FORMULARIO'];
    protected $fillable = ['PREGUNTA','TIPO', 'REQUERIDO','ORIGEN','VALOR', 'CAMPO_DEPENDE', 'ID_FORMULARIO', 'USUARIO_ADICION', 'FECHA_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';
}
