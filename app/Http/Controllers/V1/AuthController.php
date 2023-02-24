<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Registro de usuario
    public function register(Request $request) {
        //Indicamos los parámetros que queramos recibir de Request
        $data = $request->only('name', 'email', 'password');

        //validación
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users', //único en la tabla users
            'password' => 'required|string|min:6|max:50',
        ]);

        //Devolver un error si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password) //Encriptamos la contraseña
        ]);

        //Nos quedamos con el usuario y contraseña para realizar la petición de token a JWTAuth
        $credentials = $request->only('email', 'password');

        return response()->json([
            'message' => 'User created',
            'token' => JWTAuth::attempt($credentials),
            'user' => $user
        ], Response::HTTP_OK);
    }

    //Función que utilizaremos para hacer login
    public function authenticate(Request $request) {
        //Indicamos los parámetros que queremos recibir de la request
        $credentials = $request->only('email', 'password');

        //Validación
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Si la validación falla, devolvemos un error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Intentamos hacer login
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                //Credenciales incorrectas
                return response()->json(['error' => 'Login failed'], 401);
            }
        } catch (JWTException $e) {
            //Error chungo
            return response()->json([
                'message' => 'Error',
            ], 500);
        }

        //Devolver el token
        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    //Función que elimina el token y desconecta al usuario
    public function logout(Request $request) {
        //Valida que nos envía el token
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Si fallo de validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        try {
            JWTAuth::invalidate(($request->token)); //Esto anula el token

            //Si el token es válido, eliminamos el token desconectando al usuario
            return response()->json([
                'success' => true,
                'message' => 'User disconnected'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    //Función que utilizaremos para obtener los datos del usuario, y validar si el token ha expirado
    public function getUser(Request $request) {
        //Validar que la request tenga el token
        $this->validate($request, [
            'token' => 'required'
        ]);

        //Hacer la autenticación
        $user = JWTAuth::authenticate($request->token);

        //Si no obtenemos el usuario a partir del token, el token no es válido o ha expirado
        if (!$user) {
            return response()->json([
                'message' => 'Invalid token / Token expired'
            ], 401);
        }

        //Devolvemos los datos del usuario si todo va bien
        return response()->json(['user' => $user]);
    }
}
