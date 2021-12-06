<?php

namespace App\Helpers;


class Recaptcha {

    private static $secret_key = 'KEY';
    private static $url_service = 'https://www.google.com/recaptcha/api/siteverify?secret={secretKey}&response={token}&remoteip={ip}';

    public static function Check($token, \Illuminate\Http\Request $request) {

        $ip = $request->ip();
        $variables = [ 'secretKey' => self::$secret_key, 'token' => $token, 'ip' => $ip ];
        $url = self::$url_service;
        foreach ($variables as $key => $value) {
            $url = str_replace("{" .  $key  . "}", urlencode($value), $url);
        }

        $data = json_decode(file_get_contents($url), true);
       //   return $url;
       return $data;


    }





}
