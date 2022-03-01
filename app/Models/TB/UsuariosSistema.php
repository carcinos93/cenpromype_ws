<?php

namespace App\Models\TB;

use \App\Models\BaseModel;

class UsuariosSistema extends BaseModel
{
    public $incrementing = true;
    protected $table = 'TB_USUARIOS_SISTEMA';
    protected $primaryKey = 'ID';
    protected $fillable = ['USUARIO', 'NOMBRES','APELLIDOS', 'GENERO', 
                            'ANIO_NAC', 'PAIS_RESIDENCIA','CODIGO_TIPO_INST',
                            'NOMBRE_INSTITUCION','TAMANIO_EMPRESA','CODIGO_SEC_EMP', 'CODIGO_ACT',
                            'CORREO_ELECTRONICO','CONTRASENIA','RECIBE_NOTIFICACION',
                            'ESTADO', 'ACCESO', 'USUARIO_ADICION', 'FECHA_ADICION'];
    const CREATED_AT = 'FECHA_ADICION';
    const UPDATED_AT = 'FECHA_MODIFICACION';
    const KEY = 'ID';
    const INACTIVO = 0;
    const ACCESO = '00';
    
    protected $attributes = [
        'ESTADO' => self::INACTIVO,
        'ACCESO' => self::ACCESO
    ];
}
