<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class Pruebasdeshidratador1Controller extends Controller
{
    public function __construct()
    {
        Route::post("/deshidratadores/pruebasdeshidratador1/data", [self::class, 'receiveData'])
            ->name("deshidratadores.pruebasdeshidratador1.data");
    }

    public function receiveData(Request $request)
    {
        // Validar los datos
        $request->validate([
            'temperatura1' => 'required|numeric',
            'humedad1' => 'required|numeric',
            'temperatura2' => 'required|numeric',
            'humedad2' => 'required|numeric',
            'temperatura3' => 'required|numeric',
            'humedad3' => 'required|numeric',
            'peso' => 'required|numeric',
        ]);

        // Insertar los datos del primer sensor DHT22 en la tabla dht1
        DB::table("pruebasdeshidratador1_dht1")->insert([
            'temperatura' => $request->input('temperatura1'),
            'humedad' => $request->input('humedad1'),
            'fecha_actual' => now(),
        ]);

        // Insertar los datos del segundo sensor DHT22 en la tabla dht2
        DB::table("pruebasdeshidratador1_dht2")->insert([
            'temperatura' => $request->input('temperatura2'),
            'humedad' => $request->input('humedad2'),
            'fecha_actual' => now(),
        ]);

        // Insertar los datos del tercer sensor DHT22 en la tabla dht3
        DB::table("pruebasdeshidratador1_dht3")->insert([
            'temperatura' => $request->input('temperatura3'),
            'humedad' => $request->input('humedad3'),
            'fecha_actual' => now(),
        ]);

     
        // Insertar los datos del sensor de peso (HX711)
        DB::table("pruebasdeshidratador1_peso")->insert([
            'peso' => $request->input('peso'),
            'fecha_actual' => now(),
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente.'], 200);
    }
}