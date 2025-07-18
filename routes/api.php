
<?php
use App\Http\Controllers\VentaController;
Route::prefix('ventas')->group(function () {
    Route::get('/', [VentaController::class, 'indexApi']);
    Route::post('/', [VentaController::class, 'storeApi']);
});