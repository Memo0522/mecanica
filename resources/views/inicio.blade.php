@extends('app')
@section('content')
    <div class="button-container">
        <a href="{{route('inventario.index')}}" class="button">
            <img src="{{ asset('img/inventario.png') }}" alt="Inventario">
            <span>Inventario</span>
        </a>
        <a href="prestamos.php" class="button">
            <img src="{{ asset('img/prestamo.png') }}" alt="Préstamo">
            <span>Préstamos</span>
        </a>
        <a href="adeudos.php" class="button">
            <img src="{{ asset('img/adeudos.png') }}" alt="Adeudos">
            <span>Adeudos</span>
        </a>
        <a href="reportes.php" class="button">
            <img src="{{ asset('img/gestionar.jpg') }}" alt="Generar Reportes">
            <span>Generar Reportes</span>
        </a>
        <a href="alumnos.php" class="button">
            <img src="{{ asset('img/alumnos.png') }}" alt="Administrar Alumnos">
            <span>Administrar Alumnos</span>
        </a>
        <a href="devolucion.php" class="button">
            <img src="{{ asset('img/devolucion.png') }}" alt="Devoluciones">
            <span>Devoluciones</span>
        </a>
    </div>
@endsection
