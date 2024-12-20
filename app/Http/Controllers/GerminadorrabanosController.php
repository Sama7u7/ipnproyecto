<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class GerminadorrabanosController extends Controller
{
    public function __construct()
    {
        // Crear la ruta para recibir los datos directamente en este controlador usando el nombre en minúsculas
        Route::post("/germinadores/germinadorrabanos/data", [self::class, 'receiveData'])
            ->name("germinadores.germinadorrabanos.data");
    }

    public function receiveData(Request $request)
    {
        // Validar los datos que recibes del ESP32
        $request->validate([
            'temperatura' => 'required|numeric',
            'humedad' => 'required|numeric',
            'luz' => 'required|numeric',
        ]);

        // Obtener los datos
        $temperatura = $request->input('temperatura');
        $humedad = $request->input('humedad');
        $luz = $request->input('luz');

        // Insertar los datos en la base de datos, usando el nombre en minúsculas para las tablas
        DB::table("germinadorrabanos_temperatura_humedad")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

        DB::table("germinadorrabanos_luz")->insert([
            'luz' => $luz,
            'fecha_actual' => now(),
        ]);

        return response()->json(['success' => 'Datos recibidos correctamente.']);
    }
}