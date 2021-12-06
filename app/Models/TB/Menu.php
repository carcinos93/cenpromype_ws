<?php

namespace App\Models\TB;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends BaseModel
{

    public $incrementing = true;
    protected $table = 'TB_MENU_DEFINICION';
    protected $primaryKey = 'CODIGO_MENU';
    protected $fillable = ['ETIQUETA', 'DESCRIPCION', 'ID_MENU_PADRE', 'URL','FECHA_ADICION', 'USUARIO_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'CODIGO_MENU';

   /* public function children() {
        return $this->hasMany(Menu::class, 'ID_MENU_PADRE', 'CODIGO_MENU')
            //->where('ID_MENU_PADRE','<>', 0);
            ->selectRaw( "CODIGO_MENU as id,ETIQUETA as label, DESCRIPCION as data,'fa fa-file-o' expandedIcon, 'fa fa-file-o' as collapsedIcon")
            ->get();
    }*/
/*
    public function parent() {
        return $this->belongsTo(Menu::class, 'ID_MENU_PADRE')->where('ID_MENU_PADRE', '=', 0);
    }*/
    /*public function pais() {
        return $this->hasOne('\App\Models\CatalogoSs\Pais', '');
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
