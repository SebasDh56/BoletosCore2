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

Route::middleware([AssignRoleMiddleware::class . ':admin,cliente'])->group(function () {
    Route::resource('personas', PersonaController::class);
    Route::resource('cooperativas', CooperativaController::class);
    Route::resource('ventas', VentaController::class);
    Route::put('cooperativas/{cooperativa}', [CooperativaController::class, 'update']);
    Route::get('ventas/resumen', [VentaController::class, 'resumen'])->name('ventas.resumen');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});