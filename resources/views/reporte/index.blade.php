@extends('app')
@section('content')
    <div class="container">
        <header class="header">
            <a href="{{ route('inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Volver">
            </a>
            <h1>Generar Reportes</h1>
        </header>

        <div class="report-buttons">
            <button id="btnReporteInventario">Reporte Inventario</button>
            <button id="btnReporteAdeudos">Reporte Adeudos</button>
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
                                @if($extension === 'pdf')
                                    <a href="{{ asset('pdf/' . $archivo) }}" target="_blank">{{ $archivo }}</a>
                                @elseif($extension === 'xlsx')
                                    <a href="{{ asset('excel/' . $archivo) }}" target="_blank">{{ $archivo }}</a>
                                @endif
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
@endsection