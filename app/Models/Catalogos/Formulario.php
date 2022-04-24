<?php

namespace App\Models\Catalogos;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Formulario extends BaseModel
{
    public $incrementing = true;
    protected $table = 'CAT_FORMULARIO';
    protected $primaryKey = 'ID';
    protected $filtroGeneral = ['TITULO'];
    protected $no_duplicados = ['TITULO'];
    protected $fillable = ['TITULO','CAMPO_DEPENDE', 'VALOR_DEPENDE', 'USUARIO_ADICION', 'FECHA_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

    public function preguntas() {
        return $this->hasMany( Pregunta::class, "ID_FORMULARIO", "ID" );
    }

}
