@extends('layouts.app')

@section('content')
    <h2 style="text-align: center;">Datos del Germinador: {{ $nombre }}</h2>

    <div class="container">
    <div class="card" id="temp-card">
        <img src="https://cdn-icons-png.flaticon.com/128/1959/1959311.png" alt="Temperature Icon">
        <h2>Temperatura</h2>
        <p id="temp-value"><?php echo isset($ultimo_dato->temperatura) ? $ultimo_dato->temperatura . " °C" : "Sin datos"; ?></p>
    </div>
    <div class="card" id="humidity-card">
        <img src="https://cdn-icons-png.flaticon.com/128/2828/2828582.png" alt="Humidity Icon">
        <h2>Humedad</h2>
        <p id="humidity-value"><?php echo isset($ultimo_dato->humedad) ? $ultimo_dato->humedad . " %" : "Sin datos"; ?></p>
    </div>
    <div class="card" id="lux-card">
        <img src="https://cdn-icons-png.flaticon.com/128/1083/1083117.png" alt="Date Icon">
        <h2>Luz</h2>
        <p id="date-value"><?php echo isset($ultimo_dato_bh1750->luz) ? $ultimo_dato_bh1750->luz : "Sin datos"; ?></p>
    </div>
    <div class="card" id="date-card">
        <img src="https://cdn-icons-png.flaticon.com/128/9187/9187977.png" alt="Date Icon">
        <h2>Fecha y Hora</h2>
        <p id="date-value"><?php echo isset($ultimo_dato->fecha_actual) ? $ultimo_dato->fecha_actual : "Sin datos"; ?></p>
    </div>
</div>
<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
    <a href="{{ route('germinadores.exportExcel', ['nombre' => $nombre]) }}" class="btn btn-danger">Descargar Excel</a>
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


<div class="chart-container">
    <div class="row justify-content-center">
   <div style="align-items: center;">
    <h3 style="text-align: center;">Luz</h3>
    <div class="table-container">
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Luz</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <!-- Mostrar solo los últimos 5 registros -->
            @foreach($luz as $dato)
                <tr>
                    <td>{{ $dato->luz }}</td>
                    <td>{{ $dato->fecha_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>


    <h3 style="text-align: center;">Temperatura y humedad</h3>
    <div class="table-container">
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Temperatura</th>
                <th>Humedad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($temperatura_humedad as $dato)
                <tr>
                    <td>{{ $dato->temperatura }}</td>
                    <td>{{ $dato->humedad }}</td>
                    <td>{{ $dato->fecha_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


    <h3 style="text-align: center;">Fotos</h3>
    <div class="row">
        @foreach($fotos as $foto)
            <div class="col-md-4">
                <img src="{{ asset($foto->ruta_foto) }}" alt="Foto del Germinador" class="img-fluid">
                <p>{{ $foto->fecha_actual }}</p>
            </div>
        @endforeach
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tempData = @json($temperatura_humedad->pluck('temperatura'));
        var humidityData = @json($temperatura_humedad->pluck('humedad'));
        var luxData = @json($luz->pluck('luz'));
        var labels = @json($luz->pluck('fecha_actual'));
        var labelslux = @json($temperatura_humedad->pluck('fecha_actual'));

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

<style>body{font-family:Arial,sans-serif;margin:0;padding:0;background-color:#f4f4f4}.container{display:flex;justify-content:space-around;margin-bottom:20px}.card{background:#fff;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,.1);padding:20px;text-align:center;width:30%}.card img{width:50px;height:50px}table{width:100%;border-collapse:collapse;background:#fff;box-shadow:0 0 10px rgba(0,0,0,.1)}th,td{border:1px solid #ddd;padding:12px;text-align:center}th{background-color:#6c1d45;color:#fff}.table-container{margin-top:20px}.table-responsive{max-height:200px;overflow-y:auto;margin-bottom:20px;border-radius:8px;background:#f8f9fa}.image-icon{vertical-align:middle;margin-right:8px}#refresh-button,#download-button{display:block;margin:20px auto;padding:10px 20px;background-color:#007BFF;color:#fff;border:none;border-radius:5px;cursor:pointer}#refresh-button:hover,#download-button:hover{background-color:#0056b3}.chart-container{width:90%;margin:0 auto;max-width:800px;margin-bottom:30px}canvas{background:#fff;border-radius:8px}</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
@endsection
