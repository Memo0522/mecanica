<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (request()->is('/'))
        <link rel="stylesheet" href="{{asset('css/login.css')}}">
    @endif
    @if (request()->routeIs('inicio'))
        <link rel="stylesheet" href="{{asset('css/inicio.css')}}">
    @endif
    @if (request()->routeIs('inventario.index'))
        <link rel="stylesheet" href="{{asset('css/inventario.css')}}">
    @endif
    @if (request()->routeIs('prestamos.index'))
        <link rel="stylesheet" href="{{asset('css/prestamos.css')}}">
    @endif
    @if (request()->routeIs('adeudos.index'))
        <link rel="stylesheet" href="{{asset('css/adeudos.css')}}">
    @endif
    @if (request()->routeIs('reportes.index'))
        <link rel="stylesheet" href="{{asset('css/reportes.css')}}">
    @endif
    @if (request()->routeIs('alumnos.index'))
        <link rel="stylesheet" href="{{asset('css/alumnos.css')}}">
    @endif
    @if (request()->routeIs('devoluciones.index'))
        <link rel="stylesheet" href="{{asset('css/prestamos.css')}}">
    @endif
    <title>Document</title>
</head>
<body>
    @if (session()->has('user') && request()->routeIs('inicio'))
        @include('includes.header')
    @endif
    <main>
        @yield('content') 
    </main>
</body>
</html>