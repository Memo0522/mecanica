@extends('app')
@section('content')
    <div class="container">
        <header class="header">
            <a href="{{ route('inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Devoluciones</h1>
        </header>

        <div class="actions">
            <!-- Barra de búsqueda -->
            <form action="{{ route('devoluciones.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Buscar por No. o matrícula" value="{{ old('search', $search) }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        @if ($prestamos->isNotEmpty())
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No. Préstamo</th>
                            <th>Matrícula</th>
                            <th>Fecha de Préstamo</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th>Actualizar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestamos as $prestamo)
                            <tr>
                                <td>{{ $prestamo->id_prestamos }}</td>
                                <td>{{ $prestamo->matricula }}</td>
                                <td>{{ $prestamo->fecha }}</td>
                                <td>
                                    <a href="{{ asset('pdf/' . urlencode($prestamo->pdf_nombre)) }}" target="_blank">
                                        {{ $prestamo->pdf_nombre }}
                                    </a>
                                </td>
                                <td>{{ $prestamo->status }}</td>
                                <td>
                                    <form action="#prestamosStatus" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_prestamos" value="{{ $prestamo->id_prestamos }}">

                                        @php
                                            $disabled = $prestamo->status === 'ENTREGADO' ? 'disabled' : '';
                                        @endphp

                                        <select name="status" {{ $disabled }}>
                                            <option value="SIN ENTREGAR" {{ $prestamo->status === 'SIN ENTREGAR' ? 'selected' : '' }}>SIN ENTREGAR</option>
                                            <option value="ENTREGADO" {{ $prestamo->status === 'ENTREGADO' ? 'selected' : '' }}>ENTREGADO</option>
                                        </select>

                                        <button type="submit" {{ $disabled }}>Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No se encontraron registros para la búsqueda realizada.</p>
        @endif
    </div>
@endsection