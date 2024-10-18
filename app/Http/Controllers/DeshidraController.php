<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DeshidraController extends Controller
{
    public function __construct()
    {
        Route::post("/deshidratadores/deshidra/data", [self::class, 'receiveData'])
            ->name("deshidratadores.deshidra.data");
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
        DB::table("{$nombre_min}_dht1")->insert([
            'temperatura' => $request->input('temperatura1'),
            'humedad' => $request->input('humedad1'),
            'fecha_actual' => now(),
        ]);
        
        DB::table("{$nombre_min}_dht2")->insert([
            'temperatura' => $request->input('temperatura2'),
            'humedad' => $request->input('humedad2'),
            'fecha_actual' => now(),
        ]);
        
        DB::table("{$nombre_min}_dht3")->insert([
            'temperatura' => $request->input('temperatura3'),
            'humedad' => $request->input('humedad3'),
            'fecha_actual' => now(),
        ]);
        
        DB::table("{$nombre_min}_peso")->insert([
            'peso' => $request->input('peso'),
            'fecha_actual' => now(),
        ]);
        

        return response()->json(['message' => 'Datos recibidos correctamente.'], 200);
    }
}