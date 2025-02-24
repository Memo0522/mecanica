<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;

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

Route::get('inventario', [InventarioController::class, 'index'])->name('inventario.index');