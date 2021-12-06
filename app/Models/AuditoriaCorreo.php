<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaCorreo extends Model {

    const UPDATED_AT = null;
    const CREATED_AT = "Fecha";

    public $incrementing = true;
    protected $table = 'auditoria_correo';
    protected $primaryKey = 'Id';
    protected $fillable = ['correoVisitante', 'correoDestino', 'contenidoCorreo','destinatario'];
}
