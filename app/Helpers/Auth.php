<?php

namespace App\Helpers;

use Firebase\JWT\JWT;

class Auth {

    private static $secret_key = '^9$ed_98bc-A5D6*';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function SignIn($data) {
        $time = time();

        $token = array(
            'exp' => $time + (60 * 60 * 5), // 5 horas
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    
    }
    
     public static function Token( $data, $extraTime ) {
        $time = time();

        $token = array(
            'exp' => $time + ($extraTime), //una dia
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }

    public static function RecordarPasswordToken( $data ) {
        $time = time();

        $token = array(
            'exp' => $time + (60 * 60 * 24 * 7), //una semana
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }

    public static function Check($token) {
        if (empty($token)) {
            return false;
        }

        try {

            $decode = JWT::decode(
                            $token, self::$secret_key, self::$encrypt
            );
            return ($decode !== self::Aud());
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function GetData($token) {
        return JWT::decode(
                        $token, self::$secret_key, self::$encrypt
                )->data;
    }

    private static function Aud() {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }

}
