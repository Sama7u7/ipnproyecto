<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PruebaController extends Controller
{
    public function __construct()
    {
        // Crear la ruta para recibir los datos directamente en este controlador usando el nombre actualizado
        Route::post("/deshidratadores/prueba/data", [self::class, 'receiveData'])
            ->name("deshidratadores.prueba.data");
    }

    public function receiveData(Request $request)
    {
        // Validar los datos recibidos del ESP32
        $request->validate([
            'temperatura1' => 'required|numeric',
            'humedad1' => 'required|numeric',
            'temperatura2' => 'required|numeric',
            'humedad2' => 'required|numeric',
            'temperatura3' => 'required|numeric',
            'humedad3' => 'required|numeric',
            'pesogral' => 'required|numeric',
            'pesolvl' => 'required|numeric',
        ]);

        // Insertar los datos de temperatura y humedad en cada tabla correspondiente
        DB::table("prueba_dht1")->insert([
            'temperatura' => $request->input('temperatura1'),
            'humedad' => $request->input('humedad1'),
            'fecha_actual' => now(),
        ]);

        DB::table("prueba_dht2")->insert([
            'temperatura' => $request->input('temperatura2'),
            'humedad' => $request->input('humedad2'),
            'fecha_actual' => now(),
        ]);

        DB::table("prueba_dht3")->insert([
            'temperatura' => $request->input('temperatura3'),
            'humedad' => $request->input('humedad3'),
            'fecha_actual' => now(),
        ]);

        // Insertar los datos de peso
        DB::table("prueba_pesogral")->insert([
            'peso' => $request->input('pesogral'),
            'fecha_actual' => now(),
        ]);

        DB::table("prueba_pesolvl")->insert([
            'peso' => $request->input('pesolvl'),
            'fecha_actual' => now(),
        ]);

        return response()->json(['success' => 'Datos recibidos correctamente.']);
    }
}