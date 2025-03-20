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
            <a href="{{ route('adeudos.create') }}" class="icon-button1">Agregar Nuevo Adeudo</a>


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
                                <form action="{{ route('adeudos.update', $adeudo->id_adeudos) }}" method="POST">
                                    @csrf
                                    @method('PUT')
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
                                <form action="{{ route('adeudos.destroy', ['id'=>$adeudo->id_adeudos]) }}" method="POST"
                                    class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Eliminar este registro" class="icon-button eliminar-btn">
                                        <img src="{{ asset('img/icon-delete.png') }}" alt="Eliminar">
                                    </button>
                                </form>

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

    <script>
        function mostrarDetalles(id) {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';

            fetch(`/adeudos/detalles/${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('popup-content').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function cerrarPopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas eliminar este adeudo?')) {
                    this.submit();
                }
            });
        });
    </script>
@endsection
