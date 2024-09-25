<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DHT22Controller extends Controller
{
    public function index()
    {
        // Obtener los últimos datos de cada tabla
        $ultimo_dato_dht1 = DB::table('Tb_DHT22_1')->latest('fecha_actual')->first();
        $ultimo_dato_dht2 = DB::table('Tb_DHT22_2')->latest('fecha_actual')->first();
        $ultimo_dato_dht3 = DB::table('Tb_DHT22_3')->latest('fecha_actual')->first();

        // Obtener historial de datos
        $resultado_todos_dht1 = DB::table('Tb_DHT22_1')->get();
        $resultado_todos_dht2 = DB::table('Tb_DHT22_2')->get();
        $resultado_todos_dht3 = DB::table('Tb_DHT22_3')->get();

        return view('deshidratador.index', compact('ultimo_dato_dht1', 'ultimo_dato_dht2', 'ultimo_dato_dht3',
                                             'resultado_todos_dht1', 'resultado_todos_dht2', 'resultado_todos_dht3'));
    }
}