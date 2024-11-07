@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Lista de Dehidratadores</h2>

        @if($deshidratadores->isEmpty())
            <p>No hay deshidratadores creados aún.</p>
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
                    @foreach($deshidratadores as $deshidratador)
                        <tr>
                            <td>{{ $deshidratador->id }}</td>
                            <td>{{ $deshidratador->nombre }}</td>
                            <td>{{ $deshidratador->descripcion }}</td>
                            <td>{{ $deshidratador->created_at }}</td>
                            <td>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <a href="{{ route('deshidratador.show', $deshidratador->nombre) }}" class="btn btn-info">Ver datos</a>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
