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
    // Método para exportar los datos de un deshidratador a Excel
    public function exportExcel($nombre)
    {
        // Sanitizar el nombre del deshidratador
        $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($nombre));

        // Obtener los datos de las tablas de los sensores DHT22 y peso
        $datosdh1 = DB::table("{$nombre_sanitizado}_dht1")->get();
        $datosdh2 = DB::table("{$nombre_sanitizado}_dht2")->get();
        $datosdh3 = DB::table("{$nombre_sanitizado}_dht3")->get();
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

        // Escribir los datos de temperatura y humedad para cada tabla
        $row = 2;
        foreach ($datosdh1 as $dato) {
            $sheet->setCellValue('A' . $row, $dato->id);
            $sheet->setCellValue('B' . $row, $dato->temperatura);
            $sheet->setCellValue('C' . $row, $dato->humedad);
            $sheet->setCellValue('D' . $row, $dato->fecha_actual);
            $row++;
        }

        $row = 2;
        foreach ($datosdh2 as $dato) {
            $sheet->setCellValue('F' . $row, $dato->id);
            $sheet->setCellValue('G' . $row, $dato->temperatura);
            $sheet->setCellValue('H' . $row, $dato->humedad);
            $sheet->setCellValue('I' . $row, $dato->fecha_actual);
            $row++;
        }

        $row = 2;
        foreach ($datosdh3 as $dato) {
            $sheet->setCellValue('K' . $row, $dato->id);
            $sheet->setCellValue('L' . $row, $dato->temperatura);
            $sheet->setCellValue('M' . $row, $dato->humedad);
            $sheet->setCellValue('N' . $row, $dato->fecha_actual);
            $row++;
        }

        // Escribir los datos de peso
        $row = 2;
        foreach ($datospeso as $dato) {
            $sheet->setCellValue('P' . $row, $dato->id);
            $sheet->setCellValue('Q' . $row, $dato->peso);
            $sheet->setCellValue('R' . $row, $dato->fecha_actual);
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

    // Método para mostrar la lista de TODOS los deshidratadores
    public function listDeshidratadores()
    {
        $deshidratadores = DB::table('deshidratadores')->get();
        return view('deshidratadores.list', compact('deshidratadores'));
    }

    // Método para mostrar el formulario de creación de un nuevo deshidratador
    public function create()
    {
        return view('deshidratadores.create');
    }

    // Método para almacenar un nuevo deshidratador
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        // Obtener el nombre y la descripción del deshidratador
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $nombre_min = strtolower($nombre);

        // Insertar el deshidratador en la base de datos
        DB::table('deshidratadores')->insert([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear las tablas correspondientes para el deshidratador
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

        // Crear el controlador dinámicamente con el nombre del deshidratador
        $nombreControlador = ucfirst($nombre_min) . 'Controller';
        Artisan::call('make:controller', ['name' => $nombreControlador]);

        // Ruta del nuevo controlador
        $controllerPath = app_path("Http/Controllers/{$nombreControlador}.php");

        // Contenido del controlador
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
                Route::post("/deshidratadores/{$nombre_min}/data", [self::class, 'receiveData'])
                    ->name("deshidratadores.{$nombre_min}.data");
            }

            public function receiveData(Request \$request)
            {
                // Validar los datos
                \$request->validate([
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
                    'temperatura' => \$request->input('temperatura1'),
                    'humedad' => \$request->input('humedad1'),
                    'fecha_actual' => now(),
                ]);

                // Insertar los datos del segundo sensor DHT22 en la tabla dht2
                DB::table("{$nombre_min}_dht2")->insert([
                    'temperatura' => \$request->input('temperatura2'),
                    'humedad' => \$request->input('humedad2'),
                    'fecha_actual' => now(),
                ]);

                // Insertar los datos del tercer sensor DHT22 en la tabla dht3
                DB::table("{$nombre_min}_dht3")->insert([
                    'temperatura' => \$request->input('temperatura3'),
                    'humedad' => \$request->input('humedad3'),
                    'fecha_actual' => now(),
                ]);


                // Insertar los datos del sensor de peso (HX711)
                DB::table("{$nombre_min}_peso")->insert([
                    'peso' => \$request->input('peso'),
                    'fecha_actual' => now(),
                ]);

                return response()->json(['message' => 'Datos recibidos correctamente.'], 200);
            }
        }
        EOD;

        // Guardar el controlador con su contenido
        File::put($controllerPath, $controllerContent);

        // Redirigir a la lista de deshidratadores
        return redirect()->route('dashboard')->with('success', 'Deshidratador creado exitosamente.');
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

  // Método para editar un deshidratador
  public function edit($id)
  {
      $deshidratador = DB::table('deshidratadores')->where('id', $id)->first();
      return view('admin.editarDeshidratador', compact('deshidratador'));
  }

  // Método para actualizar un deshidratador
  public function update(Request $request, $id)
  {
      // Validar los datos
      $request->validate([
          'nombre' => 'required|string|max:255',
          'descripcion' => 'required|string',
      ]);

      $nombre = $request->input('nombre');
      $descripcion = $request->input('descripcion');

      // Actualizar los datos del deshidratador en la base de datos
      DB::table('deshidratadores')
          ->where('id', $id)
          ->update([
              'nombre' => $nombre,
              'descripcion' => $descripcion,
              'updated_at' => now(),
          ]);

      return redirect()->route('dashboard')->with('success', 'Deshidratador actualizado exitosamente.');
  }

  // Método para eliminar un deshidratador
  public function destroy($id)
{
    // Obtener el deshidratador de la base de datos
    $deshidratador = DB::table('deshidratadores')->where('id', $id)->first();

    if (!$deshidratador) {
        return redirect()->route('deshidratadores.index')->with('error', 'Deshidratador no encontrado.');
    }

    // Sanitizar el nombre del deshidratador
    $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($deshidratador->nombre));

    // Eliminar las tablas relacionadas con el deshidratador
    if (Schema::hasTable("{$nombre_sanitizado}_peso")) {
        Schema::dropIfExists("{$nombre_sanitizado}_peso");
    }

    if (Schema::hasTable("{$nombre_sanitizado}_dht1")) {
        Schema::dropIfExists("{$nombre_sanitizado}_dht1");
    }

    if (Schema::hasTable("{$nombre_sanitizado}_dht2")) {
        Schema::dropIfExists("{$nombre_sanitizado}_dht2");
    }

    if (Schema::hasTable("{$nombre_sanitizado}_dht3")) {
        Schema::dropIfExists("{$nombre_sanitizado}_dht3");
    }

    // Eliminar el controlador dinámico
    $controllerPath = app_path("Http/Controllers/{$nombre_sanitizado}Controller.php");
    if (File::exists($controllerPath)) {
        File::delete($controllerPath);
    }

    // Eliminar el deshidratador de la base de datos
    DB::table('deshidratadores')->where('id', $id)->delete();

    // Redirigir con un mensaje de éxito
    return redirect()->route('dashboard')->with('success', 'Deshidratador y sus recursos eliminados con éxito.');
}



}
