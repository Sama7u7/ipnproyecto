@extends('layouts.appback')

@section('content')
<div class="container">
    <h2>Editar Germinador</h2>
    <form action="{{ route('germinadores.update', $germinador->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Esto hace que la solicitud sea tratada como PUT -->

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $germinador->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ $germinador->descripcion }}</textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

</div>
@endsection
