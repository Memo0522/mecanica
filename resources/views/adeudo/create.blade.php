@extends('app')
@section('content')
    <div class="container">
        <header class="header">
            <a href="{{ url('/adeudos') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Agregar Nuevo Adeudo</h1>
        </header>

        <form action="{{ route('adeudos.store') }}" method="POST" class="add-form" onsubmit="return confirmarEnvio()">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="matricula">Matrícula:</label>
                    <input type="text" id="matricula" name="matricula" required onblur="buscarAlumno()">
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha de Adeudo:</label>
                    <input type="date" id="fecha" name="fecha" required readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required readonly>
                </div>
                <div class="form-group">
                    <label for="pe">Programa Educativo (PE):</label>
                    <select id="pe" name="pe" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Mecánica">Mecánica</option>
                        <option value="Administración">Administración</option>
                        <option value="Gastronomía">Gastronomía</option>
                        <option value="Energías Renovables">Energías Renovables</option>
                        <option value="Mecatrónica">Mecatrónica</option>
                        <option value="Procesos Alimentarios">Procesos Alimentarios</option>
                        <option value="Turismo">Turismo</option>
                        <option value="Tecnologías de la Información">Tecnologías de la Información</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="grado">Cuatrimestre:</label>
                    <input type="number" id="grado" name="grado" required min="1" readonly>
                </div>
                <div class="form-group">
                    <label for="grupo">Grupo:</label>
                    <input type="text" id="grupo" name="grupo" required readonly>
                </div>
            </div>

            <h3>Detalles del Adeudo</h3>
            <table id="detalles-table" border="1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="codigo[]" class="codigo-input" readonly required></td>
                        <td>
                            <input type="text" name="descripcion[]" class="descripcion-input" required
                                autocomplete="off">
                            <div class="autocomplete-list" style="display:none;"></div>
                        </td>
                        <td><input type="number" name="cantidad[]" min="1" required></td>
                        <td><input type="number" name="monto[]" min="1" required></td>
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
                fetch(`{{ url('/buscarAlumno') }}?matricula=${matricula}`)
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
            const today = new Date();
            const localDate = new Date(today.getTime() - today.getTimezoneOffset() * 60000)
                .toISOString()
                .split('T')[0];
            document.getElementById("fecha").value = localDate;
        }

        let filaCount = 1;

        function agregarFila() {
            const table = document.getElementById("detalles-table");
            const row = table.insertRow();
            filaCount++;

            row.innerHTML = `
            <td>${filaCount}</td>
            <td><input type="text" name="codigo[]" class="codigo-input" readonly required></td>
            <td>
                <input type="text" name="descripcion[]" class="descripcion-input" required autocomplete="off">
                <div class="autocomplete-list" style="display:none;"></div>
            </td>
            <td><input type="number" name="cantidad[]" min="1" required></td>
            <td><input type="number" name="monto[]" min="1" required></td>
        `;
            asignarEventoAutocomplete(row.querySelector('.descripcion-input'));
        }

        function asignarEventoAutocomplete(input) {
            input.addEventListener('input', function() {
                autocomplete(this);
            });
        }

        function autocomplete(input) {
            const value = input.value;
            const list = input.nextElementSibling;
            list.innerHTML = '';
            list.style.display = 'none';

            if (!value) {
                return;
            }

            fetch(`{{ url('/buscarDescripcion') }}?descripcion=${value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        list.style.display = 'block';
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.classList.add('autocomplete-item');
                            div.textContent = item.descripcion;
                            div.onclick = function() {
                                input.value = item.descripcion;
                                input.closest('tr').querySelector('.codigo-input').value = item.codigo;
                                list.innerHTML = '';
                                list.style.display = 'none';
                            };
                            list.appendChild(div);
                        });
                        console.log(data);
                        
                    }
                })
                .catch(error => console.error("Error al buscar descripciones:", error));
        }

        document.querySelectorAll('.descripcion-input').forEach(input => {
            asignarEventoAutocomplete(input);
        });

        window.onload = function() {
            setFechaActual();
        };
    </script>
@endsection
