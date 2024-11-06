@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card" id="temp-card">
        <img src="https://cdn-icons-png.flaticon.com/128/1959/1959311.png" alt="Temperature Icon">
        <h2>Temperatura</h2>
        <p id="temp-value"><?php echo isset($ultimo_dato->Temperatura) ? $ultimo_dato->Temperatura . " °C" : "Sin datos"; ?></p>
    </div>
    <div class="card" id="humidity-card">
        <img src="https://cdn-icons-png.flaticon.com/128/2828/2828582.png" alt="Humidity Icon">
        <h2>Humedad</h2>
        <p id="humidity-value"><?php echo isset($ultimo_dato->Humedad) ? $ultimo_dato->Humedad . " %" : "Sin datos"; ?></p>
    </div>
    <div class="card" id="lux-card">
        <img src="https://cdn-icons-png.flaticon.com/128/1083/1083117.png" alt="Date Icon">
        <h2>Luz</h2>
        <p id="date-value"><?php echo isset($ultimo_dato_bh1750->Luz) ? $ultimo_dato_bh1750->Luz : "Sin datos"; ?></p>
    </div>
    <div class="card" id="date-card">
        <img src="https://cdn-icons-png.flaticon.com/128/9187/9187977.png" alt="Date Icon">
        <h2>Fecha y Hora</h2>
        <p id="date-value"><?php echo isset($ultimo_dato->fecha_actual) ? $ultimo_dato->fecha_actual : "Sin datos"; ?></p>
    </div>
</div>
<!--
<div class="container">
    <div class="card" id="temp-card">
        <img src="https://cdn-icons-png.flaticon.com/128/1959/1959311.png" alt="Temperature Icon">
        <h2>Temperatura</h2>
        <p id="temp-value"><?php echo isset($ultimo_dato->Temperatura) ? $ultimo_dato->Temperatura . " °C" : "Sin datos"; ?></p>
    </div>
    <div class="card" id="humidity-card">
        <img src="https://cdn-icons-png.flaticon.com/128/2828/2828582.png" alt="Humidity Icon">
        <h2>Humedad</h2>
        <p id="humidity-value"><?php echo isset($ultimo_dato->Humedad) ? $ultimo_dato->Humedad . " %" : "Sin datos"; ?></p>
    </div>
    <div class="card" id="date-card">
        <img src="https://cdn-icons-png.flaticon.com/128/9187/9187977.png" alt="Date Icon">
        <h2>Fecha y Hora</h2>
        <p id="date-value"><?php echo isset($ultimo_dato->fecha_actual) ? $ultimo_dato->fecha_actual : "Sin datos"; ?></p>
    </div>
</div>
-->

<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
    <a href="/exportar-excel" class="btn btn-danger">Descargar Excel</a>
</div>


<h2 style="text-align: center;">Gráficas de Datos</h2>
<div class="chart-container">
    <canvas id="temp-chart"></canvas>
</div>
<div class="chart-container">
    <canvas id="humidity-chart"></canvas>
</div>
<div class="chart-container">
    <canvas id="lux-chart"></canvas>
</div>

<h2 style="text-align: center;">Historial de Datos</h2>

<table>
    <thead>
        <tr>
            <th>Temperatura</th>
            <th>Humedad</th>
            <th>Fecha y Hora</th>
        </tr>
    </thead>
    <tbody id="data-table-body">
        <!-- Mostrar solo los últimos 5 registros -->
        @foreach ($resultado_todos->take(5) as $row)
            <tr>
                <td>{{ $row->Temperatura }} °C</td>
                <td>{{ $row->Humedad }} %</td>
                <td>{{ $row->fecha_actual }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Contenedor para los registros ocultos -->
<div id="hidden-data" style="display: none;">
    <table>
        <tbody>
            @foreach ($resultado_todos->slice(5) as $row)
                <tr>
                    <td>{{ $row->Temperatura }} °C</td>
                    <td>{{ $row->Humedad }} %</td>
                    <td>{{ $row->fecha_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>


</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tempData = @json($resultado_todos->pluck('Temperatura'));
        var humidityData = @json($resultado_todos->pluck('Humedad'));
        var luxData = @json($resultado_todos_bh1750->pluck('Luz'));
        var labels = @json($resultado_todos_bh1750->pluck('fecha_actual'));
        var labelslux = @json($resultado_todos->pluck('fecha_actual'));

        var tempCtx = document.getElementById('temp-chart').getContext('2d');
        var humidityCtx = document.getElementById('humidity-chart').getContext('2d');
        var luxCtx = document.getElementById('lux-chart').getContext('2d');

        new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: tempData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
            }
        });

        new Chart(humidityCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Humedad (%)',
                    data: humidityData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                }]
            }
        });

        new Chart(luxCtx, {
            type: 'line',
            data: {
                labels: labelslux,
                datasets: [{
                    label: 'Luz (lx)',
                    data: luxData,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                }]
            }
        });

    });


</script>

<!-- Botón para mostrar/ocultar los datos -->
<button id="toggle-accordion" style="display: block; margin: 20px auto;">Mostrar más</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggle-accordion');
        const hiddenData = document.getElementById('hidden-data');

        toggleButton.addEventListener('click', function() {
            if (hiddenData.style.display === 'none') {
                hiddenData.style.display = 'block'; // Muestra el resto de los registros
                toggleButton.textContent = 'Mostrar menos';
            } else {
                hiddenData.style.display = 'none'; // Oculta de nuevo los registros
                toggleButton.textContent = 'Mostrar más';
            }
        });
    });
</script>

<style>body{font-family:Arial,sans-serif;margin:20px;padding:0;background-color:#f4f4f4}.container{display:flex;justify-content:space-around;margin-bottom:20px}.card{background:#fff;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,.1);padding:20px;text-align:center;width:30%}.card img{width:50px;height:50px}table{width:65%;border-collapse:collapse;margin:20px auto;background:#fff;box-shadow:0 0 10px rgba(0,0,0,.1)}table,th,td{border:1px solid #ddd}th,td{padding:12px;text-align:center}th{background-color:#f4f4f4}.accordion-content{display:none}.image-icon{vertical-align:middle;margin-right:8px}#refresh-button,#download-button{display:block;margin:20px auto;padding:10px 20px;background-color:#007BFF;color:#fff;border:none;border-radius:5px;cursor:pointer}#refresh-button:hover,#download-button:hover{background-color:#0056b3}.chart-container{width:90%;margin:0 auto;max-width:800px;margin-bottom:30px}canvas{background:#fff;border-radius:8px}</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    @endsection
