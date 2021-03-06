<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class UsuarioController extends Controller {

    #USUARIOS
       public function UsuarioAll(  ) {
        return $this->getRecords(\App\Models\Usuarios\Usuario::class, [], [], '', request());
    }
    public function UsuarioInsert(  ) {
        
        $d = [];  
         if (Models\Usuarios\Usuario::where('NOMBRE_USUARIO', '=', request()->input('nombre'))->exists() ) {
             array_push( $d, "nombre usuario ya existe" );
         }
         
         if (Models\Usuarios\Usuario::where('CORREO_ELECTRONICO', '=', request()->input('correo'))->exists() ) {
             array_push( $d, "correo electronico ya existe" );
         }
         
         if (!empty( $d )) {
             return $this->respuesta(false, implode(", ", $d));
         }
         
         return $this->insert(\App\Models\Usuarios\Usuario::class, array(
                'NOMBRE_USUARIO' => 'nombre',
                'CONTRASENIA' => 'password',
                'CORREO_ELECTRONICO' => 'correo',
                'ESTADO' => 'estado'
            ), request());
    }
     public function UsuarioUpdate( $id ) {
          $d = [];  
         if (Models\Usuarios\Usuario::where('NOMBRE_USUARIO', '=', request()->input('nombre'))->where('CODIGO_USUARIO', '<>', $id)->exists() ) {
             array_push( $d, "nombre usuario ya existe" );
         }
         
         if (Models\Usuarios\Usuario::where('CORREO_ELECTRONICO', '=', request()->input('correo'))->where('CODIGO_USUARIO', '<>', $id)->exists() ) {
             array_push( $d, "correo electronico ya existe" );
         }
         
         if (!empty( $d )) {
             return $this->respuesta(fase, implode(", ", $d));
         }
         return $this->update(\App\Models\Usuarios\Usuario::class, $id, array(
                'NOMBRE_USUARIO' => 'nombre',
                'CORREO_ELECTRONICO' => 'correo',
                'ESTADO' => 'estado'
            ), request());
    }

    public function ActualizarPassword( $id ) {
         return $this->update(\App\Models\Catalogos\Rol::class, $id, array(
                'CONTRASENIA' => 'password'
            ), request());
    }

   #ROLES
     public function RolAll(  ) {
        return $this->getRecords(\App\Models\Usuarios\Rol::class, [], [], '', request());
    }
    public function RolInsert(  ) {
         return $this->insert(\App\Models\Usuarios\Rol::class, array(
                'NOMBRE_ROL' => 'nombre',
                'ESTADO' => 'estatus'
            ), request());
    }
     public function RolUpdate( $id ) {
         return $this->update(\App\Models\Usuarios\Rol::class, $id, array(
                'NOMBRE_ROL' => 'nombre',
                'ESTADO' => 'estatus'
            ), request());
    }

    #ROLES X USUARIOS
    public function UsuarioRolAll(  ) {
        return $this->getRecords(\App\Models\Usuarios\UsuarioRol::class,  array(
            'TB_ROLES_X_USUARIO.*',
            'CAT_ROLES.NOMBRE_ROL'),
            array(
                ['left', 'CAT_ROLES', 'CAT_ROLES.CODIGO_ROL', '=', 'TB_ROLES_X_USUARIO.CODIGO_ROL']
            ), '', request());
    }
    public function UsuarioRolInsert(  ) {
        return $this->insert(\App\Models\Usuarios\UsuarioRol::class, array(
            'CODIGO_USUARIO' => 'CODIGO_USUARIO',
            'CODIGO_ROL' => 'CODIGO_ROL'
        ), request());
    }
    public function UsuarioRolUpdate( $id ) {
        return $this->update(\App\Models\Usuarios\UsuarioRol::class, $id, array(
            'CODIGO_USUARIO' => 'CODIGO_USUARIO',
            'CODIGO_ROL' => 'CODIGO_ROL'
        ), request());
    }

    public function UsuarioRolDelete( $id ) {
        return $this->delete(\App\Models\Usuarios\UsuarioRol::class, $id, request());
    }





}
