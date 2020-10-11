<?php

namespace App\Http\Controllers;

use App\helpers\JwtAuth;
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
                $pwd = hash('sha256', $params->password);

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
        $jwtAuth = new JwtAuth();

        //Recibir datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //Validar esos datos
        $validate = Validator::make($params_array, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            //La validacion a fallado
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Falta el password o email',
                'errors' => $validate->errors()
            );
        } else {
            //Cifrar la password
            $pwd = hash('sha256', $params->password);

            //Devolver token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);

            if (!empty($params->gettoken)) {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }
        return response()->json($signup, 200);
    }

    public function update(Request $request)
    {

        //Comprobar si el usuario esta identificado
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        //Recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if ($checkToken && !empty($params_array)) {

            //Sacar usuario identificado
            $user = $jwtAuth->checkToken($token, true);

            //Validar los datos
            $validate = Validator::make($params_array, [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:users,' . $user->sub
            ]);

            //Quitar los datos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['role']);
            unset($params_array['password']);
            unset($params_array['created_at']);

            //Actualizar usuario en bd
            $user_update = User::where('id', $user->sub)->update($params_array);
            $data = array(
                'code' => 200,
                'status' => 'success',
                'message' => 'El usuario no esta identificado',
                'user' => $user,
                'changes' => $params_array
            );

            //Devolver array con resultado

        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'El usuario no esta identificado.'
            );
        }

        return response()->json($data, $data['code']);
    }
}
