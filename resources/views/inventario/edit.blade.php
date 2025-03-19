@extends('app')
@section('content')

<div class="container">
    <header class="header">
        <a href="{{ route('inventario.index') }}" class="exit-button">
            <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
        </a>
        <h1>Editar data</h1>
    </header>

    <form action="{{ route('inventario.update', $data->codigo) }}" method="POST" class="add-form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" value="{{ $data->codigo }}" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="descripcion">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="{{ $data->descripcion }}" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" min="1" value="{{ $data->cantidad }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <input type="text" id="categoria" name="categoria" value="{{ $data->categoria }}">
            </div>
            <div class="form-group">
                <label for="medidas">Medidas:</label>
                <input type="text" id="medidas" name="medidas" value="{{ $data->medidas }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="ubicacion">Ubicación (anaquel):</label>
                <input type="number" id="ubicacion" name="ubicacion" min="0" value="{{ $data->ubicacion }}" required>
            </div> 
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tipo_inventario">Tipo de Inventario:</label>
                <input type="text" id="tipo_inventario" name="tipo_inventario" value="{{ $data->tipo_inventario }}" required>
            </div> 
        </div>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>
@endsection
