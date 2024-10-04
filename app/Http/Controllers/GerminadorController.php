<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

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
    


    
}
