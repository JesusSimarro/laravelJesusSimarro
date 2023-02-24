<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    //Alumno -> alumnos 
    protected $table = "alumnos"; //Esta línea solo se escribe cuando el plural español no coincide con el inglés (Rey -> Reies)

    //Propiedad fillable 
    protected $fillable = ['nombre', 'apellido', 'email', 'edad', 'direccion', 'foto'];

    //Propiedad hidden 
    protected $hidden = ['id'];

    //Devuelve todos los alumnos registrados en la db 
    public function obtenerAlumnos() { 
        // DB::table('alumnos')->all(); 
        return Alumno::all(); 
    }

    //Devuelve un alumno con la id = $id 
    public function obtenerAlumnoPorId($id) { 
        return Alumno::find($id); 
    }
}
