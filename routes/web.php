<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('operator.dashboard');
    })->name('dashboard');

    //admin
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/admin/raw-materials', [AdminMasterController::class, 'rawMaterialIndex'])
            ->name('admin.raw-materials.index');
    
        Route::get('/admin/raw-materials/create', [AdminMasterController::class, 'rawMaterialCreate'])
            ->name('admin.raw-materials.create');
    
        Route::post('/admin/raw-materials', [AdminMasterController::class, 'rawMaterialStore'])
            ->name('admin.raw-materials.store');
    
        Route::post('/admin/raw-materials/{material}/stock', [AdminMasterController::class, 'rawMaterialStock'])
            ->name('admin.raw-materials.stock');
    
        // Product
        Route::get('/admin/products', [AdminMasterController::class, 'productIndex'])
            ->name('admin.products.index');
    
        Route::get('/admin/products/create', [AdminMasterController::class, 'productCreate'])
            ->name('admin.products.create');
    
        Route::post('/admin/products', [AdminMasterController::class, 'productStore'])
            ->name('admin.products.store');

    });

    //op
    Route::middleware(['role:operator'])->group(function () {

        Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])
            ->name('operator.dashboard');

        Route::resource('production', ProductionController::class)
            ->only(['index', 'create', 'store']);

        Route::get('/operator/report', [ReportController::class, 'index'])->name('operator.report');
    });
});
