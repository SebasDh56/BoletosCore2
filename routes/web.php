<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AssignRoleMiddleware;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('personas', PersonaController::class)->middleware([AssignRoleMiddleware::class . ':admin,cliente']);
Route::resource('cooperativas', CooperativaController::class)->middleware([AssignRoleMiddleware::class . ':admin']);
Route::resource('ventas', VentaController::class)->middleware([AssignRoleMiddleware::class . ':admin,cliente']);
Route::put('cooperativas/{cooperativa}', [CooperativaController::class, 'update'])->middleware([AssignRoleMiddleware::class . ':admin']);
Route::get('ventas/resumen', [VentaController::class, 'resumen'])->name('ventas.resumen')->middleware([AssignRoleMiddleware::class . ':admin,cliente']);
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware([AssignRoleMiddleware::class . ':admin']);
Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole')->middleware([AssignRoleMiddleware::class . ':admin']);
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware([AssignRoleMiddleware::class . ':admin']);
Auth::routes();