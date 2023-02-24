<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['alumnos'] = Alumno::paginate(5); //Esto es para la tabla

        return view('alumno.index', $datos); //Le decimos la vista a la que nos tiene que llevar
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumno.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validación
        $campo = [
            'nombre' => 'required|string|max:250',
            'apellido' => 'required|string|max:250',
            'email' => 'required|email',
            'edad' => 'required|int|min:0|max:150',
            'direccion' => 'required|string|max:250',
            'foto' => 'required|max:20480000|mimes:jpeg,jpg,png'
        ];

        $mensaje = [
            'required' => 'El :attribute es obligatorio.',
            'foto.required' => 'La foto es obligatoria.',
            'edad.required' => 'La edad es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres',
            'foto.max' => 'La foto no puede ser mayor de :max bytes',
            'foto.mimes' => 'La foto debe estar en uno de los siguientes formatos: :values'
        ];

        $this->validate($request, $campo, $mensaje);

        $datosAlumno = $request->except('_token');

        if ($request->hasFile('foto')) { //Si en request hay un fichero con la clave foto
            //Guarda la imagen en /store/app/public/uploads
            //Guarda el nombre de la imagen en la db
            $datosAlumno['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        Alumno::insert($datosAlumno);

        return redirect('alumno')->with('mensaje', $datosAlumno['nombre'] . ' ha sido registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumno = Alumno::findOrFail($id);

        return view('alumno.show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno = Alumno::findOrFail($id);
        return view('alumno.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación
        $campo = [
            'nombre' => 'required|string|max:250',
            'apellido' => 'required|string|max:250',
            'email' => 'required|email',
            'edad' => 'required|int|min:0|max:150',
            'direccion' => 'required|string|max:250',
            'foto' => 'max:20480000|mimes:jpeg,jpg,png'
        ];

        $mensaje = [
            'required' => 'El :attribute es obligatorio.',
            'edad.required' => 'La edad es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres',
            'foto.max' => 'La foto no puede ser mayor de :max bytes',
            'foto.mimes' => 'La foto debe estar en uno de los siguientes formatos: :values'
        ];

        $this->validate($request, $campo, $mensaje);

        $datosAlumno = request()->except('_token', '_method');

        if ($request->hasFile('foto')) {
            //Si viene una foto, eliminamos la antigua y guardamos la nueva
            $alumno = Alumno::findOrFail($id);
            Storage::delete('public/' . $alumno->foto);
            $datosAlumno['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        Alumno::where('id', '=', $id)->update($datosAlumno);

        $alumno = Alumno::findOrFail($id);

        // return view('alumno.edit', compact('alumno'));
        return redirect('alumno')->with('mensaje', 'Se han modificado los datos de ' . $datosAlumno['nombre']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alumno = Alumno::findOrFail($id); //Si no lo encuentra, devuelve un error

        if (Storage::delete('public/' . $alumno->foto)) { //Así elimina también la foto de los uploads
            Alumno::destroy($id);
        }

        return redirect('alumno')->with('mensaje', 'Se ha eliminado el alumno #' . $id);
    }
}
