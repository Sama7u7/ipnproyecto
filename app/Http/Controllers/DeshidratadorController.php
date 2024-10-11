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

class DeshidratadorController extends Controller
{
    
    
 //FUNCION EXPORT EXCEL SIRVE PARA OBTENER LOS DATOS DE UN GERMINADOR EN ESPECIFICO Y VOLCARLOS A UN EXCEL 
 public function exportExcel($nombre)
 {
     // Sanitizar el nombre del germinador
     $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($nombre));
 
     // Obtener los datos de la tabla de temperatura y humedad para el germinador especificado
     $datosdh1 = DB::table("{$nombre_sanitizado}_dht1")->get();
     $datosdh2 = DB::table("{$nombre_sanitizado}_dht2")->get();
     $datosdh3 = DB::table("{$nombre_sanitizado}_dht3")->get();
     
     // Obtener los datos de la tabla de luz para el germinador especificado
     $datospeso = DB::table("{$nombre_sanitizado}_peso")->get();
 
     // Crear un nuevo objeto Spreadsheet
     $spreadsheet = new Spreadsheet();
     $sheet = $spreadsheet->getActiveSheet();
 
     // Establecer los encabezados
     $sheet->setCellValue('A1', 'ID');
     $sheet->setCellValue('B1', 'Temperatura');
     $sheet->setCellValue('C1', 'Humedad');
     $sheet->setCellValue('D1', 'Fecha');
     $sheet->setCellValue('F1', 'ID');
     $sheet->setCellValue('G1', 'Temperatura');
     $sheet->setCellValue('H1', 'Humedad');
     $sheet->setCellValue('I1', 'Fecha');
     $sheet->setCellValue('K1', 'ID');
     $sheet->setCellValue('L1', 'Temperatura');
     $sheet->setCellValue('M1', 'Humedad');
     $sheet->setCellValue('N1', 'Fecha');
     $sheet->setCellValue('P1', 'ID');
     $sheet->setCellValue('Q1', 'Peso');
     $sheet->setCellValue('R1', 'Fecha');
     
 
     // Escribir los datos de temperatura y humedad en el archivo
     $row = 2; // Comenzar en la fila 2 para no sobrescribir los encabezados
     foreach ($datosdh1 as $dato) {
         $sheet->setCellValue('A' . $row, (int)$dato->id);
         $sheet->setCellValue('B' . $row, $dato->temperatura);
         $sheet->setCellValue('C' . $row, $dato->humedad);
         $sheet->setCellValue('D' . $row, $dato->fecha_actual);
         $row++;
     }
        // Escribir los datos de temperatura y humedad en el archivo
        $row = 2; // Comenzar en la fila 2 para no sobrescribir los encabezados
        foreach ($datosdh1 as $dato) {
            $sheet->setCellValue('F' . $row, (int)$dato->id);
            $sheet->setCellValue('G' . $row, $dato->temperatura);
            $sheet->setCellValue('H' . $row, $dato->humedad);
            $sheet->setCellValue('I' . $row, $dato->fecha_actual);
            $row++;
        }

           // Escribir los datos de temperatura y humedad en el archivo
     $row = 2; // Comenzar en la fila 2 para no sobrescribir los encabezados
     foreach ($datosdh1 as $dato) {
         $sheet->setCellValue('K' . $row, (int)$dato->id);
         $sheet->setCellValue('L' . $row, $dato->temperatura);
         $sheet->setCellValue('M' . $row, $dato->humedad);
         $sheet->setCellValue('N' . $row, $dato->fecha_actual);
         $row++;
     }
 
     // Escribir los datos de luz en el archivo
     $row = 2; // Resetear la fila para empezar en la columna de luz
     foreach ($datospeso as $dato) {
         $sheet->setCellValue('P' . $row, $dato->id);
         $sheet->setCellValue('Q' . $row, $dato->peso);
         $sheet->setCellValue('R' . $row, $dato->fecha);
         $row++;
     }
 
     // Establecer el nombre del archivo
     $filename = 'datos_deshidratador_' . $nombre_sanitizado . '_' . date('Y-m-d') . '.xlsx';
 
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
     public function listDeshidratadores()
     {
         $deshidratadores = DB::table('deshidratadores')->get();
         return view('deshidratadores.list', compact('deshidratadores'));
     }
 
     // Método para mostrar el formulario de creación de un nuevo germinador
     public function create()
     {
         return view('deshidratadores.create');
     }
 
     // Método para almacenar un nuevo germinador
     public function store(Request $request)
     {
         // Validar los datos
         $request->validate([
             'nombre' => 'required|string|max:255',
             'descripcion' => 'required|string',
         ]);
 
         // Obtener el nombre y la descripción del germinador
         $nombre = $request->input('nombre');
         $descripcion = $request->input('descripcion');
 
         // Convertir el nombre del germinador a minúsculas
         $nombre_min = strtolower($nombre);
 
         // Insertar el germinador en la base de datos (guardando el nombre tal cual, no en minúsculas)
         DB::table('deshidratadores')->insert([
             'nombre' => $nombre,
             'descripcion' => $descripcion,
             'created_at' => now(),
             'updated_at' => now(),
         ]);
 
         // Crear las tablas correspondientes para el germinador con el nombre en minúsculas
         Schema::create("{$nombre_min}_peso", function (Blueprint $table) {
             $table->id();
             $table->char('peso');
             $table->timestamp('fecha_actual')->useCurrent();
         });
 
         Schema::create("{$nombre_min}_dht1", function (Blueprint $table) {
             $table->id();
             $table->char('temperatura');
             $table->char('humedad');
             $table->timestamp('fecha_actual')->useCurrent();
         });
         
         Schema::create("{$nombre_min}_dht2", function (Blueprint $table) {
            $table->id();
            $table->char('temperatura');
            $table->char('humedad');
            $table->timestamp('fecha_actual')->useCurrent();
        });
        
        Schema::create("{$nombre_min}_dht3", function (Blueprint $table) {
            $table->id();
            $table->char('temperatura');
            $table->char('humedad');
            $table->timestamp('fecha_actual')->useCurrent();
        });
 
       
         // Crear el controlador dinámicamente con el nombre en minúsculas
         $nombreControlador = ucfirst($nombre_min) . 'Controller';
         Artisan::call('make:controller', [
             'name' => $nombreControlador
         ]);
 
         // Ruta del nuevo controlador
         $controllerPath = app_path("Http/Controllers/{$nombreControlador}.php");
 
         // Contenido del controlador, incluyendo las rutas específicas dentro del propio controlador y usando el nombre en minúsculas
         $controllerContent = <<<EOD
         <?php
         
         namespace App\Http\Controllers;
         
         use Illuminate\Http\Request;
         use Illuminate\Support\Facades\DB;
         use Illuminate\Support\Facades\Route;
 
         class {$nombreControlador} extends Controller
         {
             public function __construct()
             {
                 // Crear la ruta para recibir los datos directamente en este controlador usando el nombre en minúsculas
                 Route::post("/deshidrtadores/{$nombre_min}/data", [self::class, 'receiveData'])
                     ->name("deshidrtadores.{$nombre_min}.data");
             }
 
             public function receiveData(Request \$request)
             {
                 // Validar los datos que recibes del ESP32
                 \$request->validate([
                     'temperatura' => 'required|numeric',
                     'humedad' => 'required|numeric',
                     'luz' => 'required|numeric',
                     'peso' => 'required|numeric',
                 ]);
 
                 // Obtener los datos
                 \$temperatura = \$request->input('temperatura');
                 \$humedad = \$request->input('humedad');
                 \$luz = \$request->input('luz');
                 \$peso = \$request->input('peso');
 
                 // Insertar los datos en la base de datos, usando el nombre en minúsculas para las tablas
                 DB::table("{$nombre_min}_dht1")->insert([
                     'temperatura' => \$temperatura,
                     'humedad' => \$humedad,
                     'fecha_actual' => now(),
                 ]);

                    
                 DB::table("{$nombre_min}_dht2")->insert([
                     'temperatura' => \$temperatura,
                     'humedad' => \$humedad,
                     'fecha_actual' => now(),
                 ]);

                  DB::table("{$nombre_min}_dht3")->insert([
                     'temperatura' => \$temperatura,
                     'humedad' => \$humedad,
                     'fecha_actual' => now(),
                 ]);

                  DB::table("{$nombre_min}_peso")->insert([
                     'peso' => \$peso,
                     'fecha_actual' => now(),
                 ]);
 
 
 
                 return response()->json(['success' => 'Datos recibidos correctamente.']);
             }
         }
         EOD;
 
         // Escribir el contenido en el archivo del controlador
         File::put($controllerPath, $controllerContent);
 
         return redirect()->route('deshidratadores.list')->with('success', 'Deshidratador y controlador creados exitosamente.');
     }
 
 
 
     //FUNCION SHOW SIRVE PARA MOSTRAR LOS DATOS DE UN DESHIDRATADOR EN ESPECIFICO AL PRESIONAR EL BOTON VER DATOS 
     public function show($nombre)
 {
     // Sanitizar el nombre del germinador
     $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($nombre));
 
     // Verificar si las tablas existen
     if (!Schema::hasTable("{$nombre_sanitizado}_dht1") ||
         !Schema::hasTable("{$nombre_sanitizado}_dht2") ||
         !Schema::hasTable("{$nombre_sanitizado}_dht3") ||
         !Schema::hasTable("{$nombre_sanitizado}_peso")) {
         return redirect()->route('deshidratadores.list')->with('error', 'El germinador no existe o sus tablas no han sido creadas.');
     }
 
     // Obtener datos de las tablas
     $peso = DB::table("{$nombre_sanitizado}_peso")->get();
     $dht1 = DB::table("{$nombre_sanitizado}_dht1")->get();
     $dht2 = DB::table("{$nombre_sanitizado}_dht2")->get();
     $dht3 = DB::table("{$nombre_sanitizado}_dht3")->get();
     
     $ultimo_dato_dht1 = DB::table("{$nombre_sanitizado}_dht1")->latest('fecha_actual')->first();
     $ultimo_dato_dht2 = DB::table("{$nombre_sanitizado}_dht2")->latest('fecha_actual')->first();
     $ultimo_dato_dht3 = DB::table("{$nombre_sanitizado}_dht3")->latest('fecha_actual')->first();
     $ultimo_dato_peso = DB::table("{$nombre_sanitizado}_peso")->latest('fecha_actual')->first();
 
     // Retornar vista con los datos
     return view('deshidratadores.show', compact('nombre','peso','dht1', 'dht2', 'dht3','ultimo_dato_dht1','ultimo_dato_dht2','ultimo_dato_dht1','ultimo_dato_dht2','ultimo_dato_dht3','ultimo_dato_peso'));
 }
 
 
 
}
