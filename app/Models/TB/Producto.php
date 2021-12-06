<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Producto extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_PRODUCTOS';
    protected $primaryKey = 'CODIGO_PRODUCTO';
    protected $fillable = ['CODIGO_SECTOR', 'NOMBRE_PRODUCTO','ESTATUS', 'LOGO', 'ACCESO', 'VALOR2','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_PRODUCTO';

    /*public function pais() {
        return $this->hasOne('\App\Models\Catalogos\Pais', '');
    }*/

    /*public function getAuthIdentifierName()
    {
        return $this->CorreoVisitante;
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }*/

}
