@extends('layouts.appback')

@section('content')
<div class="container mt-5">
    <h2>Editar Usuario</h2>

    <!-- Muestra los errores de validación -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario de edición -->
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repetir la nueva contraseña">
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
