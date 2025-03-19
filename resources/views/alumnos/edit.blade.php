@extends('app')
@section('content')

    <div class="container">
        <header class="header">
            <a href="{{ route('alumnos.index') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Editar Alumno</h1>
        </header>

        <form action="{{ route('alumnos.update', ['matricula' => $data->matricula]) }}" 
              method="POST" 
              class="add-form" 
              onsubmit="return confirmarEnvio()">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="matricula">Matrícula:</label>
                    <input type="text" id="matricula" name="matricula" value="{{ old('matricula', $data->matricula) }}" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $data->nombre) }}" required>
                </div>
                <div class="form-group">
                    <label for="pe">Programa Educativo (PE):</label>
                    <input type="text" id="pe" name="pe" value="{{ old('pe', $data->pe) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="grado">Grado:</label>
                    <input type="number" id="grado" name="grado" value="{{ old('grado', $data->grado) }}" required min="1">
                </div>
                <div class="form-group">
                    <label for="grupo">Grupo:</label>
                    <input type="text" id="grupo" name="grupo" value="{{ old('grupo', $data->grupo) }}" required>
                </div>
            </div>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>

    <script>
        function confirmarEnvio() {
            return confirm('¿Estás seguro de que deseas guardar los cambios?');
        }
    </script>
@endsection
