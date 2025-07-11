<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('ventas/resumen', [VentaController::class, 'resumen'])->name('ventas.resumen');
Route::resource('cooperativas', CooperativaController::class);
Route::resource('personas', PersonaController::class);
Route::resource('ventas', VentaController::class);


Route::get('/inicio', function () {
    return view('inicio');
});

Route::get('/suma', function () {
    return view('suma');
});

Route::post('/suma', function (Request $request) {
    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $resultado = $num1 + $num2;
    return view('suma', ['resultado' => $resultado]);
    
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
