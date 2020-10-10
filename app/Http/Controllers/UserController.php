<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        return 'Accion de pruebas de index USER-CONTROLLER';
    }

    public function register(Request $request)
    {
        //Recoger los datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params) && !empty($params_array)) {
            //Validar datos
            $validate = Validator::make($params_array, [
                'name'       => 'required|alpha',
                'surname'    => 'required|alpha',
                //Comprobar si el usuario existe(usuario complicado)
                'email'      => 'required|email|unique:users',
                'password'   => 'required'
            ]);

            if ($validate->fails()) {
                //Devuelve un json de error en caso de que los datos no sean validos
                $data = array(
                    'status'    => 'error',
                    'code'      => '404',
                    'mensaje'   => 'El usuario no se ha creado datos no validos',
                    'errors'    => $validate->errors()
                );
            } else {
                //En caso de validacion exitosa

                //Cifrar contraseña
                $pwd = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);

                //Crear usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->password = $pwd;;
                $user->role = 'ROLE_USER';

                //Guardar usuario
                $user->save();

                //Devuelve un json de exito en caso de validacion exitosa
                $data = array(
                    'status'    => 'success',
                    'code'      => '200',
                    'mensaje'   => 'El usuario se ha creado correctamente',
                    'user'      => $user
                );
            }
        } else {
            //Devuelve un json de error en caso de no recibir datos
            $data = array(
                'status'    => 'error',
                'code'      => '404',
                'mensaje'   => 'Los datos enviados no son correctos'
            );
        }





        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        return 'Accion de pruebas de USER-CONTROLLER';
    }
}
