<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

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

Route::get('/', function () {
    return view('auth.login');
});

//ruta para dar acceso a la vista empleado
/* Route::get('/empleado', function () {
    return view('empleado.index');
});

//ruta para dar acceso a la vista crearEmpleado
Route::get('/empleado/create',[EmpleadoController::class,'create']); */

//con esto damos la instruccion ara tener acceso a todas las rutas disponibles
//con el codigo del final de la linea se valida estar autenticado y con ello permitir o no el acceso al sistema
Route::resource('empleado',EmpleadoController::class)->middleware('auth');

//se elimina el acceso a registrarse y a recuperar la password del usuario
Auth::routes(['register'=>false,'reset'=>false]);

Auth::routes();

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){
    //una vez que se logee el user se redireccionala al index del controller
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});
