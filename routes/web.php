<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AssignRoleMiddleware;


Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas accesibles para ambos roles: admin y cliente
Route::middleware([AssignRoleMiddleware::class . ':admin,cliente'])->group(function () {
    Route::resource('personas', PersonaController::class);
    Route::resource('ventas', VentaController::class);
    Route::get('ventas/resumen', [VentaController::class, 'resumen'])->name('ventas.resumen');
});

// Rutas accesibles solo para admin
Route::middleware([AssignRoleMiddleware::class . ':admin'])->group(function () {
    Route::resource('cooperativas', CooperativaController::class);
    Route::put('cooperativas/{cooperativa}', [CooperativaController::class, 'update']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

