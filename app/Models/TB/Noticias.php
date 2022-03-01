<?php

namespace App\Models\TB;



class Noticias extends \App\Models\BaseModel
{
    public $incrementing = true;
    protected $table = 'TB_NOTICIAS';
    protected $primaryKey = 'ID';
    protected $tablaDescripcion = "Noticias";
    protected $filtroGeneral = [];
    protected $fillable = ['TITULO', 'URL', 'CONTENIDO', 'IMAGEN', 'CACHEID', 'FECHA_PUBLICACION', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

}
