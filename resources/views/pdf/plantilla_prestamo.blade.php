<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 10px; color: #333; }
        .header h1, .header h2 { margin: 0; font-size: 14px; }
        .header p { font-size: 12px; }
        .header img { width: 80px; height: auto; display: inline-block; vertical-align: middle; }
        .header .left-img { float: left; }
        .header .right-img { float: right; }
        .details { font-size: 12px; margin-bottom: 10px; color: #333; }
        .details table { width: 100%; }
        .details td { padding: 5px; }
        .items-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .items-table th, .items-table td { border: 1px solid black; padding: 5px; text-align: center; color: #333; }
        .items-table th { background-color: #f0f0f0; }
        .signatures { text-align: center; margin-top: 30px; color: #333; }
        .signatures div { display: inline-block; width: 33%; }
        .signature-line { margin-top: 50px; border-top: 1px solid black; width: 80%; color: #333; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('img/uni.png') }}" class="left-img">
    <img src="{{ public_path('img/meca.jpg') }}" class="right-img">
    <h1>TSU EN MECÁNICA INDUSTRIAL / LIC. EN INGENIERÍA MECÁNICA</h1>
    <h2>VALE DE ALMACÉN - HERRAMIENTA</h2>
    <p>IXMIQUILPAN HGO. A {{ $fecha_formato }}</p>
</div>

<div class="details">
    <table>
        <tr>
            <td>Nombre:</td>
            <td>{{ $nombre }}</td>
            <td>Matrícula:</td>
            <td>{{ $matricula }}</td>
        </tr>
        <tr>
            <td>P.E.:</td>
            <td>{{ $pe }}</td>
            <td>Cuatrimestre:</td>
            <td>{{ $grado }}</td>
            <td>Grupo:</td>
            <td>{{ $grupo }}</td>
        </tr>
    </table>
</div>

<table class="items-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Cantidad</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($codigo as $index => $cod)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $cantidad[$index] }}</td>
            <td>{{ $descripcion[$index] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="signatures">
    <div>
        <p class="signature-line"></p>
        <p>Firma Autorizó</p>
    </div>
    <div>
        <p class="signature-line"></p>
        <p>Firma Entregó</p>
    </div>
    <div>
        <p class="signature-line"></p>
        <p>Firma Recibió</p>
    </div>
</div>

</body>
</html>