<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class GerminadorController extends Controller
{
    public function index()
    {
        // Obtener los últimos datos de Tb_DHT22
        $ultimo_dato = DB::table('Tb_DHT22')->latest('fecha_actual')->first();

        // Obtener historial de Tb_DHT22
        $resultado_todos = DB::table('Tb_DHT22')->get();

        // Obtener los últimos datos de tb_bh1750_1
        $ultimo_dato_bh1750 = DB::table('tb_bh1750_1')->latest('fecha_actual')->first();

        // Obtener historial de tb_bh1750_1
        $resultado_todos_bh1750 = DB::table('tb_bh1750_1')->get();

        // Retornar la vista con los datos de ambas tablas
        return view('germinadores.index', compact('ultimo_dato', 'resultado_todos', 'ultimo_dato_bh1750', 'resultado_todos_bh1750'));
    }

    public function exportExcel()
    {
        // Obtener los datos de la base de datos
        $datos = DB::table('Tb_DHT22')->get();

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer los encabezados
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Temperatura');
        $sheet->setCellValue('C1', 'Humedad');
        $sheet->setCellValue('D1', 'Fecha');

        // Escribir los datos al archivo
        $row = 2; // Comenzar en la fila 2 para no sobrescribir los encabezados
        foreach ($datos as $dato) {
            $sheet->setCellValue('A' . $row, (int)$dato->Id);
            $sheet->setCellValue('B' . $row, $dato->Temperatura);
            $sheet->setCellValue('C' . $row, $dato->Humedad);
            $sheet->setCellValue('D' . $row, $dato->fecha_actual);
            $row++;
        }

        // Establecer el nombre del archivo
        $filename = 'datos_germinadores_' . date('Y-m-d') . '.xlsx';

        // Configurar el encabezado de la respuesta
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Crear un escritor para el archivo y guardarlo en la salida
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Método para mostrar la lista de germinadores
    public function listGerminadores()
    {
        $germinadores = DB::table('germinadores')->get();
        return view('germinadores.list', compact('germinadores'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('germinadores.create');
    }

    // Método para almacenar un nuevo germinador
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');

        // Insertar el germinador en la base de datos
        DB::table('germinadores')->insert([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear las tablas correspondientes para el germinador
        Schema::create("{$nombre}_luz", function (Blueprint $table) {
            $table->id();
            $table->float('luz');
            $table->timestamp('fecha_actual')->useCurrent();
        });

        Schema::create("{$nombre}_humedad", function (Blueprint $table) {
            $table->id();
            $table->float('humedad');
            $table->timestamp('fecha_actual')->useCurrent();
        });

        Schema::create("{$nombre}_temperatura", function (Blueprint $table) {
            $table->id();
            $table->float('temperatura');
            $table->timestamp('fecha_actual')->useCurrent();
        });

        Schema::create("{$nombre}_fotos", function (Blueprint $table) {
            $table->id();
            $table->string('ruta_foto');
            $table->timestamp('fecha_actual')->useCurrent();
        });

        return redirect()->route('germinadores.list')->with('success', 'Germinador creado exitosamente.');
    }

    public function show($nombre)
{
    // Sanitizar el nombre del germinador
    $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($nombre));

    // Verificar si las tablas existen
    if (!Schema::hasTable("{$nombre_sanitizado}_luz") ||
        !Schema::hasTable("{$nombre_sanitizado}_humedad") ||
        !Schema::hasTable("{$nombre_sanitizado}_temperatura") ||
        !Schema::hasTable("{$nombre_sanitizado}_fotos")) {
        return redirect()->route('germinadores.index')->with('error', 'El germinador no existe o sus tablas no han sido creadas.');
    }

    // Obtener datos de las tablas
    $luz = DB::table("{$nombre_sanitizado}_luz")->get();
    $humedad = DB::table("{$nombre_sanitizado}_humedad")->get();
    $temperatura = DB::table("{$nombre_sanitizado}_temperatura")->get();
    $fotos = DB::table("{$nombre_sanitizado}_fotos")->get();

    // Retornar vista con los datos
    return view('germinadores.show', compact('luz', 'humedad', 'temperatura', 'fotos', 'nombre'));
}



}