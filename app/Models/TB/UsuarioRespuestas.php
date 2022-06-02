<?php

namespace App\Models\TB;

use Illuminate\Database\Eloquent\Model;
use \App\Models\BaseModel;
use App\Models\Catalogos\Pregunta;

class UsuarioRespuestas extends BaseModel
{
    public $incrementing = true;
    protected $table = 'TB_USUARIO_RESPUESTAS';
    protected $primaryKey = 'ID';
    protected $fillable = ['ID_USUARIO', 'ID_PREGUNTA', 'RESPUESTA', 'ID_FORMULARIO'];
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const KEY = 'ID';

    protected $casts = [
        'RESPUESTA' => 'array'
    ];

    public function usuario() {
        return $this->hasOne(Usuarios::class, "ID", "ID_USUARIO"  );
    }
    public function pregunta() {
        return $this->hasOne(Pregunta::class, 'ID', 'ID_PREGUNTA');
    }
}
