<?php

namespace App\Http\Controllers;

use App\Helpers\Auth;
use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class PortalController extends Controller {
    
    public function confirmar() {
        $token = request()->get('t');
        $idioma = request()->get('lang' ,'es');
        if (!\App\Helpers\Auth::Check($token)) {
            return view('expiracion.expiracion', ['respuesta' => '¡URL ha expirado!']);
        } else {
            $data = \App\Helpers\Auth::GetData($token);
            $id = $data->ID;
            if (Models\TB\UsuariosSistema::where('ID', '=', $id)->where('ESTADO', '=', 1)->first() ) {
                return view('expiracion.expiracion', ['respuesta' => '¡URL ha expirado!']);
            }
         
            $updated = Models\TB\UsuariosSistema::where('ID', '=', $id)->update([ 'ESTADO' => 1 ]);
            return view('confirmar.confirmar', ['url' => env('APP_PORTAL'), 'respuesta' => "¡Cuenta confirmada!" ]);
        }
    }
    
    public function existeUsuario() {
        $usuario = request()->get('usuario');
        $q = Models\TB\UsuariosSistema::where('USUARIO', '=', $usuario);
        if ($q->exists()) {
            $usr = $q->first();
            $tiempo = (60 * 60 * 24 * 14); # dos semanas
            $token = Auth::Token( $usr , $tiempo );
           return array('existe' => 1, 'usuario' =>  $usr , 'token' => $token);
        } 
        return [ 'existe' => 0, 'usuario' => null, 'token' => null ];
    }
    public function registro() {
        
        $idioma = request()->get('lang', 'es');
        
        $nombre = request()->input('nombre');
        $apellido = request()->input('apellido');
        $usuario = request()->input('usuario');
        $correo = request()->input('correo');
        
        $validacion = Validator::make(request()->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => ['required',  \Illuminate\Validation\Rule::unique('TB_USUARIOS_SISTEMA', 'CORREO_ELECTRONICO')],
            'pais_residencia' => 'required',
            'sexo' => 'required',
            'tipo_institucion' => 'required',
            'recaptcha' => ['required', new \App\Rules\Recaptcha( request() )],
            'usuario' => [ 
                'required',
                \Illuminate\Validation\Rule::unique('TB_USUARIOS_SISTEMA', 'USUARIO')
            ]
        ], [
            'nombre.required' => "Nombre es requerido",
            'apellido.required' => "Apellido es requerido",
            "usuario.unique" => "El usuario $usuario esta en uso",
            "correo.unique" => "El correo $correo esta en uso"
        ]);
        if ( $validacion->fails()) {
            $errores = "";
            foreach ($validacion->errors()->all() as $v) {
                $errores.="$v\r\n";
            }
            return $this->respuesta(false, "Fallo de validacion: \r\n" . $errores );           
        }
        $nombre_completo = "$nombre $apellido";
        
            try {
                         $resp = $this->insert(Models\TB\UsuariosSistema::class  , [
                             'USUARIO' => 'usuario',
                             'NOMBRES' => 'nombre',
                             'APELLIDOS' => 'apellido',
                             'GENERO' => 'sexo',
                             'ANIO_NAC' => 'anio',
                             'PAIS_RESIDENCIA' => 'pais_residencia',
                             'CODIGO_TIPO_INST' => 'tipo_institucion',
                             'NOMBRE_INSTITUCION' => 'nombre_institucion',
                             'TAMANIO_EMPRESA' => 'empresa_tamanyo',
                             'CODIGO_ACT' => 'actividad_economica',
                             'CORREO_ELECTRONICO' => 'correo',
                             'CONTRASENIA' => 'password',
                             'RECIBE_NOTIFICACION' => 'recibirBoletin'
                         ], request());
                         
                        
                         if ($resp['success']) {
                             $id = $resp['data']->ID;
                            $token =  \App\Helpers\Auth::Token([ 'ID' => $id ], (60 * 60 * 24));
                            $url = url(\env('APP_WS') . "/api/confirmar") . "?" . \http_build_query(['lang' => $idioma  , 't' =>  $token   ]);
                            Mail::send('mail.registro', ['nombre_completo' => $nombre_completo, 'url' => $url],
                            function ($message) use ($nombre_completo, $correo, $url) {
                                    $message->from('desarrollo.nelson@gmail.com', 'CENPROMYPE');
                                    $message->to($correo, $nombre_completo,);
                                    $message->subject('Bienvenido');
                        // $message->priority(3);
                        // $message->attach('pathToFile');
                            });
                            return $this->respuesta(true, "Correo enviado");
                         } else {
                             return $this->respuesta(false, 'Servicio no disponible');
                         }
            
                    } catch (\Exception $exc) {
                          logger('error en registro envio correo ' . $exc->getMessage() .  ', archivo: ' . $exc->getFile() . '( linea: ' . $exc->getLine() );
                          return $this->respuesta(false, "Servicio no disponibleo ");
       }
       
       
    }
    

    
   
}
