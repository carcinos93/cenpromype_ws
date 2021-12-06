<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class TraductorController extends Controller {

    #USUARIOS
    const URL = 'https://api.au-syd.language-translator.watson.cloud.ibm.com/instances/201f93ed-e3ee-460a-acbe-20256f21c98e/v3/translate?version=2018-05-01';

    public function Traducir() {
        $palabras = request()->get('palabras');
        $idioma = request()->get('idioma');
        return $this->ConsumirMetodo( $palabras, 'es', $idioma );
        //return request()->get('palabras');
    }
    public function ConsumirMetodo($palabras, $idiomaOrigen, $idiomaDestino) {
        $usuario = env('IBM_TRANSLATE_USER');
        $password = env('IBM_TRANSLATE_PASSWORD');
        $response = Http::acceptJson()->withBasicAuth($usuario, $password)->retry(3, 100)->post(self::URL, [
            "text" => $palabras,
            "model_id" =>   "$idiomaOrigen-$idiomaDestino"
        ]);

        return $response->json();
    }


}
