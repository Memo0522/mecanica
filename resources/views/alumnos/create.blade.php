@extends('app')
@section('content')

    <div class="container">
        <header class="header">
            <a href="{{ route('alumnos.index') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Agregar Nuevo Alumno</h1>
        </header>

        <form action="{{ route('alumnos.store') }}" method="POST" class="add-form" onsubmit="return confirmarEnvio()">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="matricula">Matrícula:</label>
                    <input type="text" id="matricula" name="matricula" value="{{ old('matricula') }}" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pe">Programa Educativo (PE):</label>
                    <input type="text" id="pe" name="pe" value="{{ old('pe') }}" required>
                </div>
                <div class="form-group">
                    <label for="grado">Cuatrimestre:</label>
                    <input type="number" id="grado" name="grado" value="{{ old('grado') }}" required min="1">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="grupo">Grupo:</label>
                    <input type="text" id="grupo" name="grupo" value="{{ old('grupo') }}" required>
                </div>
            </div>

            <button type="submit">Guardar Registro</button>
        </form>
    </div>

    <script>
        function confirmarEnvio() {
            return confirm('¿Estás seguro de que deseas guardar este registro?');
        }
    </script>
@endsection
