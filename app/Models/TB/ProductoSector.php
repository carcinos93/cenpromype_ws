<?php

namespace App\Models\TB;

use App\Models\BaseModel;
use App\Models\Catalogos\Servicio;
use Illuminate\Database\Eloquent\Model;


class ProductoSector extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_PRODUCTOS_X_SECTORES';
    protected $primaryKey = 'ID';
    protected $no_duplicados = ['CODIGO_PRODUCTO', 'CODIGO_SECTOR'];
    protected $fillable = ['CODIGO_PRODUCTO','ESTATUS', 'CODIGO_SECTOR','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

}
