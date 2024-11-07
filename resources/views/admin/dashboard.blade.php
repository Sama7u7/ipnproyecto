@extends('layouts.appback')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
        <a href="{{ route('germinadores.create') }}" class="btn btn-primary mb-3">Crear Germinador</a>
    </div>

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
                            <div style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                <a href="{{ route('germinadores.show', $germinador->nombre) }}" class="btn btn-info">Ver datos</a>
                                <a href="{{ route('germinadores.edit', $germinador->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('germinadores.destroy', $germinador->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este germinador y sus tablas asociadas?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Deshidratadores -->
    <div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
        <a href="{{ route('deshidratadores.create') }}" class="btn btn-primary mb-3">Crear Deshidratador</a>
    </div>

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
                            <div style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                                <a href="{{ route('deshidratadores.edit', $deshidratador->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('deshidratadores.destroy', $deshidratador->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection



