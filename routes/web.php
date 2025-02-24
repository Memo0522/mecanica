<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AdeudoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('inicio',function(){
    if (!session()->has('user')) {
        return redirect()->route('login');
    }
    return view('inicio');
})->name('inicio');

Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');

Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');

Route::get('/adeudos', [AdeudoController::class, 'index'])->name('adeudos.index');

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');

Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devoluciones.index');