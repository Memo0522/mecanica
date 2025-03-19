@extends('app')
@section('content')


    <div class="container">
        <header class="header">
            {{-- Redirige a la vista de inventario usando una ruta de Laravel --}}
            <a href="{{ route('inventario.index') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Agregar Nuevo Registro</h1>
        </header>

        {{-- Formulario con la ruta definida en web.php --}}
        <form action="{{ route('inventario.store') }}" method="POST" class="add-form" onsubmit="return confirmarEnvio()">
            @csrf {{-- Protección contra ataques CSRF --}}
            
            <div class="form-row">
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" step="1" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <input type="text" id="categoria" name="categoria">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="medidas">Medidas:</label>
                    <input type="text" id="medidas" name="medidas" required>
                </div>
                <div class="form-group">
                    <label for="ubicacion">Ubicación (anaquel):</label>
                    <input type="number" min="0" id="ubicacion" name="ubicacion" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    <input type="text" id="observaciones" name="observaciones">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tipo_inventario">Tipo de Invetario:</label>
                    <input type="text" id="tipo_inventario" name="tipo_inventario">
                </div>
            </div>

            <button type="submit">Guardar Registro</button>
        </form>
    </div>



    
@endsection