<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->middleware(['auth', 'verified'])->name('suppliers');

Route::get('/suppliers/show/{supplier}', [App\Http\Controllers\SupplierController::class, 'show'])->middleware(['auth', 'verified'])->name('suppliers.show');
Route::post('/suppliers', [App\Http\Controllers\SupplierController::class, 'store'])->middleware(['auth', 'verified'])->name('suppliers.store');

Route::middleware(['auth', 'verified'])->group(function () {
    // Layups
    Route::post('/suppliers/{supplier}/layups', [App\Http\Controllers\CltLayupController::class, 'store'])->name('layups.store');
    Route::get('/suppliers/{supplier}/layups/{layup}', [App\Http\Controllers\CltLayupController::class, 'show'])->name('layups.show');
    Route::put('/suppliers/{supplier}/layups/{layup}', [App\Http\Controllers\CltLayupController::class, 'update'])->name('layups.update');
    Route::delete('/suppliers/{supplier}/layups/{layup}', [App\Http\Controllers\CltLayupController::class, 'destroy'])->name('layups.destroy');

    Route::post('/layups/{layup}/layers', [App\Http\Controllers\CltLayerController::class, 'store'])->name('layers.store');
    Route::put('/layups/{layup}/layers/{layer}', [App\Http\Controllers\CltLayerController::class, 'update'])->name('layers.update');
    Route::delete('/layups/{layup}/layers/{layer}', [App\Http\Controllers\CltLayerController::class, 'destroy'])->name('layers.destroy');

    Route::get('/suppliers/{supplier}/export', [App\Http\Controllers\ImportExportController::class, 'export'])->name('suppliers.export');
    Route::post('/suppliers/{supplier}/import', [App\Http\Controllers\ImportExportController::class, 'import'])->name('suppliers.import');
    Route::post('/suppliers/{supplier}/resolve-conflicts', [App\Http\Controllers\ImportExportController::class, 'resolveConflicts'])->name('suppliers.resolve-conflicts');

    Route::get('/inventory/{supplier}/{layup}', [InventoryController::class, 'index'])->name('inventory');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
