<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MaicitosController extends Controller
{
    public function __construct()
    {
        // Crear la ruta para recibir los datos directamente en este controlador usando el nombre actualizado
        Route::post("/germinadores/maicitos/data", [self::class, 'receiveData'])
            ->name("germinadores.maicitos.data");
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

        // Insertar los datos en la base de datos
        DB::table("maicitos_temperatura_humedad")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

        DB::table("maicitos_luz")->insert([
            'luz' => $luz,
            'fecha_actual' => now(),
        ]);

        return response()->json(['success' => 'Datos recibidos correctamente.']);
    }
}