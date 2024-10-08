<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DHT22Controller;
use App\Http\Controllers\GerminadorController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LechugonesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

// Obtener todos los germinadores de la base de datos

$germinadores = DB::table('germinadores')->get();

foreach ($germinadores as $germinador) {
    // Convertir el nombre del germinador a minúsculas
    $nombre_min = strtolower($germinador->nombre);

    // Generar dinámicamente el nombre del controlador según el germinador
    $nombreControlador = ucfirst($nombre_min) . 'Controller';

    // Asegúrate de que la clase del controlador exista antes de intentar registrar la ruta
    if (class_exists("App\\Http\\Controllers\\{$nombreControlador}")) {
        Route::post("/germinadores/{$nombre_min}/data", ["App\\Http\\Controllers\\{$nombreControlador}", 'receiveData'])
            ->name("germinadores.{$nombre_min}.data");
    } else {
        // Maneja el caso en que el controlador no existe
        // Podrías lanzar un error o simplemente no registrar la ruta
        // Log::error("Controlador {$nombreControlador} no existe.");
    }
}

/*Route::get('/germinadores', function () {
    return view('germinadores');});
*/

Route::get('/deshidratador', [DHT22Controller::class, 'index']);

Route::get('/germinadores/{nombre}/export-excel', [GerminadorController::class, 'exportExcel'])->name('germinadores.exportExcel');
Route::get('/germinadores/create', [GerminadorController::class, 'create'])->name('germinadores.create');
Route::get('/germinadores/{nombre}', [GerminadorController::class, 'show'])->name('germinadores.show');
Route::get('/germinadores-list', [GerminadorController::class, 'listGerminadores'])->name('germinadores.list');
Route::post('/germinadores/store', [GerminadorController::class, 'store'])->name('germinadores.store');