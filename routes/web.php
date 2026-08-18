<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Karyawan\CutiController;
use App\Http\Controllers\Karyawan\DashboardkController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Karyawan
Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', [DashboardkController::class, 'index'])->name('dashboard');
        Route::get('/ajukan-cuti', [CutiController::class, 'create'])->name('cuti.create');
        Route::post('/ajukan-cuti', [CutiController::class, 'store'])->name('cuti.store');
        Route::get('/status-pengajuan', [CutiController::class, 'status'])->name('cuti.status');
        Route::get('/riwayat-cuti', [CutiController::class, 'index'])->name('cuti.index');
        Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    });

// Route Profile Default
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', [DashboardkController::class, 'index'])->name('dashboard');
        Route::get('/ajukan-cuti', [CutiController::class, 'create'])->name('cuti.create');
        Route::post('/ajukan-cuti', [CutiController::class, 'store'])->name('cuti.store');
        Route::get('/status-pengajuan', [CutiController::class, 'status'])->name('cuti.status');
        Route::get('/riwayat-cuti', [CutiController::class, 'index'])->name('cuti.index');
        Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');        
        Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');
    });
});

require __DIR__ . '/auth.php';

