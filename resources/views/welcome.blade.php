@extends('layouts.app')

@section('content')
    <div class="container">


        <!-- Grid de las cards -->
        <div class="card-container">
            <!-- Botón 1 -->
            <a href="/germinadores-list">
                <div class="card">
                    <h2>
                        <img src="{{ asset('planta.png') }}" class="icon"/>
                        Germinadores
                    </h2>
                </div>
            </a>

            <!-- Botón 2 -->
            <a href="/deshidratadores-list">
                <div class="card">
                    <h2>
                        <img src="{{ asset('deshidratado.png') }}" class="icon"/>
                        Deshidratadores
                    </h2>
                </div>
            </a>
        </div>
    </div>
        <br>
    <!-- Sección de información del proyecto -->
    <div class="container2">
        <h2>Información del Proyecto</h2>
        <p>Este proyecto se enfoca en el desarrollo de un sistema de comunicación WI-FI para la supervisión y el control de procesos de germinación de semillas, permitiendo la gestión de dispositivos de germinación y deshidratación de manera remota.</p>
    </div>

    <!-- Estilos -->
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
            margin-bottom: 20px;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Grid de 2 columnas */
            gap: 20px; /* Espacio entre las cards */
            margin-top: 20px;
            justify-items: stretch; /* Las cards ocupan todo el espacio disponible en cada celda */
            align-items: stretch; /* Las cards ocupan toda la altura disponible */
            width: 100%;
        }
        .card {
            background: #cfb1bd;
            border: 1px solid #864361;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%; /* Las cards llenan toda la altura disponible */
            width: 100%; /* Las cards llenan todo el ancho disponible */
            box-sizing: border-box;
            transition: transform 0.3s ease; /* Efecto al hacer hover */
        }
        .card:hover {
            transform: scale(1.05); /* Efecto al pasar el mouse */
        }
        h2 {
            color: #761345;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .icon {
            width: 50px; /* Tamaño del ícono */
            height: 50px;
            margin-right: 10px;
        }
        .table-container {
            max-height: 200px;
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
            color: #fff;
        }
        tbody tr:nth-child(even) {
            background-color: #cfb1bd;
        }
        a {
            text-decoration: none;
        }
    </style>
@endsection
