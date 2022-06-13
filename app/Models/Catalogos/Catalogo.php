<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
class Catalogo extends BaseModel
{
    public $incrementing = true;
    protected $table = 'CAT_CATALOGO';
    protected $primaryKey = 'ID';
    protected $filtroGeneral = ['DESCRIPCION'];
    protected $no_duplicados = ['DESCRIPCION', 'TIPO_CATALOGO'];
    protected $fillable = ['DESCRIPCION','TIPO_CATALOGO', 'NIVEL', 'CATALOGO_PADRE', 'HABILITAR_ENTRADA']; // 'USUARIO_ADICION', 'FECHA_ADICION'
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const KEY = 'ID';

    public function items() {
        return $this->hasMany(Catalogo::class, "CATALOGO_PADRE", "ID"  );
    }

}
