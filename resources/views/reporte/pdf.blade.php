<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header img { width: 80px; height: auto; }
        .header .text { text-align: center; flex-grow: 1; font-size: 14px; font-weight: bold; }
        .dates { text-align: center; font-size: 14px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: center; }
        th { background-color: white; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ storage_path('app/public/img/uni.png') }}" class="left-img">
        <img src="{{ storage_path('app/public/img/meca.jpg') }}" class="right-img">
        <div class="text">
            Universidad Tecnológica del Valle del Mezquital.<br>
            TSU. Mecánica Industrial / LIC. Ingeniería Mecánica.<br>
            Reporte de {{ ucfirst($tipo) }}
        </div>
    </div>

    <div class="dates">
        <p><strong>Fecha Inicio:</strong> {{ $fechaInicio }} / <strong>Fecha Final:</strong> {{ $fechaFinal }}</p>
    </div>

    <table>
        @if ($tipo === 'adeudos')
            <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Detalles</th>
                <th>Fecha</th>
                <th>Monto Adeudo</th>
            </tr>
            @foreach ($datos as $registro)
                <tr>
                    <td>{{ $registro->matricula }}</td>
                    <td>{{ $registro->nombre }}</td>
                    <td>{{ $registro->detalle }}</td>
                    <td>{{ $registro->fecha }}</td>
                    <td>$ {{ $registro->monto_adeudo }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Medidas</th>
                <th>Ubicación</th>
                <th>Tipo Inventario</th>
            </tr>
            @foreach ($datos as $registro)
                <tr>
                    <td>{{ $registro->codigo }}</td>
                    <td>{{ $registro->descripcion }}</td>
                    <td>{{ $registro->cantidad }}</td>
                    <td>{{ $registro->categoria }}</td>
                    <td>{{ $registro->medidas }}</td>
                    <td>{{ $registro->ubicacion }}</td>
                    <td>{{ $registro->tipo_inventario }}</td>
                </tr>
            @endforeach
        @endif
    </table>
</body>
</html>