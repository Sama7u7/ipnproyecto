<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DHT22Controller;

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

Route::get('/germinadores', function () {
    return view('germinadores');});

    Route::get('/deshidratador', [DHT22Controller::class, 'index']);