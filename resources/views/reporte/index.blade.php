<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reportes</title>
    <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
    <link rel="icon" href="{{ asset('img/meca.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <a href="{{ route('inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Volver">
            </a>
            <h1>Generar Reportes</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="report-buttons">
            <button id="btnReporteInventario">Reporte Inventario</button>
            <button id="btnReporteAdeudos">Reporte Adeudos</button>
        </div>

        <div id="formPopup" class="popup">
            <div class="popup-content">
                <h2>Generar Reporte</h2>
                <form id="reportForm" action="{{ route('generar.reporte') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fechaInicio">Fecha de Inicio:</label>
                        <input type="date" id="fechaInicio" name="fecha_inicio" placeholder="Selecciona una fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaFinal">Fecha Final:</label>
                        <input type="date" id="fechaFinal" name="fecha_final" placeholder="Selecciona una fecha" required>
                    </div>
                    <div class="form-group" id="inventarioOptions" style="display: none;">
                        <label for="opcionInventario">Tipo de Inventario:</label>
                        <select id="opcionInventario" name="opcion_inventario">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Utvm">UTVM</option>
                            <option value="General">General</option>
                            <option value="Donado">Donado</option>
                        </select>
                    </div>
                    <input type="hidden" id="reporteTipo" name="reporte_tipo" value="">
                    <input type="hidden" id="formato" name="formato" value="">
                    <button type="submit" id="generarReporte">Generar Reporte</button>
                </form>
                <button class="close-btn" id="closeFormPopup">Cerrar</button>
            </div>
        </div>

        <div id="popupFormat" class="popup2" style="display: none;">
            <div class="popup-content2">
                <h2>Selecciona el formato del reporte</h2>
                <button type="button" id="popupExcel">Excel</button>
                <button type="button" id="popupPDF">PDF</button>
                <button type="button" id="popupCancel">Cancelar</button>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportes as $reporte)
                        @php
                            $archivo = htmlspecialchars($reporte->archivo);
                            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                        @endphp
                        <tr>
                            <td>{{ $reporte->fecha }}</td>
                            <td>
                                <a href="{{ route('reportes.ver', ['archivo' => $archivo]) }}" target="_blank">{{ $archivo }}</a>
                            </td>
                        </tr>
                    @endforeach
                    @if($reportes->isEmpty())
                        <tr><td colspan="2">No hay registros en reportes.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnReporteInventario = document.getElementById('btnReporteInventario');
            const btnReporteAdeudos = document.getElementById('btnReporteAdeudos');
            const formPopup = document.getElementById('formPopup');
            const popupFormat = document.getElementById('popupFormat');
            const closeFormPopup = document.getElementById('closeFormPopup');
            const reportForm = document.getElementById('reportForm');
            const reporteTipo = document.getElementById('reporteTipo');
            const inventarioOptions = document.getElementById('inventarioOptions');
            const formatoInput = document.getElementById('formato');

            btnReporteInventario.addEventListener('click', function () {
                reporteTipo.value = 'inventario';
                inventarioOptions.style.display = 'block';
                formPopup.style.display = 'block';
            });

            btnReporteAdeudos.addEventListener('click', function () {
                reporteTipo.value = 'adeudos';
                inventarioOptions.style.display = 'none';
                formPopup.style.display = 'block';
            });

            closeFormPopup.addEventListener('click', function () {
                formPopup.style.display = 'none';
            });

            reportForm.addEventListener('submit', function (e) {
                e.preventDefault();
                formPopup.style.display = 'none';
                popupFormat.style.display = 'block';
            });

            document.getElementById('popupExcel').addEventListener('click', function () {
                formatoInput.value = 'excel';
                reportForm.submit();
            });

            document.getElementById('popupPDF').addEventListener('click', function () {
                formatoInput.value = 'pdf';
                reportForm.submit();
            });

            document.getElementById('popupCancel').addEventListener('click', function () {
                popupFormat.style.display = 'none';
            });
        });
    </script>
</body>
</html>