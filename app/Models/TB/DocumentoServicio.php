<?php

namespace App\Models\TB;

use App\Models\BaseModel;
use App\Models\Catalogos\Servicio;
use Illuminate\Database\Eloquent\Model;


class DocumentoServicio extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_DOCUMENTOS_X_SERVICIO';
    protected $primaryKey = 'ID';
    protected $no_duplicados =['CODIGO_SERVICIO', 'CODIGO_DOCUMENTO'];
    protected $fillable = ['CODIGO_SERVICIO', 'CODIGO_DOCUMENTO', 'ESTATUS','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

    public function documento() {
        return $this->hasOne( Documento::class, 'CODIGO_DOCUMENTO', 'CODIGO_DOCUMENTO' );
    }

    public function servicio() {
        return $this->hasOne( Servicio::class, 'CODIGO_SERVICIO', 'CODIGO_SERVICIO' );
    }

}
