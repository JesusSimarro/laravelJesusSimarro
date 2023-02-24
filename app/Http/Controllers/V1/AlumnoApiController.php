<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumno;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AlumnoApiController extends Controller
{
    //Lista todos los alumnos
    public function index() {
        return Alumno::get();
    }

    //Muestra un solo alumno
    public function show($id) {
        //Buscar al alumno
        $alumno = Alumno::find($id);

        //Si el alumno no existe, devolvemos un error
        if (!$alumno) {
            return response()->json([
                'message' => 'Alumno not found'
            ], 404);
        }

        //Si hay alumno, lo devolvemos
        return $alumno;
    }

    //Crea un alumno
    public function store(Request $request) { //Request $request cuando la función es por POST
        //Validar los datos
        $data = $request->only('nombre', 'apellido', 'email', 'edad', 'direccion', 'foto');

        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:250',
            'apellido' => 'required|string|max:250',
            'email' => 'required|email',
            'edad' => 'required|int|min:0|max:150',
            'direccion' => 'required|string|max:250',
            'foto' => 'required|max:20480000|mimes:jpeg,jpg,png'
        ]);

        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Creamos el alumno en la DB
        $alumno = Alumno::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'edad' => $request->edad,
            'direccion' => $request->direccion,
            'foto' => $request->file('foto')->store('uploads', 'public'),
        ]);

        return response()->json([
            'message' => 'Alumno created',
            'data' => $alumno
        ], Response::HTTP_OK);
    }

    //Modifica un alumno
    public function update(Request $request, $id) {
        //Validar datos
        $data = $request->only('nombre', 'apellido', 'email', 'edad', 'direccion', 'foto');

        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:250',
            'apellido' => 'required|string|max:250',
            'email' => 'required|email',
            'edad' => 'required|int|min:0|max:150',
            'direccion' => 'required|string|max:250',
            'foto' => 'max:20480000|mimes:jpeg,jpg,png'
        ]);

        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Buscamos el alumno
        $alumno = Alumno::findOrFail($id);

        //Actualizamos el alumno
        if ($request->hasFile('foto')) {
            //Si viene una foto, eliminamos la antigua y guardamos la nueva
            //$alumno = Alumno::findOrFail($id);
            Storage::delete('public/' . $alumno->foto);
            $data['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        $alumno->update($data);

        //Devolver los datos actualizados
        return response()->json([
            'message' => 'Alumno updated successfully',
            'data' => $alumno,
        ], Response::HTTP_OK);
    }
}
