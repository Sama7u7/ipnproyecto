@extends('layouts.appback')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h2 style="text-align: center;">Datos del deshidratador: {{ $nombre }}</h2>
        <br>

            <!-- Sensor 1 -->
            <div class="card">
                <h2>Sensor 1</h2>
                <p><strong>Temperatura:</strong> {{ isset($ultimo_dato_dht1->temperatura) ? $ultimo_dato_dht1->temperatura . " °C" : "Sin datos" }}</p>
                <p><strong>Humedad:</strong> {{ isset($ultimo_dato_dht1->humedad) ? $ultimo_dato_dht1->humedad . " %" : "Sin datos" }}</p>
            </div>

            <!-- Sensor 2 -->
            <div class="card">
                <h2>Sensor 2</h2>
                <p><strong>Temperatura:</strong> {{ isset($ultimo_dato_dht2->temperatura) ? $ultimo_dato_dht2->temperatura . " °C" : "Sin datos" }}</p>
                <p><strong>Humedad:</strong> {{ isset($ultimo_dato_dht2->humedad) ? $ultimo_dato_dht2->humedad . " %" : "Sin datos" }}</p>
            </div>

            <!-- Sensor 3 -->
            <div class="card">
                <h2>Sensor 3</h2>
                <p><strong>Temperatura:</strong> {{ isset($ultimo_dato_dht3->temperatura) ? $ultimo_dato_dht3->temperatura . " °C" : "Sin datos" }}</p>
                <p><strong>Humedad:</strong> {{ isset($ultimo_dato_dht3->humedad) ? $ultimo_dato_dht3->humedad . " %" : "Sin datos" }}</p>
            </div>
            <!-- Peso del deshidratador -->
            <div class="card">
                <h2>Ultimo peso general del Deshidratador</h2>
                <p><strong>Peso:</strong> {{ isset($ultimo_dato_pesogral->peso) ? $ultimo_dato_pesogral->peso . " kg" : "Sin datos" }}</p>
            </div>
            <!-- Peso del deshidratador -->
            <div class="card">
                <h2>Ultimo peso nivel del Deshidratador</h2>
                <p><strong>Peso:</strong>  {{ isset($ultimo_dato_pesolvl->peso) ? $ultimo_dato_pesolvl->peso . " kg" : "Sin datos" }}</p>
            </div>



            <div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
                <a href="{{ route('deshidratadores.exportExcel', ['nombre' => $nombre]) }}" class="btn btn-danger">Descargar Excel</a>
            </div>

            <h2 class="text-center">Historial de Datos</h2>

            <!-- Tabla para Sensor 1 -->
            <h3>Sensor 1</h3>
            <div class="table-container">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Temperatura</th>
                                <th>Humedad</th>
                                <th>Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dht1 as $row)
                                <tr>
                                    <td>{{ $row->temperatura }} °C</td>
                                    <td>{{ $row->humedad }} %</td>
                                    <td>{{ $row->fecha_actual }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabla para Sensor 2 -->
            <h3>Sensor 2</h3>
            <div class="table-container">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Temperatura</th>
                                <th>Humedad</th>
                                <th>Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dht2 as $row)
                                <tr>
                                    <td>{{ $row->temperatura }} °C</td>
                                    <td>{{ $row->humedad }} %</td>
                                    <td>{{ $row->fecha_actual }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabla para Sensor 3 -->
            <h3>Sensor 3</h3>
            <div class="table-container">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Temperatura</th>
                                <th>Humedad</th>
                                <th>Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dht3 as $row)
                                <tr>
                                    <td>{{ $row->temperatura }} °C</td>
                                    <td>{{ $row->humedad }} %</td>
                                    <td>{{ $row->fecha_actual }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


<!-- Tabla para Peso -->
<h3>Peso general  del Deshidratador</h3>
<div class="table-container">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Peso (kg)</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesogral as $row)  <!-- Asegúrate de que $peso sea un array o colección -->
                    <tr>
                        <td>{{ $row->peso }} kg</td>  <!-- Ajusta esta línea según la estructura de tu variable $peso -->
                        <td>{{ $row->fecha_actual }}</td>  <!-- Asumiendo que también tienes un campo 'fecha_actual' -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tabla para Peso -->
<h3>Peso nivel  del Deshidratador</h3>
<div class="table-container">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Peso (kg)</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesolvl as $row)  <!-- Asegúrate de que $peso sea un array o colección -->
                    <tr>
                        <td>{{ $row->peso }} kg</td>  <!-- Ajusta esta línea según la estructura de tu variable $peso -->
                        <td>{{ $row->fecha_actual }}</td>  <!-- Asumiendo que también tienes un campo 'fecha_actual' -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


        </div>
    </div>


</div>




<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #e9ecef;
    }
    .container {
        margin: 20px auto;
        max-width: 1200px;
    }
    .card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }
    h2, h3 {
        color: #6c1d45; /* Color del encabezado */
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #6c1d45; /* Color del encabezado de la tabla */
        color: white;
    }
    .table-container {
        margin-top: 20px; /* Espacio entre la sección de tarjetas y la tabla */
    }
    .table-responsive {
        max-height: 200px; /* Altura máxima para habilitar scroll vertical */
        overflow-y: auto; /* Scroll vertical */
        margin-bottom: 20px; /* Espacio entre tablas */
        border-radius: 8px; /* Bordes redondeados para la tabla */
        background: #f8f9fa; /* Fondo claro para el área de la tabla */
    }
</style>

@endsection

