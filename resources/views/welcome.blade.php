@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Sensor 1 -->
        <a href="/germinadores-list">
        <div class="card">
            <h2>Germinadores</h2>
        </div>
        </a>
        <!-- Sensor 2 -->
        <a href="/deshidratador">
        <div class="card">
            <h2>Deshidratador</h2>
        </div>
        </a>

        <!-- Sensor 3 -->
         <a href="/vivosun">
        <div class="card">
            <h2>VivoSun</h2>
           
        </div>
        </a>

       


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
        a{
            text-decoration: none;
        }
    </style>
    @endsection