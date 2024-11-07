@extends('layouts.appback')

@section('content')
<div class="container">
    <h2>Editar Deshidratador</h2>
    <form action="{{ route('deshidratadores.update', $deshidratador->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre del Deshidratador</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $deshidratador->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ $deshidratador->descripcion }}</textarea>
        </div>
        <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
    </form>
</div>
@endsection
