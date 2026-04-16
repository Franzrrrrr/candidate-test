<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->middleware(['auth', 'verified'])->name('suppliers');

Route::get('/suppliers/show/{supplier}', [App\Http\Controllers\SupplierController::class, 'show'])->middleware(['auth', 'verified'])->name('suppliers.show');
// Route::get('/suppliers/create', [App\Http\Controllers\SupplierController::class, 'create'])->middleware(['auth', 'verified'])->name('suppliers.create');
Route::post('/suppliers', [App\Http\Controllers\SupplierController::class, 'store'])->middleware(['auth', 'verified'])->name('suppliers.store');

Route::get('/inventory', function () {
    return view('pages.inventory.inventory');
})->middleware(['auth', 'verified'])->name('inventory');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
