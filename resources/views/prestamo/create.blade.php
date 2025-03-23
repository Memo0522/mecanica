@extends('app')
@section('content')

<div class="container">
    <header class="header">
        <a href="{{ route('prestamos.index') }}" class="exit-button">
            <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
        </a>
        <h1>Registrar Nuevo Préstamo</h1>
    </header>

    <form action="{{ route('prestamos.store') }}" method="POST" class="add-form" onsubmit="return confirmarEnvio()">
        @csrf
        <!-- Datos para la tabla 'prestamos' -->
        <div class="form-row">
            <div class="form-group">
                <label for="matricula">Matrícula:</label>
                <input type="text" id="matricula" name="matricula" required onblur="buscarAlumno()" value="{{ old('matricula') }}">
            </div>
            <div class="form-group">
                <label for="fecha">Fecha de préstamo:</label>
                <input type="date" id="fecha" name="fecha" required readonly>
            </div>
        </div>

        <!-- Datos para la tabla 'detalle_prestamo' -->
        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required readonly value="{{ old('nombre') }}">
            </div>
            <div class="form-group">
                <label for="pe">Programa Educativo (PE):</label>
                <select id="pe" name="pe" required>
                    <option value="" disabled {{ old('pe') ? '' : 'selected' }}>Seleccione una opción</option>
                    @php
                        $opciones = [
                            'Mecánica', 'Administración', 'Gastronomía', 'Energías Renovables', 
                            'Mecatrónica', 'Procesos Alimentarios', 'Turismo', 'Tecnologías de la Información'
                        ];
                    @endphp
                    @foreach($opciones as $opcion)
                        <option value="{{ $opcion }}" {{ old('pe') == $opcion ? 'selected' : '' }}>{{ $opcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="grado">Cuatrimestre:</label>
                <input type="number" id="grado" name="grado" required min="1" readonly value="{{ old('grado') }}">
            </div>
            <div class="form-group">
                <label for="grupo">Grupo:</label>
                <input type="text" id="grupo" name="grupo" required readonly value="{{ old('grupo') }}">
            </div>
        </div>

        <h3>Detalles del Préstamo</h3>
        <table id="detalles-table" border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="text" name="codigo[]" class="codigo-input" readonly required></td>
                    <td style="position: relative;">
                        <input type="text" name="descripcion[]" class="descripcion-input" required autocomplete="off" oninput="autocompleteDescripcion(this)">
                        <div class="autocomplete-list" style="position:absolute; background:white; border:1px solid #ccc; width:100%; display:none; z-index:10; max-height: 200px; overflow-y: auto;"></div>
                     </td>     
                    <td><input type="number" name="cantidad[]" required min="1"></td>
                </tr>
            </tbody>
        </table>
        <button type="button" onclick="agregarFila()">Añadir Fila</button>
        <button type="submit">Guardar Registro</button>
    </form>
</div>

<script>
    function confirmarEnvio() {
        return confirm('¿Está seguro de que desea guardar el registro?');
    }

    function buscarAlumno() {
        const matricula = document.getElementById("matricula").value;
        if (matricula) {
            fetch(`{{ url('buscarAlumno') }}?matricula=${matricula}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nombre) {
                        document.getElementById("nombre").value = data.nombre;
                        document.getElementById("pe").value = data.pe;
                        document.getElementById("grado").value = data.grado;
                        document.getElementById("grupo").value = data.grupo;
                    } else {
                        alert("No se encontró un alumno con esa matrícula.");
                        clearStudentFields();
                    }
                })
                .catch(error => console.error("Error al buscar alumno:", error));
        }
    }

    function clearStudentFields() {
        document.getElementById("nombre").value = "";
        document.getElementById("pe").value = "";
        document.getElementById("grado").value = "";
        document.getElementById("grupo").value = "";
    }

    function setFechaActual() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById("fecha").value = today;
    }

    function agregarFila() {
        const table = document.getElementById("detalles-table").getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length + 1;
        const row = table.insertRow();

        row.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" name="codigo[]" class="codigo-input" readonly required></td>
            <td style="position: relative;">
                <input type="text" name="descripcion[]" class="descripcion-input" required autocomplete="off" oninput="autocompleteDescripcion(this)">
                <div class="autocomplete-list" style="position:absolute; background:white; border:1px solid #ccc; width:100%; display:none; z-index:10;"></div>
            </td>
            <td><input type="number" name="cantidad[]" required min="1"></td>
        `;
    }

    function autocompleteDescripcion(input) {
    const value = input.value.trim();
    const list = input.nextElementSibling;
    list.innerHTML = '';
    list.style.display = 'none';

    if (value.length < 1) return; // Empieza a buscar a partir de 2 caracteres

    fetch(`{{ url('buscarDescripcion') }}?descripcion=${value}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                list.style.display = 'block';
                list.style.maxHeight = '200px';  // Limite de altura
                list.style.overflowY = 'auto';   // Scroll vertical
                data.forEach(item => {
                    const div = document.createElement('div');
                    div.style.cursor = 'pointer';
                    div.style.padding = '5px';
                    div.textContent = item.descripcion;
                    div.onclick = function() {
                        input.value = item.descripcion;
                        input.closest('tr').querySelector('.codigo-input').value = item.codigo;
                        list.innerHTML = '';
                        list.style.display = 'none';
                    };
                    list.appendChild(div);
                });
            }
        })
        .catch(error => console.error("Error al buscar descripciones:", error));
}

    window.onload = function () {
        setFechaActual();
    };
</script>

@endsection
