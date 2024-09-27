<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\Tb_DHT22;  // Asegúrate de tener el modelo correcto
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportController implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Tb_DHT22::all(); // Aquí retornamos todos los datos de la tabla
    }
}
