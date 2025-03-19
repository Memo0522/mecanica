@extends('app')
@section('content')
        <div class="container">
        <header class="header">
            <a href="{{ route('inicio') }}" class="exit-button">
                <img src="{{ asset('img/volver-flecha.png') }}" alt="Salir">
            </a>
            <h1>Inventario</h1>
        </header>

        <div class="actions">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="dataCliente" id="file-input" accept=".csv, .xlsx" required />
                <button type="submit">Subir Excel</button>
            </form>
            <a href="{{route(name: 'inventario.create')}}" class="icon-button1">Agregar Nuevo Registro</a>

            <!-- Barra de búsqueda -->
            <form action="{{route('inventario.index')}}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Buscar por código o descripción" value="{{ request('search') }}">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Medidas</th>
                        <th>Ubicación</th>
                        <th>Tipo Inventario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $contador = 1; @endphp

                    @forelse ($inventario as $item)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ $item->categoria }}</td>
                            <td>{{ $item->medidas }}</td>
                            <td>{{ $item->ubicacion }}</td>
                            <td>{{ $item->tipo_inventario }}</td>
                            <td>
                                <a href="{{route("inventario.edit",$item->codigo)}}" class="icon-button">
                                    <img src="{{ asset('img/icon-update.png') }}" alt="Editar">
                                </a>

                                <a href="#" class="icon-button" onclick="confirmarEliminacion(event, '{{ $item->codigo }}')">
                                    <img src="{{ asset('img/icon-delete.png') }}" alt="Eliminar">
                                </a>
                            
                                <form id="delete-form-{{ $item->codigo }}" 
                                      action="{{ route('inventario.destroy', ['codigo' => $item->codigo]) }}" 
                                      method="post" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay registros en el inventario.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
function confirmarEliminacion(event, codigo) {
    event.preventDefault(); // Evita que el enlace navegue a otra página

    if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
        document.getElementById('delete-form-' + codigo).submit();
    }
}

    </script>
@endsection