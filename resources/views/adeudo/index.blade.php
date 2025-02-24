@extends('app')
@section('content')
    <div class="container">
        <header class="header">
            <a href="{{ route('inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Adeudos</h1>
        </header>

        <div class="actions">
            <button>Agregar Nuevo Adeudo</button>

            <!-- Barra de búsqueda -->
            <form action="{{ route('adeudos.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Buscar por No. o matrícula" value="{{ $search }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No. Adeudo</th>
                        <th>Matrícula</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Detalles</th>
                        <th>Acciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adeudos as $adeudo)
                        <tr>
                            <td>{{ $adeudo->id_adeudos }}</td>
                            <td>{{ $adeudo->matricula }}</td>
                            <td>{{ $adeudo->fecha }}</td>
                            <td>${{ $adeudo->monto }}</td>
                            <td>
                                <button onclick="mostrarDetalles({{ $adeudo->id_adeudos }})">Ver Detalles</button>
                            </td>
                            <td>
                                <form action="#adeudos.update" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_adeudos" value="{{ $adeudo->id_adeudos }}">

                                    <select name="estatus" {{ $adeudo->estatus === 'PAGADO' ? 'disabled' : '' }}>
                                        <option value="SIN PAGAR" {{ $adeudo->estatus === 'SIN PAGAR' ? 'selected' : '' }}>
                                            SIN PAGAR</option>
                                        <option value="PAGADO" {{ $adeudo->estatus === 'PAGADO' ? 'selected' : '' }}>PAGADO
                                        </option>
                                    </select>

                                    <button type="submit"
                                        {{ $adeudo->estatus === 'PAGADO' ? 'disabled' : '' }}>Actualizar</button>
                                </form>
                            </td>
                            <td>
                                <a href="#adeudos.drestroy"
                                    title="Eliminar este registro"
                                    class="icon-button">
                                    <img src="{{ asset('img/icon-delete.png') }}" alt="Eliminar">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="overlay"></div>
    <div id="popup">
        <button class="close-popup" onclick="cerrarPopup()">Cerrar</button>
        <div id="popup-content"></div>
    </div>
@endsection
