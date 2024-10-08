<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZanahoriasController extends Controller
{
    public function receiveData(Request $request, $nombre)
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

        // Convertir el nombre del germinador a minúsculas para las tablas
        $nombre_min = strtolower($nombre);

        // Insertar los datos en la tabla de temperatura y humedad
        DB::table("{$nombre_min}_temperatura_humedad")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

        // Insertar los datos en la tabla de luz
        DB::table("{$nombre_min}_luz")->insert([
            'luz' => $luz,
            'fecha_actual' => now(),
        ]);

        return response()->json(['success' => 'Datos recibidos correctamente.']);
    }
}