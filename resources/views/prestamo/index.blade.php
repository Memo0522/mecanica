@extends('app')
@section('content')
    <div class="container">
        <header class="header">
            <a href="{{ route('inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Préstamos</h1>
        </header>

         <!-- Script para mostrar alertas de éxito o error -->
         @if(session('message'))
         <script>
             alert("{{ session('message') }}");
         </script>
     @endif

        <div class="actions">
            <a href="{{ route('prestamos.create') }}" class="icon-button1">Agregar Nuevo Préstamo</a>

            <form action="{{ route('prestamos.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Buscar por No. o matrícula"
                    value="{{ request('search') }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No. Préstamo</th>
                        <th>Matrícula</th>
                        <th>Fecha de Préstamo</th>
                        <th>PDF</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($prestamos->count() > 0)
                        @foreach ($prestamos as $prestamo)
                            <tr>
                                <td>{{ $prestamo->id_prestamos }}</td>
                                <td>{{ $prestamo->matricula }}</td>
                                <td>{{ $prestamo->fecha }}</td>
                                <td>
                                    <a href="{{ asset('pdf/' . $prestamo->pdf_nombre) }}"
                                        target="_blank">{{ $prestamo->pdf_nombre }}</a>
                                </td>
                                <td>{{ $prestamo->status }}</td>
                                <td>
                                    @if ($prestamo->status !== 'sin entregar')
                                        <form action="{{ route('prestamos.destroy', $prestamo->id_prestamos) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-button" title="Eliminar este registro">
                                                <img src="{{ asset('img/icon-delete.png') }}" alt="Eliminar">
                                            </button>
                                        </form>
                                    @else
                                        <button class="icon-button" disabled title="No se puede eliminar (sin entregar)">
                                            <img src="{{ asset('img/icon-delete.png') }}" alt="Eliminar">
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">No hay registros en préstamos.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection