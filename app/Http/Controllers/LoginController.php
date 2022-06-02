<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Helpers\Auth;

class LoginController extends Controller {

    public function login() {
       $nombre_usuario = request()->input("usuario");
       $password = request()->input("password");
       $usuario = Models\Usuarios\Usuario::where('NOMBRE_USUARIO', '=', $nombre_usuario)->where('CONTRASENIA', '=', $password)->first();
        if ($usuario == null) {
            return $this->respuesta(false, "mensajes.usuario_novalido");
        } else {
            $id = $usuario->CODIGO_USUARIO;
            $correo = $usuario->CORREO_ELECTRONICO;
            $nombre = $usuario->NOMBRE_USUARIO;
            $token = \App\Helpers\Auth::SignIn([
                    'CODIGO_USUARIO' => $id,
                    'CORREO' => $correo,
                    'NOMBRE_USUARIO' => $nombre]);
            return $this->respuesta(true, 'ok', array(
                '_root_' => array( 'token' => $token )
            ));
        }
    }

    public function MenuUsuario() {
        $token = request()->header('X-Authorization');
        $data = Auth::GetData($token);
        $rolesUsuario = Models\Usuarios\UsuarioRol::where('CODIGO_USUARIO', 1)->get();
        $menuPadre = Models\TB\Menu::where('ID_MENU_PADRE','=', 0)
        ->whereExists(function ($q) use ($data) {
            $q->select(DB::raw(1))
                ->from('TB_MENU_DEFINICION', 'T1')
                ->whereColumn('T1.ID_MENU_PADRE', 'TB_MENU_DEFINICION.CODIGO_MENU')
                ->whereExists( function ($q1) use ($data) {
                    $q1->select(DB::raw(1))
                        ->from('TB_MENU_ROLES','T2')
                        ->whereColumn('T1.CODIGO_MENU', 'T2.CODIGO_MENU' )
                        ->whereExists( function ($q2) use ($data) {
                            $q2->select(DB::raw(1))
                                ->from('TB_ROLES_X_USUARIO','T3')
                                ->where('T3.CODIGO_USUARIO','=', $data->CODIGO_USUARIO )
                                ->whereColumn('T3.CODIGO_ROL','T2.CODIGO_ROL');
                        }  );
                });
        })->get();

        foreach ( $menuPadre as $k1 => $v1 ) {
            $v1['SUBMENU'] = Models\TB\Menu::where('ID_MENU_PADRE', '=', $v1['CODIGO_MENU'])
            ->whereExists( function ($q1) use ($data) {
                $q1->select(DB::raw(1))
                    ->from('TB_MENU_ROLES','T2')
                    ->whereColumn('TB_MENU_DEFINICION.CODIGO_MENU', 'T2.CODIGO_MENU' )
                    ->whereExists( function ($q2) use ($data) {
                        $q2->select(DB::raw(1))
                            ->from('TB_ROLES_X_USUARIO','T3')
                            ->where('T3.CODIGO_USUARIO','=', $data->CODIGO_USUARIO )
                            ->whereColumn('T3.CODIGO_ROL','T2.CODIGO_ROL');
                    }  );
            } )->orderBy("DESCRIPCION", "ASC")->get();
        }

        return $menuPadre;



        //Models\Usuarios\UsuarioRol::where('CODIGO_USUARIO', '=', );

    }

}
