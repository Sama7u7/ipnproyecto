@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Sensor 1 -->
            <div class="card">
                <h2>Sensor 1</h2>
                <p><strong>Temperatura:</strong> {{ isset($ultimo_dato_dht1->Temperatura) ? $ultimo_dato_dht1->Temperatura . " °C" : "Sin datos" }}</p>
                <p><strong>Humedad:</strong> {{ isset($ultimo_dato_dht1->Humedad) ? $ultimo_dato_dht1->Humedad . " %" : "Sin datos" }}</p>
            </div>

            <!-- Sensor 2 -->
            <div class="card">
                <h2>Sensor 2</h2>
                <p><strong>Temperatura:</strong> {{ isset($ultimo_dato_dht2->Temperatura) ? $ultimo_dato_dht2->Temperatura . " °C" : "Sin datos" }}</p>
                <p><strong>Humedad:</strong> {{ isset($ultimo_dato_dht2->Humedad) ? $ultimo_dato_dht2->Humedad . " %" : "Sin datos" }}</p>
            </div>

            <!-- Sensor 3 -->
            <div class="card">
                <h2>Sensor 3</h2>
                <p><strong>Temperatura:</strong> {{ isset($ultimo_dato_dht3->Temperatura) ? $ultimo_dato_dht3->Temperatura . " °C" : "Sin datos" }}</p>
                <p><strong>Humedad:</strong> {{ isset($ultimo_dato_dht3->Humedad) ? $ultimo_dato_dht3->Humedad . " %" : "Sin datos" }}</p>
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
                            @foreach ($resultado_todos_dht1 as $row)
                                <tr>
                                    <td>{{ $row->Temperatura }} °C</td>
                                    <td>{{ $row->Humedad }} %</td>
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
                            @foreach ($resultado_todos_dht2 as $row)
                                <tr>
                                    <td>{{ $row->Temperatura }} °C</td>
                                    <td>{{ $row->Humedad }} %</td>
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
                            @foreach ($resultado_todos_dht3 as $row)
                                <tr>
                                    <td>{{ $row->Temperatura }} °C</td>
                                    <td>{{ $row->Humedad }} %</td>
                                    <td>{{ $row->fecha_actual }}</td>
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
