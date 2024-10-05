@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Nuevo Germinador</h2>

        <form action="{{ route('germinadores.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del Germinador</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Crear Germinador</button>
        </form>
    </div>
@endsection
