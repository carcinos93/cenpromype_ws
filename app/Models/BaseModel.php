<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BaseModel extends Model
{
    protected $tablaDescripcion;
    protected $filtroGeneral = [];
    protected $no_duplicados = [];
    public function getFiltroGeneral() {
        return $this->filtroGeneral;
    }

    public function getNoDuplicados() {
        return $this->no_duplicados;
    }
}
