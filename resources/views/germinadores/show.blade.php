@extends('layouts.app')

@section('content')
    <h2>Datos del Germinador: {{ $nombre }}</h2>

    <h3>Luz</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Luz</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($luz as $dato)
                <tr>
                    <td>{{ $dato->id }}</td>
                    <td>{{ $dato->luz }}</td>
                    <td>{{ $dato->fecha_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Humedad</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Humedad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($humedad as $dato)
                <tr>
                    <td>{{ $dato->id }}</td>
                    <td>{{ $dato->humedad }}</td>
                    <td>{{ $dato->fecha_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Temperatura</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Temperatura</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($temperatura as $dato)
                <tr>
                    <td>{{ $dato->id }}</td>
                    <td>{{ $dato->temperatura }}</td>
                    <td>{{ $dato->fecha_actual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Fotos</h3>
    <div class="row">
        @foreach($fotos as $foto)
            <div class="col-md-4">
                <img src="{{ asset($foto->ruta_foto) }}" alt="Foto del Germinador" class="img-fluid">
                <p>{{ $foto->fecha_actual }}</p>
            </div>
        @endforeach
    </div>

@endsection
