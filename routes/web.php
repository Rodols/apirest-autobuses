<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\UserController;

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

/*
GET:_Conseguir datos o recursos
*POST Guardar datos o recursos o hacer logica desde formulario
*PUT: Actualizar datos o recursos
*DELETE: Eliminar datos o recursos
*/





Route::get('/', function () {
    return view('welcome');
});


//Rutas del api
Route::post('/api/register', [UserController::class,'register']);
Route::post('/api/login', [UserController::class,'login']);
//Route::get('/travel/pruebas', 'BusTravelController@pruebas');
//Route::get('/assignments/pruebas', 'BusAssignmentsController@pruebas');
//Route::get('/stops/pruebas', 'BusStopController@pruebas');
//Route::get('/route/pruebas', 'BusRouteController@pruebas');
Route::get('api/buses', [BusController::class,'buses']);
