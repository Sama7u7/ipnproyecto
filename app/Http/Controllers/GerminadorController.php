<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class GerminadorController extends Controller
{
   
 //FUNCION EXPORT EXCEL SIRVE PARA OBTENER LOS DATOS DE UN GERMINADOR EN ESPECIFICO Y VOLCARLOS A UN EXCEL 
    public function exportExcel($nombre)
{
    // Sanitizar el nombre del germinador
    $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($nombre));

    // Obtener los datos de la tabla de temperatura y humedad para el germinador especificado
    $datos = DB::table("{$nombre_sanitizado}_temperatura_humedad")->get();

    // Obtener los datos de la tabla de luz para el germinador especificado
    $datosluz = DB::table("{$nombre_sanitizado}_luz")->get();

    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Establecer los encabezados
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Temperatura');
    $sheet->setCellValue('C1', 'Humedad');
    $sheet->setCellValue('D1', 'Luz');
    $sheet->setCellValue('E1', 'Fecha');

    // Escribir los datos de temperatura y humedad en el archivo
    $row = 2; // Comenzar en la fila 2 para no sobrescribir los encabezados
    foreach ($datos as $dato) {
        $sheet->setCellValue('A' . $row, (int)$dato->id);
        $sheet->setCellValue('B' . $row, $dato->temperatura);
        $sheet->setCellValue('C' . $row, $dato->humedad);
        $sheet->setCellValue('E' . $row, $dato->fecha_actual);
        $row++;
    }

    // Escribir los datos de luz en el archivo
    $row = 2; // Resetear la fila para empezar en la columna de luz
    foreach ($datosluz as $dato) {
        $sheet->setCellValue('D' . $row, $dato->luz);
        $row++;
    }

    // Establecer el nombre del archivo
    $filename = 'datos_germinadores_' . $nombre_sanitizado . '_' . date('Y-m-d') . '.xlsx';

    // Configurar el encabezado de la respuesta
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Crear un escritor para el archivo y guardarlo en la salida
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}


    // Método para mostrar la lista de TODOS los germinadores
    public function listGerminadores()
    {
        $germinadores = DB::table('germinadores')->get();
        return view('germinadores.list', compact('germinadores'));
    }

    // Método para mostrar el formulario de creación de un nuevo germinador
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
            $table->char('luz');
            $table->timestamp('fecha_actual')->useCurrent();
        });
    
        Schema::create("{$nombre}_temperatura_humedad", function (Blueprint $table) {
            $table->id();
            $table->char('temperatura');
            $table->char('humedad');
            $table->timestamp('fecha_actual')->useCurrent();
        });
    
        Schema::create("{$nombre}_fotos", function (Blueprint $table) {
            $table->id();
            $table->string('ruta_foto');
            $table->timestamp('fecha_actual')->useCurrent();
        });
    
        // Crear el controlador dinámicamente
        $nombreControlador = ucfirst($nombre) . 'Controller';
        Artisan::call('make:controller', [
            'name' => $nombreControlador
        ]);
    
        // Ruta del nuevo controlador
        $controllerPath = app_path("Http/Controllers/{$nombreControlador}.php");
        
        // Método para recibir datos del ESP32
        $controllerContent = <<<EOD
        <?php
        
        namespace App\Http\Controllers;
        
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\DB;
        
        class {$nombreControlador} extends Controller
        {
            public function receiveData(Request \$request, \$nombre)
            {
                // Validar los datos que recibes del ESP32
                \$request->validate([
                    'temperatura' => 'required|numeric',
                    'humedad' => 'required|numeric',
                    'luz' => 'required|numeric',
                ]);
        
                // Obtener los datos
                \$temperatura = \$request->input('temperatura');
                \$humedad = \$request->input('humedad');
                \$luz = \$request->input('luz');
        
                // Insertar los datos en la base de datos
                DB::table("{$nombre}_temperatura_humedad")->insert([
                    'temperatura' => \$temperatura,
                    'humedad' => \$humedad,
                    'fecha_actual' => now(),
                ]);
        
                DB::table("{$nombre}_luz")->insert([
                    'luz' => \$luz,
                    'fecha_actual' => now(),
                ]);
        
                return response()->json(['success' => 'Datos recibidos correctamente.']);
            }
        }
        EOD;
        
        // Escribir el contenido en el archivo del controlador
        File::put($controllerPath, $controllerContent);
    
        return redirect()->route('germinadores.list')->with('success', 'Germinador y controlador creados exitosamente.');
    }
    //FUNCION SHOW SIRVE PARA MOSTRAR LOS DATOS DE UN GERMINADOR EN ESPECIFICO AL PRESIONAR EL BOTON VER DATOS 
    public function show($nombre)
{
    // Sanitizar el nombre del germinador
    $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($nombre));

    // Verificar si las tablas existen
    if (!Schema::hasTable("{$nombre_sanitizado}_luz") ||
        !Schema::hasTable("{$nombre_sanitizado}_temperatura_humedad") ||
        !Schema::hasTable("{$nombre_sanitizado}_fotos")) {
        return redirect()->route('germinadores.list')->with('error', 'El germinador no existe o sus tablas no han sido creadas.');
    }

    // Obtener datos de las tablas
    $luz = DB::table("{$nombre_sanitizado}_luz")->get();
    $temperatura_humedad = DB::table("{$nombre_sanitizado}_temperatura_humedad")->get();
    $fotos = DB::table("{$nombre_sanitizado}_fotos")->get();
    $ultimo_dato = DB::table("{$nombre_sanitizado}_temperatura_humedad")->latest('fecha_actual')->first();
    $ultimo_dato_bh1750 = DB::table("{$nombre_sanitizado}_luz")->latest('fecha_actual')->first();

    // Retornar vista con los datos
    return view('germinadores.show', compact('luz','temperatura_humedad', 'fotos', 'nombre','ultimo_dato','ultimo_dato_bh1750'));
}



}