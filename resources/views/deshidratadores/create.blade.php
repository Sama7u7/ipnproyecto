@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Nuevo Deshidratador</h2>
        <br>

        <form action="{{ route('deshidratadores.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del deshidratador </label>
                <input type="text" name="nombre" class="form-control" required>
                <label style="opacity: 0.8;" for="nombre">*Nota: usar nombres sin espacios</label>

            </div>
            <br>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <br>

            <button type="submit" class="btn btn-success">Crear deshidratador</button>
        </form>
    </div>
@endsection
