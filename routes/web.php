<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeUserController;
use App\Http\Controllers\DumpController;

use App\Http\Controllers\AlumnoController;

use App\Mail\Notification;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/alumno', function() { //Esta es la forma chapucera
    return view('alumno.index');
});

//Lo normal es que la ruta apunte al controlador
Route::get('/alumno', [AlumnoController::class, 'index']);


//Hay que evitar crear una ruta por cada CRUD (create, show, destroy, etc)
Route::get('/alumno/create', [AlumnoController::class, 'create']);

//Lo hacemos así
Route::resource('alumno', AlumnoController::class)->middleware('auth'); //Con el middleware protegemos rutas

//Si no las queremos todas
// Route::resource('alumno', AlumnoController::class)->only([ //Crea solo las que estén en el array
//     'index', 'show', 'create'
// ]);

//----------------------------------------------------------

Route::get('/', function () {
    // \Debugbar::disable();
    // \Debugbar::enable();
    return view('welcome');
});

// Route::get('/saludo1', function() { 
//     return view('welcome2');
// });

// Route::get('/saludo1/{nombre}', function($nombre) { 
//     return "Bienvenido, $nombre";
// });

// Route::get('/saludo1/{nombre}/{nick?}', function($nombre, $nick = NULL) { 
//     if ($nick != NULL) { 
//         return "Bienvenido, $nombre. Tu apodo es $nick."; 
//     } else { 
//         return "Bienvenido $nombre, no tienes apodo."; 
//     }
// });

// Route::get('/usuarios/{id}/edit', function($id) { 
//     return "Hola, usuario $id!";
// })->whereNumber('id');

// Route::any('/saludoTodos', function() { 
//     return "Acepta todos los verbos";
// });

// Route::prefix('saludo2')->group(function() { 
//     Route::get('/', function() { 
//         return view('welcome2'); 
//     });

//     Route::get('/uno', function() { 
//         return view('welcome2'); 
//     });

//     Route::get('/{id}', function($id) { 
//         return "Hola, $id"; 
//     })->where('id', '[0-9]{3}');

//     Route::get('/{nombre}', function($nombre) { 
//         return "$nombre tiene 4 letras."; 
//     })->where('nombre', '[A-Za-z]{4}');
// });

// Route::get('/saludoUno', function() { 
//     return redirect('/saludo1');
// });

// Route::get('/saludoDos', function() { 
//     return redirect('/saludo2');
// });

// Route::fallback(function() { 
//     return "ERROR 404";
// });

// Route::get('/primerSaludo', function() { 
//     return rename('/saludo1', '/primerSaludo');
// });

// Route::get('/otroSaludoUno', function() { 
//     return redirect()->route('/primerSaludo');
// })->name('/primerSaludo');


// Route::get('/usuarios/{id}/edit', [UserController::class, 'edit']);

// Route::get('/saludo1/{nombre}/{nick}', [WelcomeUserController::class, 'nick']);
// Route::get('/saludo1/{nombre}', [WelcomeUserController::class, 'noNick']);


//-------------------------------------------------------------

// Route::get('/dump/{id}/{name}', [DumpController::class, 'index']);
Auth::routes(['reset' => false]); //Quito las rutas que yo quiera

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [AlumnoController::class, 'index'])->name('home');
});

//-------------------------------------------------------------

Route::get('/email', function() {
    // return (new Notification("Jesús"))->render();
    $mensaje = new Notification("Jesús");

    $response = Mail::to("jesus.simarro@escuelaestech.es")->cc("cayetano.ledesma@escuelaestech.es")->bcc("jesus.martinez@escuelaestech.es")->send($mensaje);

    dump($response);
});
