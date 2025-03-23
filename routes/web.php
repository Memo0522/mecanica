<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AdeudoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\FilterController;

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

Route::get('/buscarAlumno', [FilterController::class, 'buscarAlumno']);
Route::get('/buscarDescripcion', [FilterController::class, 'buscarDescripcion']);


Route::prefix('inventario')->controller(InventarioController::class)->group(function(){
    Route::get('/','index')->name('inventario.index');
    Route::get('/create','create')->name('inventario.create');
    Route::post('/store','store')->name('inventario.store');
    Route::put('/{codigo}','update')->name('inventario.update');
    Route::delete('/{codigo}','destroy')->name('inventario.destroy');
    Route::post('/inventario/importar', 'import')->name('inventario.import');
    Route::get('/{inventario}/edit',action: 'edit')->name('inventario.edit');
});

Route::prefix('prestamos')->controller(PrestamoController::class)->group(function(){
    Route::get('/','index')->name('prestamos.index');
    Route::get('/create','create')->name('prestamos.create');
    Route::get('/store','store')->name('prestamos.store');
});

Route::prefix('adeudos')->controller(AdeudoController::class)->group(function(){
    Route::get('/','index')->name('adeudos.index');
    Route::get('/create','create')->name('adeudos.create');
    Route::delete('/{id}','destroy')->name('adeudos.destroy');
    Route::post('/store','store')->name('adeudos.store');
    Route::get('/detalles/{id}','detalles');
    Route::put('/update/{id}','update')->name('adeudos.update');

});

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

Route::prefix('alumnos')->controller(AlumnoController::class)->group(function(){
    Route::get('/','index')->name('alumnos.index');
    Route::get('/create','create')->name('alumnos.create');
    Route::post('/store','store')->name('alumnos.store');
    Route::post('/importarAlumnos','importarAlumnos')->name('alumnos.importar');
    Route::put('/{matricula}','update')->name('alumnos.update');
    Route::delete('/{matricula}','destroy')->name('alumnos.destroy');
    Route::get('/{matricula}/edit',action: 'edit')->name('alumnos.edit');
});

Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devoluciones.index');