<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\ProductionController;

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


    });

    //op
    Route::middleware(['role:operator'])->group(function () {

        Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])
            ->name('operator.dashboard');

        Route::resource('production', ProductionController::class)
            ->only(['index', 'create', 'store']);
    });
});
