@extends('app')
@section('content')
    <div class="button-container">
        <a href="{{route('inventario.index')}}" class="button">
            <img src="{{ asset('img/inventario.png') }}" alt="Inventario">
            <span>Inventario</span>
        </a>
        <a href="{{route('prestamos.index')}}" class="button">
            <img src="{{ asset('img/prestamo.png') }}" alt="Préstamo">
            <span>Préstamos</span>
        </a>
        <a href="{{route('adeudos.index')}}" class="button">
            <img src="{{ asset('img/adeudos.png') }}" alt="Adeudos">
            <span>Adeudos</span>
        </a>
        <a href="{{route('reportes.index')}}" class="button">
            <img src="{{ asset('img/gestionar.jpg') }}" alt="Generar Reportes">
            <span>Generar Reportes</span>
        </a>
        <a href="{{route('alumnos.index')}}" class="button">
            <img src="{{ asset('img/alumnos.png') }}" alt="Administrar Alumnos">
            <span>Administrar Alumnos</span>
        </a>
        <a href="{{route('devoluciones.index')}}" class="button">
            <img src="{{ asset('img/devolucion.png') }}" alt="Devoluciones">
            <span>Devoluciones</span>
        </a>
    </div>
@endsection
