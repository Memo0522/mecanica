@extends('app')
@section('content')
    <div class="container">
        <header class="header">
            <a href="{{ url('/inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Administración de Alumnos</h1>
        </header>

        <div class="actions">
            <form action="#cargar-alumnos-exel" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="dataCliente" id="file-input" accept=".csv, .xlsx" required />
                <button type="submit">Subir Excel</button>
            </form>

            <button>Agregar Nuevo Alumno</button>

            <!-- Formulario de búsqueda de matrícula -->
            <form action="{{ route('alumnos.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Buscar por matrícula" value="{{ request('search') }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Programa Educativo (PE)</th>
                        <th>Cuatrimestre</th>
                        <th>Grupo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $contador = 1; @endphp
                    @forelse ($alumnos as $alumno)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $alumno->matricula }}</td>
                            <td>{{ $alumno->nombre }}</td>
                            <td>{{ $alumno->pe }}</td>
                            <td>{{ $alumno->grado }}</td>
                            <td>{{ $alumno->grupo }}</td>
                            <td>
                                <a href="#alumnos.edit" class="icon-button" title="Editar">
                                    <img src="{{ asset('img/icon-update.png') }}" alt="Editar">
                                </a>
                                <a href="#alumnos.destroy" 
                                    class="icon-button" title="Eliminar">
                                    <img src="{{ asset('img/icon-delete.png') }}" alt="Eliminar">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay registros de alumnos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
@endsection