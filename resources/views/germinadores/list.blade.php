@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Lista de Germinadores</h2>

        @if($germinadores->isEmpty())
            <p>No hay germinadores creados aún.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($germinadores as $germinador)
                        <tr>
                            <td>{{ $germinador->id }}</td>
                            <td>{{ $germinador->nombre }}</td>
                            <td>{{ $germinador->descripcion }}</td>
                            <td>{{ $germinador->created_at }}</td>
                            <td>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <a href="{{ route('germinadores.show', $germinador->nombre) }}" class="btn btn-info">Ver datos</a>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
