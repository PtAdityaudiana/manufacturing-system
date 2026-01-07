<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\ReportController;

Route::middleware(['web', 'auth', 'role:operator'])->group(function () {

    Route::get('/me', fn () => auth()->user());
    
    Route::get('/operator/{id}', [ProductionController::class, 'showUser']);
    Route::get('/productions', [ProductionController::class, 'index']);

    Route::get('/reports/production', [ReportController::class, 'production']);
    Route::get('/reports/production/{id}', [ReportController::class, 'productionbyId']);

    Route::post('/productions', [ProductionController::class, 'store']);
    Route::get('/productions/{id}', [ProductionController::class, 'show']);
});

Route::middleware(['web', 'auth', 'role:admin'])->group(function () {
    Route::get('/operator/{id}', [ProductionController::class, 'showUser']);
    Route::get('/productions', [ProductionController::class, 'index']);

    Route::get('/rawmaterials', [ProductionController::class, 'rawMaterialStock']);

    Route::get('/reports/production', [ReportController::class, 'production']);
    Route::get('/reports/production/{id}', [ReportController::class, 'productionbyId']);
});
