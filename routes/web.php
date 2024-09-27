<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DHT22Controller;
use App\Http\Controllers\GerminadorController;


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

/*Route::get('/germinadores', function () {
    return view('germinadores');});
*/


Route::get('/germinadores', [GerminadorController::class, 'index']);

Route::get('/deshidratador', [DHT22Controller::class, 'index']);

Route::get('/exportar-excel', [GerminadorController::class, 'exportExcel']);

