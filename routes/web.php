<?php

use App\Http\Controllers\Karyawan\CutiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Karyawan yang tadi kita buat
Route::middleware('auth')->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/ajukan-cuti', [CutiController::class, 'create'])->name('cuti.create');
    Route::post('/ajukan-cuti', [CutiController::class, 'store'])->name('cuti.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
