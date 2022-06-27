<?php

namespace App\Models\Catalogos;


use App\Models\BaseModel;
class PortalNoticias extends BaseModel
{
    public $incrementing = true;
    protected $table = 'CAT_PORTAL_NOTICIAS';
    protected $primaryKey = 'ID';
    protected $tablaDescripcion = "Portal de noticias";
    protected $filtroGeneral = ['NOMBRE', 'URL'];
    protected $fillable = ['NOMBRE', 'URL', 'ID_BUSCADOR','REGION','PALABRAS_CLAVES', 'ID_PAIS', 'FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';

    protected $casts = [
        'PALABRAS_CLAVES' => 'array',
        'URL' => 'array'
    ];

}
