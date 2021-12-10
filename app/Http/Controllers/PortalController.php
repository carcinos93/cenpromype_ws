<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class PortalController extends Controller {
    
    public  function registro() {
        $anio = request()->input('anio');
        $apellido = request()->input('apellido');
        $confirmarPassword = request()->input('confirmarPassword');
        $correo = request()->input('correo');
        $nombre = request()->input('nombre');
        $pais_residencia = request()->input('pais_residencia');
        $password = request()->input('password');
        $recaptcah = request()->input('recaptcah');
        $recibirBoletin = request()->input('recibirBoletin');
        $sexo = request()->input('sexo');
        $usuario = request()->input('usuario');
        $tipo_institucion = request()->input('tipo_institucion');
        $nombre_institucion = request()->input('nombre_institucion');
        $empresa_tamanyo = request()->input('empresa_tamanyo');
        $actividad_economica = request()->input('actividad_economica');
        
        
        $nombre_completo = "$nombre $apellido";
        
            try {
                         Mail::send('mail.registro', ['nombre_completo' => $nombre_completo],
                            function ($message) use ($nombre_completo, $correo) {
                        $message->from('desarrollo.nelson@gmail.com', 'CENPROMYPE');
                        $message->to($correo, $nombre_completo,);

                        $message->subject('Bienvenido');
                        // $message->priority(3);
                        // $message->attach('pathToFile');
                         return $this->respuesta(true, "Correo enviado");
                            });
                    } catch (\Exception $exc) {
                          logger('error en registro envio correo ' . $exc->getMessage() .  ', archivo: ' . $exc->getFile() . '( linea: ' . $exc->getLine() );
                          return $this->respuesta(false, "Fallo en el envio de correo ".  $exc->getMessage());
       }
       
       
    }
    

}
