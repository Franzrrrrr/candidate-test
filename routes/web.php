<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->middleware(['auth', 'verified'])->name('suppliers');

Route::get('/suppliers/show/{supplier}', [App\Http\Controllers\SupplierController::class, 'show'])->middleware(['auth', 'verified'])->name('suppliers.show');
Route::post('/suppliers', [App\Http\Controllers\SupplierController::class, 'store'])->middleware(['auth', 'verified'])->name('suppliers.store');
Route::put('/suppliers/{supplier}', [App\Http\Controllers\SupplierController::class, 'update'])->middleware(['auth', 'verified'])->name('suppliers.update');
Route::delete('/suppliers/{supplier}', [App\Http\Controllers\SupplierController::class, 'destroy'])->middleware(['auth', 'verified'])->name('suppliers.destroy');

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

    // Notifications
  Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');

Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

Route::get('/notifications/{notification}/import-rejected', [NotificationController::class, 'importRejected'])->name('notifications.import-rejected');

Route::get('/notifications/{notification}/conflict-details', [NotificationController::class, 'conflictDetails'])->name('notifications.conflict-details');

Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
