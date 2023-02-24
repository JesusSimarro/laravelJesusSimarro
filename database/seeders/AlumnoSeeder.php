<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alumnos')->insert([
            [
                'nombre' => 'Jesús',
                'apellido' => 'Simarro',
                'email' => 'jesus.simarro@escuelaestech.es',
                'edad' => 19,
                'direccion' => 'C/ San Joaquín, 12',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nombre' => 'Pepito', 
                'apellido' => 'Pérez', 
                'email' => 'pepe.perez@escuelaestech.es', 
                'edad' => 34, 
                'direccion' => 'C/ Nueva, 3', 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
