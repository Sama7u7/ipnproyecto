@extends('layouts.app')

@section('content')
    <div class="container2">
        <!-- Sensor 1 -->
        <div class="card">
            <h2>Nivel 1</h2>
            <p><strong>Temperatura:</strong> <?php echo 25.3; ?> °C</p>
            <p><strong>Humedad:</strong> <?php echo 60; ?> %</p>
        </div>

        <!-- Sensor 2 -->
        <div class="card">
            <h2>Nivel 2</h2>
            <p><strong>Temperatura:</strong> <?php echo 22.7; ?> °C</p>
            <p><strong>Humedad:</strong> <?php echo 55; ?> %</p>
        </div>

        <!-- Sensor 3 -->
        <div class="card">
            <h2>Nivel 3</h2>
            <p><strong>Temperatura:</strong> <?php echo 26.1; ?> °C</p>
            <p><strong>Humedad:</strong> <?php echo 58; ?> %</p>
        </div>

        <h2>Historial de Datos</h2>

        <!-- Tabla para Sensor 1 -->
        <h3>Nivel 1</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Temperatura</th>
                        <th>Humedad</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>24.1 °C</td>
                        <td>62 %</td>
                        <td>2024-09-23 10:00</td>
                    </tr>
                    <tr>
                        <td>23.9 °C</td>
                        <td>61 %</td>
                        <td>2024-09-23 09:00</td>
                    </tr>
                    <!-- Añadir más filas si es necesario -->
                </tbody>
            </table>
        </div>

        <!-- Tabla para Sensor 2 -->
        <h3>Nivel 2</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Temperatura</th>
                        <th>Humedad</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>21.7 °C</td>
                        <td>54 %</td>
                        <td>2024-09-23 10:00</td>
                    </tr>
                    <tr>
                        <td>22.0 °C</td>
                        <td>56 %</td>
                        <td>2024-09-23 09:00</td>
                    </tr>
                    <!-- Añadir más filas si es necesario -->
                </tbody>
            </table>
        </div>

        <!-- Tabla para Sensor 3 -->
        <h3>Nivel 3</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Temperatura</th>
                        <th>Humedad</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>25.8 °C</td>
                        <td>59 %</td>
                        <td>2024-09-23 10:00</td>
                    </tr>
                    <tr>
                        <td>26.0 °C</td>
                        <td>58 %</td>
                        <td>2024-09-23 09:00</td>
                    </tr>
                    <!-- Añadir más filas si es necesario -->
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container2 {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .card {
            background: #cfb1bd;
            border: 1px solid #864361;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        h2 {
            color: #761345;
        }
        .table-container {
            max-height: 200px; /* Ajusta la altura según lo necesites */
            overflow: auto;
            margin-bottom: 40px;
            border: 1px solid #6c1d45;
            border-radius: 8px;
            background-color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #6c1d45;
            text-align: center;
        }
        th {
            background-color: #864361;
        }
        tbody tr:nth-child(even) {
            background-color: #cfb1bd;
        }
    </style>
    @endsection