<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerminadorController;
use App\Http\Controllers\DeshidratadorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;





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

Route::middleware(['auth.check'])->group(function () {
    // Rutas de Dashboard y Usuarios
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/list', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // Rutas de Germinadores
    Route::get('germinadores/{id}/edit', [GerminadorController::class, 'edit'])->name('germinadores.edit');
    Route::put('germinadores/{id}', [GerminadorController::class, 'update'])->name('germinadores.update');
    Route::delete('germinadores/{id}', [GerminadorController::class, 'destroy'])->name('germinadores.destroy');
    Route::get('/germinadores/create', [GerminadorController::class, 'create'])->name('germinadores.create');
    Route::post('/germinadores/store', [GerminadorController::class, 'store'])->name('germinadores.store');
    Route::get('/admin/germinadores/{nombre}', [GerminadorController::class, 'showback'])->name('admingerminadores.show');

    // Rutas de Deshidratadores
    Route::get('/deshidratadores/{id}/edit', [DeshidratadorController::class, 'edit'])->name('deshidratadores.edit');
    Route::put('/deshidratadores/{id}', [DeshidratadorController::class, 'update'])->name('deshidratadores.update');
    Route::delete('/deshidratadores/{id}', [DeshidratadorController::class, 'destroy'])->name('deshidratadores.destroy');
    Route::get('/deshidratadores/create', [DeshidratadorController::class, 'create'])->name('deshidratadores.create');
    Route::post('/deshidratadores/store', [DeshidratadorController::class, 'store'])->name('deshidratadores.store');
    Route::get('/admin/deshidratadores/{nombre}', [DeshidratadorController::class, 'showback'])->name('admindeshidratadores.show');
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
        Log::error("Controlador {$nombreControlador} no existe.");
    }
}


Route::get('/germinadores/{nombre}/export-excel', [GerminadorController::class, 'exportExcel'])->name('germinadores.exportExcel');
Route::get('/germinadores/{nombre}', [GerminadorController::class, 'show'])->name('germinadores.show');
Route::get('/germinadores-list', [GerminadorController::class, 'listGerminadores'])->name('germinadores.list');


// Obtener todos los deshidratadores de la base de datos
$deshidratadores = DB::table('deshidratadores')->get();

foreach ($deshidratadores as $deshidratador) {
    // Convertir el nombre del deshidratador a minúsculas
    $nombre_min = strtolower($deshidratador->nombre);

    // Generar dinámicamente el nombre del controlador según el deshidratador
    $nombreControlador = ucfirst($nombre_min) . 'Controller';

    // Asegúrate de que la clase del controlador exista antes de intentar registrar la ruta
    if (class_exists("App\\Http\\Controllers\\{$nombreControlador}")) {
        Route::post("/deshidratadores/{$nombre_min}/data", ["App\\Http\\Controllers\\{$nombreControlador}", 'receiveData'])
            ->name("deshidratadores.{$nombre_min}.data");
    } else {
        // Maneja el caso en que el controlador no existe
        // Podrías lanzar un error o simplemente no registrar la ruta
        Log::error("Controlador {$nombreControlador} no existe.");
    }
}

Route::get('/deshidratadores/{nombre}/export-excel', [DeshidratadorController::class, 'exportExcel'])->name('deshidratadores.exportExcel');
Route::get('/deshidratadores-list', [DeshidratadorController::class, 'listDeshidratadores'])->name('deshidratadores.list');
Route::get('/deshidratadores/{nombre}', [DeshidratadorController::class, 'show'])->name('deshidratador.show');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', function () {
    Auth::logout();  // Cierra la sesión del usuario
    return redirect('/');  // Redirige al formulario de login
})->name('logout');