<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Documento extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_DOCUMENTOS';
    protected $primaryKey = 'CODIGO_DOCUMENTO';
    protected $fillable = ['CODIGO_SECTOR','VOLUMEN','FECHA_ACTUALIZACION','NOMBRE_DOCUMENTO', 'DESCRIPCION_DOCUMENTO', 'CODIGO_PRODUCTO', 'CONTENIDO', 'IMAGEN','RUTA_DOCUMENTO', 'ESTATUS', 'ACCESO','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_DOCUMENTO';
    public function documentoServicio() {
        return $this->hasMany(DocumentoServicio::class, 'CODIGO_DOCUMENTO', 'CODIGO_DOCUMENTO');
    }

}
