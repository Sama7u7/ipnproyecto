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

    //COMIENZA FUNCION EXPORT EXCEL

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

    //TERMINA FUNCION EXPORT EXCEL
    //COMIENZA FUNCION  LIST GERMINADORES


    // Método para mostrar la lista de TODOS los germinadores
    public function listGerminadores()
    {
        $germinadores = DB::table('germinadores')->get();
        return view('germinadores.list', compact('germinadores'));
    }

    //TERMINA FUNCION  LIST GERMINADORES
    //COMIENZA FUNCION CREATE

    // Método para mostrar el formulario de creación de un nuevo germinador
    public function create()
    {
        return view('germinadores.create');
    }

    //TERMINA FUNCION CREATE
    //COMIENZA FUNCION STORE

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
        DB::table('germinadores')->insert([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear las tablas correspondientes para el germinador con el nombre en minúsculas
        Schema::create("{$nombre_min}_luz", function (Blueprint $table) {
            $table->id();
            $table->char('luz');
            $table->timestamp('fecha_actual')->useCurrent();
        });

        Schema::create("{$nombre_min}_temperatura_humedad", function (Blueprint $table) {
            $table->id();
            $table->char('temperatura');
            $table->char('humedad');
            $table->timestamp('fecha_actual')->useCurrent();
        });

        Schema::create("{$nombre_min}_fotos", function (Blueprint $table) {
            $table->id();
            $table->string('ruta_foto');
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
                Route::post("/germinadores/{$nombre_min}/data", [self::class, 'receiveData'])
                    ->name("germinadores.{$nombre_min}.data");
            }

            public function receiveData(Request \$request)
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

                // Insertar los datos en la base de datos, usando el nombre en minúsculas para las tablas
                DB::table("{$nombre_min}_temperatura_humedad")->insert([
                    'temperatura' => \$temperatura,
                    'humedad' => \$humedad,
                    'fecha_actual' => now(),
                ]);

                DB::table("{$nombre_min}_luz")->insert([
                    'luz' => \$luz,
                    'fecha_actual' => now(),
                ]);

                return response()->json(['success' => 'Datos recibidos correctamente.']);
            }
        }
        EOD;

        // Escribir el contenido en el archivo del controlador
        File::put($controllerPath, $controllerContent);

        return redirect()->route('dashboard')->with('success', 'Germinador y controlador creados exitosamente.');
    }

    //TERMINA FUNCION STORE
    //COMIENZA FUNCION SHOW

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
    //TERMINA FUNCION SHOW
    //COMIENZA FUNCION SHOWBACK

public function showback($nombre)
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
    return view('admin.mostrarGerminador', compact('luz','temperatura_humedad', 'fotos', 'nombre','ultimo_dato','ultimo_dato_bh1750'));
}
 //TERMINA FUNCION SHOWBACK
 //COMIENZA FUNCION EDIT

public function edit($id)
    {
        // Obtener el germinador de la base de datos
        $germinador = DB::table('germinadores')->where('id', $id)->first();

        if (!$germinador) {
            return redirect()->route('dashboard')->with('error', 'Germinador no encontrado.');
        }

        return view('admin.editarGerminador', compact('germinador'));
    }


        //TERMINA FUNCION EDIT
        //COMIENZA FUNCION UPDATE

        public function update(Request $request, $id)
        {
            // Validar los datos del formulario
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
            ]);

            // Obtener el germinador actual
            $germinador = DB::table('germinadores')->where('id', $id)->first();
            if (!$germinador) {
                return redirect()->route('dashboard')->with('error', 'Germinador no encontrado.');
            }

            $oldName = strtolower($germinador->nombre); // Nombre actual antes de la actualización
            $newName = strtolower($request->nombre);    // Nuevo nombre del germinador

            // Actualizar el germinador en la base de datos
            DB::table('germinadores')
                ->where('id', $id)
                ->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'updated_at' => now(),
                ]);

            // Renombrar las tablas asociadas
            $this->renameTables($oldName, $newName);

            // Actualizar el contenido del controlador dinámico
            $this->updateControllerContent($oldName, $newName);

            return redirect()->route('dashboard')->with('success', 'Germinador y sus recursos actualizados con éxito.');
        }

        //TERMINA FUNCION UPDATE
        //COMIENZA FUNCION RENAMETABLES
        private function renameTables($oldName, $newName)
        {
            $tables = [
                "{$oldName}_luz" => "{$newName}_luz",
                "{$oldName}_temperatura_humedad" => "{$newName}_temperatura_humedad",
                "{$oldName}_fotos" => "{$newName}_fotos",
            ];

            foreach ($tables as $oldTable => $newTable) {
                if (Schema::hasTable($oldTable)) {
                    DB::statement("RENAME TABLE {$oldTable} TO {$newTable}");
                }
            }
        }



        //TERMINA FUNCION RENAMETABLES
        //COMIENZA FUNCION UPDATEcontrollerContent

        public function updateControllerContent($oldName, $newName)
        {
            // Formatear los nombres para asegurarse de que sean válidos
            $oldNameSanitized = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $oldName));
            $newNameSanitized = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $newName));

            $oldControllerName = ucfirst($oldNameSanitized) . 'Controller';
            $newControllerName = ucfirst($newNameSanitized) . 'Controller';

            $oldControllerPath = app_path("Http/Controllers/{$oldControllerName}.php");
            $newControllerPath = app_path("Http/Controllers/{$newControllerName}.php");

            if (File::exists($oldControllerPath)) {
                // Leer el contenido del controlador existente
                $controllerContent = File::get($oldControllerPath);

                // Actualizar el contenido del controlador
                $updatedContent = <<<EOD
                <?php

                namespace App\Http\Controllers;

                use Illuminate\Http\Request;
                use Illuminate\Support\Facades\DB;
                use Illuminate\Support\Facades\Route;

                class {$newControllerName} extends Controller
                {
                    public function __construct()
                    {
                        // Crear la ruta para recibir los datos directamente en este controlador usando el nombre actualizado
                        Route::post("/germinadores/{$newNameSanitized}/data", [self::class, 'receiveData'])
                            ->name("germinadores.{$newNameSanitized}.data");
                    }

                    public function receiveData(Request \$request)
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
                        DB::table("{$newNameSanitized}_temperatura_humedad")->insert([
                            'temperatura' => \$temperatura,
                            'humedad' => \$humedad,
                            'fecha_actual' => now(),
                        ]);

                        DB::table("{$newNameSanitized}_luz")->insert([
                            'luz' => \$luz,
                            'fecha_actual' => now(),
                        ]);

                        return response()->json(['success' => 'Datos recibidos correctamente.']);
                    }
                }
                EOD;

                // Guardar el nuevo archivo con el nombre actualizado
                File::put($newControllerPath, $updatedContent);

                // Eliminar el archivo viejo si el nombre cambió
                if ($oldControllerPath !== $newControllerPath) {
                    File::delete($oldControllerPath);
                }
            }
        }


        //TERMINA FUNCION UPDATE
    //COMIENZA FUNCION DESTROY

    public function destroy($id)
{
    // Obtener el germinador de la base de datos
    $germinador = DB::table('germinadores')->where('id', $id)->first();

    if (!$germinador) {
        return redirect()->route('germinadores.index')->with('error', 'Germinador no encontrado.');
    }

    // Sanitizar el nombre del germinador
    $nombre_sanitizado = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($germinador->nombre));

    // Eliminar las tablas relacionadas con el germinador
    if (Schema::hasTable("{$nombre_sanitizado}_luz")) {
        Schema::dropIfExists("{$nombre_sanitizado}_luz");
    }

    if (Schema::hasTable("{$nombre_sanitizado}_temperatura_humedad")) {
        Schema::dropIfExists("{$nombre_sanitizado}_temperatura_humedad");
    }

    if (Schema::hasTable("{$nombre_sanitizado}_fotos")) {
        Schema::dropIfExists("{$nombre_sanitizado}_fotos");
    }

    // Eliminar el controlador dinámico
    $controllerPath = app_path("Http/Controllers/{$nombre_sanitizado}Controller.php");
    if (File::exists($controllerPath)) {
        File::delete($controllerPath);
    }

    // Eliminar el germinador de la base de datos
    DB::table('germinadores')->where('id', $id)->delete();

    // Redirigir con un mensaje de éxito
    return redirect()->route('dashboard')->with('success', 'Germinador y sus recursos eliminados con éxito.');
}



}