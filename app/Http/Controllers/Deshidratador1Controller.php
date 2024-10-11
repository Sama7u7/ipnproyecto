<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class Deshidratador1Controller extends Controller
{
    public function __construct()
    {
        // Crear la ruta para recibir los datos directamente en este controlador usando el nombre en minúsculas
        Route::post("/germinadores/deshidratador1/data", [self::class, 'receiveData'])
            ->name("germinadores.deshidratador1.data");
    }

    public function receiveData(Request $request)
    {
        // Validar los datos que recibes del ESP32
        $request->validate([
            'temperatura' => 'required|numeric',
            'humedad' => 'required|numeric',
            'luz' => 'required|numeric',
            'peso' => 'required|numeric',
        ]);

        // Obtener los datos
        $temperatura = $request->input('temperatura');
        $humedad = $request->input('humedad');
        $luz = $request->input('luz');
        $peso = $request->input('peso');

        // Insertar los datos en la base de datos, usando el nombre en minúsculas para las tablas
        DB::table("deshidratador1_dht1")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

           
        DB::table("deshidratador1_dht2")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

         DB::table("deshidratador1_dht3")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

         DB::table("deshidratador1_peso")->insert([
            'peso' => $peso,
            'fecha_actual' => now(),
        ]);



        return response()->json(['success' => 'Datos recibidos correctamente.']);
    }
}