<?php

namespace App\helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth
{
    public $key;

    public function __construct()
    {
        $this->key = 'esto_es_una_clave_super_secreta-998';
    }

    public function signup($email, $password, $getToken = null)
    {
        //Buscar si existe el usuario con sus credenciales
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();

        //Comprobar si son correctas(objeto)
        $signup = false;
        if (is_object($user)) {
            $signup = true;
        }

        //Generar el token con los datos del usuario identificado
        if ($signup) {

            $token = array(
                'sub' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);

            if(is_null($getToken)){
                $data = $jwt;
            }else{
                $data = $decoded;
            }

        } else {
            $data = array(
                'status' => 'error',
                'mensaje' => 'Login incorrecto'
            );
        }

        //Devolver los datos decodificados o el token, en funcion de un paametro
        return $data;
    }

    public function checkToken($jwt, $getIdentity = false){
        $auth = false;
        try{
            $jwt = str_replace('"','',$jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }

        if(!empty($decoded) && is_object($decoded)&& isset($decoded->sub)){
            $auth = true;
        }else{
            $auth= false;
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }

}
