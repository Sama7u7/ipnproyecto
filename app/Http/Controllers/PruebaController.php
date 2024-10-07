<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruebaController extends Controller
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

        // Insertar los datos en la base de datos
        DB::table("Prueba_temperatura_humedad")->insert([
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'fecha_actual' => now(),
        ]);

        DB::table("Prueba_luz")->insert([
            'luz' => $luz,
            'fecha_actual' => now(),
        ]);

        return response()->json(['success' => 'Datos recibidos correctamente.']);
    }
}