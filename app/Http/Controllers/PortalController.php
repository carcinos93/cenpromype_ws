<?php

namespace App\Http\Controllers;

use App\Helpers\Auth;
use App\Models;
use App\Models\TB\UsuarioDescarga;
use App\Models\TB\Usuarios;
use Dompdf\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PortalController extends Controller {
    
    /**
     * Confirmación de usuario
     */
    public function confirmar() {
        $token = request()->get('t');
        $idioma = request()->get('lang' ,'es');
        if (!\App\Helpers\Auth::Check($token)) {
            return view('expiracion.expiracion', ['respuesta' => '¡URL ha expirado!']);
        } else {
            $data = \App\Helpers\Auth::GetData($token);
            $id = $data->ID;

            if (Models\TB\Usuarios::where('ID', '=', $id)->where('ACTIVO', '=', 1)->first() ) {
                return view('expiracion.expiracion', ['respuesta' => '¡URL ha expirado!']);
            }
         
            $user = Models\TB\Usuarios::where('ID', '=', $id)->first();
            $responseUser = $this->registrarUsuario($user);

            if (!isset( $responseUser['code'] )) {
                return view('expiracion.expiracion', ['respuesta' => 'Se experimento un fallo al momento de verificar su usuario, por favor intentar más tarde']);
            }
            if ($responseUser['code'] == 'success') {
                Models\TB\Usuarios::where('ID', '=', $id)->update([ 'ACTIVO' => 1 ]);                
            } else {
                return view('expiracion.expiracion', ["respuesta" => "Se experimento un fallo al momento de verificar su usuario, por favor intentar más tarde"]);
            }

            return view('confirmar.confirmar', ['url' => env('APP_PORTAL'), 'respuesta' => "¡Cuenta confirmada!" ]);
        }
    }
    /**
     * Función que envía la información al portal wordpress
     */
    private function registrarUsuario($user) {
        $url = config("wordpress.url.sitio") . "wp-json/inteligenciabi/v1/usuario";

        $data = [   'correo' => $user->CORREO, 
                    'password' => $user->PASSWORD, 
                    'meta' => [ 'nivel' => 'no_paga', 
                                'id_user' => $user->ID, 
                                'first_name' => $user->NOMBRES, 
                                'last_name' => $user->APELLIDOS 
                    ] 
                ];
        
        $response = Http::withToken( $this->token() )->post($url, $data);
        return $response;
        # return  response( $response )->withHeaders(['Content-Type' => 'application/json; charset=UTF-8']);
    }
    
    /**
     * Verificación de existencia de usuario
     */
    public function existeUsuario() {
        $usuario = request()->get('usuario');
        $password = request()->get('password');
        $q = Models\TB\Usuarios::where('CORREO', '=', $usuario);
        if ($q->exists()) {
            $usr = $q->first();
            $passwordValid = $usr['PASSWORD'] == $password ? 1 : 0;
            $activo = $usr['ACTIVO'];

            $tiempo = (60 * 60 * 24 * 14); # dos semanas
            $token = Auth::Token( $usr , $tiempo );
           return array('existe' => 1, 'usuario' =>  $usr ,'password' => $passwordValid, 'activo' => $activo , 'token' => $token,
        'nombres' => $usr['NOMBRES'], 'apellidos' => $usr['APELLIDOS'] );
        } 
        return [ 'existe' => 0, 'usuario' => null, 'token' => null, 'password' => 0, 'activo' => 0 ];
    }

    /**
     * Registro de usuarios
     */
    public function registro() {
 
        $idioma = request()->input('lang', 'es');
        $preguntas = request()->input('preguntas');
        $formularios = implode("," , request()->input('formularios', []));
        
        /***
         * Para definir nombres específicos en las preguntas
         * se debe utilizar la columna VARIABLE
          */
        /**
         * Si es lista la variable se recibe asi: { "value": { "value": 1, "desc": "Descripción 1" }  } 
         * Si diferente de lista se recibe asi { "value": "valor" }
         *  */  
        $nombre = $preguntas['nombre']['value'];
        $apellido = $preguntas['apellido']['value'];
        $correo = $preguntas['correo']['value'];
        $nacionalidad = $preguntas['nacionalidad']['value']['items']['value'];


        $nombre_completo = "$nombre $apellido";
        $preguntasData = [];
        $passwordTemp = Str::random(8);
   
            try {
                $usuario = (new Models\TB\Usuarios())->create( array(
                'NOMBRES' => $nombre,
                'APELLIDOS' => $apellido,
                'CORREO' => $correo,
                'PASSWORD' => $passwordTemp,
                'PAIS' => $nacionalidad,
                'FORMULARIOS' => $formularios,
                'ACTIVO' => 0
                ));

                foreach ($preguntas as $key => $value) {
                    //$temp = explode("_", $key);
                    $idPregunta = $value['id_pregunta'];
                    $id_formulario = $value['formulario'];
                    
                    $preguntasData[] = new Models\TB\UsuarioRespuestas(array('ID_PREGUNTA' => $idPregunta, 'RESPUESTA' => $value, 'ID_FORMULARIO' => $id_formulario));
                }

                $usuario->respuestas()->saveMany( $preguntasData );      
                if ($usuario) {
                    $id = $usuario->ID;
                    $token =  \App\Helpers\Auth::Token([ 'ID' => $id ], (60 * 60 * 24)); // Token valido por 24 horas
                    $url = url(\env('APP_WS') . "/api/confirmar") . "?" . \http_build_query(['lang' => $idioma  , 't' =>  $token   ]);
                    Mail::send('mail.registro', ['nombre_completo' => $nombre_completo, 'url' => $url, 'password' => $passwordTemp],
                        function ($message) use ($nombre_completo, $correo, $url) {
                            /**
                             * Mailtrap no utiliza cuentas de correo sino cadena alfanuméricas
                             * se produce un error si se intente enviar esta cadena como remitente
                             */
                            $mail =\env('MAIL_HOST') == 'mtp.mailtrap.io' ? "micorreo@mailtrap.com" :  \env('MAIL_USERNAME');
                            $message->from($mail, "CENPROMYPE");
                            $message->to($correo, $nombre_completo,);
                            $message->subject('Bienvenido');
                    });
                    return $this->respuesta(true, "Se ha enviado un correo electrónico con el enlace de verificación");
                    } else {
                        return $this->respuesta(false, 'Servicio no disponible');
                    }
            }
                     catch (\Exception $exc) {
                          logger('error en registro envio correo ' . $exc->getMessage() .  ', archivo: ' . $exc->getFile() . '( linea: ' . $exc->getLine() );
                          return $this->respuesta(false, "Servicio no disponible");
       }
       
       
    }
    /**
     * Lista de usuarios
     */
    public function usuarios() {

        return $this->getRecords(Usuarios::class, ['NOMBRES', 'APELLIDOS','CORREO', 'PAIS', 'FECHA_CREACION', 'ID'], [], '', request());
        //$url = config("wordpress.url.sitio") . "wp-json/wp/v2/users";

        //$response = Http::withToken( $this->token() )->get($url);
       // return  response( $response )->withHeaders(['Content-Type' => 'application/json; charset=UTF-8']);
    }

    public function respuestas($idusuario) {
        return Usuarios::with(['respuestas'])->find( $idusuario, ['ID'] );
    }

    public function usuarioDescargaAll() {
        return $this->getRecords(UsuarioDescarga::class, ['DOCUMENTO', 'FECHA_CREACION', 'ID_USUARIO', 'ID'], [], '', request());
    }

    public function usuarioDescargaInsert() {
        $documento = request()->input('documento');
        $id_usuario = request()->input('id_usuario');
        return UsuarioDescarga::create( ['DOCUMENTO' => $documento, 'ID_USUARIO' => $id_usuario] );
    }

    private function token() {
        $url = config("wordpress.url.sitio") . "wp-json/jwt-auth/v1/token";
        $response =  Http::post($url,  ["username" => "adminwp", "password" =>  "esOQM$21"]);
        return $response['token'];
    }

    

    
   
}
