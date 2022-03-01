<?php
namespace App\Helpers;
class Wordpress {
    public static function url($nombre, $params = []) {
        return config("wordpress.url.sitio")  . config("wordpress.url.$nombre") . (!empty($params) ? "/?" . http_build_query($params) : "");
    }
    public static function index() {
        return config("wordpress.url.sitio");
    }
    public static function recurso( $ruta ) {
        return config("wordpress.url.sitio") . "/" . $ruta;
    }
    
    public static function uploads( $ruta ) {
        return config("wordpress.url.sitio") . "/" . config("wordpress.url.uplodas") . "/" . $ruta;
    }
}