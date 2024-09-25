@extends('layouts.app')




@section('content')
<div class="container">
    <!-- Sensor 1 -->
    <div class="card">
        <h2>Sensor 1</h2>
        <p><strong>Temperatura:</strong> <?php echo isset($ultimo_dato_dht1['Temperatura']) ? $ultimo_dato_dht1['Temperatura'] . " °C" : "Sin datos"; ?></p>
        <p><strong>Humedad:</strong> <?php echo isset($ultimo_dato_dht1['Humedad']) ? $ultimo_dato_dht1['Humedad'] . " %" : "Sin datos"; ?></p>
    </div>

    <!-- Sensor 2 -->
    <div class="card">
        <h2>Sensor 2</h2>
        <p><strong>Temperatura:</strong> <?php echo isset($ultimo_dato_dht2['Temperatura']) ? $ultimo_dato_dht2['Temperatura'] . " °C" : "Sin datos"; ?></p>
        <p><strong>Humedad:</strong> <?php echo isset($ultimo_dato_dht2['Humedad']) ? $ultimo_dato_dht2['Humedad'] . " %" : "Sin datos"; ?></p>
    </div>

    <!-- Sensor 3 -->
    <div class="card">
        <h2>Sensor 3</h2>
        <p><strong>Temperatura:</strong> <?php echo isset($ultimo_dato_dht3['Temperatura']) ? $ultimo_dato_dht3['Temperatura'] . " °C" : "Sin datos"; ?></p>
        <p><strong>Humedad:</strong> <?php echo isset($ultimo_dato_dht3['Humedad']) ? $ultimo_dato_dht3['Humedad'] . " %" : "Sin datos"; ?></p>
    </div>

    <h2>Historial de Datos</h2>

    <!-- Tabla para Sensor 1 -->
    <h3>Sensor 1</h3>
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
                <?php while ($row = mysqli_fetch_assoc($resultado_todos_dht1)): ?>
                    <tr>
                        <td><?php echo $row['Temperatura']; ?> °C</td>
                        <td><?php echo $row['Humedad']; ?> %</td>
                        <td><?php echo $row['fecha_actual']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla para Sensor 2 -->
    <h3>Sensor 2</h3>
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
                <?php while ($row = mysqli_fetch_assoc($resultado_todos_dht2)): ?>
                    <tr>
                        <td><?php echo $row['Temperatura']; ?> °C</td>
                        <td><?php echo $row['Humedad']; ?> %</td>
                        <td><?php echo $row['fecha_actual']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla para Sensor 3 -->
    <h3>Sensor 3</h3>
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
                <?php while ($row = mysqli_fetch_assoc($resultado_todos_dht3)): ?>
                    <tr>
                        <td><?php echo $row['Temperatura']; ?> °C</td>
                        <td><?php echo $row['Humedad']; ?> %</td>
                        <td><?php echo $row['fecha_actual']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function updateData() {
            // Implementación para actualizar datos de cada sensor
        }

        document.getElementById('download-button').addEventListener('click', downloadPDF);
        document.getElementById('refresh-button').addEventListener('click', updateData);

        setInterval(updateData, 900000);
        window.onload = updateData;
    </script>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }
    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        width: 30%;
    }
    .card img {
        width: 50px;
        height: 50px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #f4f4f4;
    }
    .image-icon {
        vertical-align: middle;
        margin-right: 8px;
    }
    #refresh-button, #download-button {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #refresh-button:hover, #download-button:hover {
        background-color: #0056b3;
    }
    .chart-container {
        width: 90%;
        margin: 0 auto;
        max-width: 800px;
        margin-bottom: 30px;
    }
    canvas {
        background: #fff;
        border-radius: 8px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    @endsection
