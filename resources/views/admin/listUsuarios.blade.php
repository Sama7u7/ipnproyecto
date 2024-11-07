@extends('layouts.appback')

@section('content')
<div class="container">
    <h2>Lista de Usuarios</h2>

    <!-- Mensaje de éxito si existe -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla de usuarios -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <!-- Ejemplo de acciones como editar o eliminar -->
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
