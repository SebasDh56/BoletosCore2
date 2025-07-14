<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('personas', PersonaController::class)->middleware([\App\Http\Middleware\AssignRoleMiddleware::class, 'admin,cliente']);
Route::resource('cooperativas', CooperativaController::class)->middleware([\App\Http\Middleware\AssignRoleMiddleware::class, 'admin,cliente']);
Route::resource('ventas', VentaController::class)->middleware([\App\Http\Middleware\AssignRoleMiddleware::class, 'admin,cliente']);
Route::put('cooperativas/{cooperativa}', [CooperativaController::class, 'update'])->middleware([\App\Http\Middleware\AssignRoleMiddleware::class, 'admin']);
Route::get('ventas/resumen', [VentaController::class, 'resumen'])->name('ventas.resumen')->middleware([\App\Http\Middleware\AssignRoleMiddleware::class, 'admin,cliente']);
Route::get('/users', [UserController::class, 'index'])->middleware([\App\Http\Middleware\AssignRoleMiddleware::class, 'admin'])->name('users.index');
Auth::routes();