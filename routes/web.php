<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Karyawan\CutiController;
use App\Http\Controllers\Karyawan\DashboardkController;
use App\Http\Controllers\Mandor\AnggotaTimController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\mandor\RiwayatController;


Route::get('/', function () {
    return view('welcome');
});

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


Route::middleware(['auth'])->prefix('mandor')->name('mandor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Mandor\DashboardController::class, 'index'])->name('dashboard');    
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/anggota-tim', function() { return 'Halaman Anggota Tim'; })->name('anggota');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/profil', function() { return 'Halaman Profil Mandor'; })->name('profil');

    Route::get('/pengajuan/{id}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{id}/setujui', [PengajuanController::class, 'setujui'])->name('pengajuan.setujui');
    Route::post('/pengajuan/{id}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');
    Route::get('/anggota-tim', [AnggotaTimController::class,'index'])->name('anggota');
});

require __DIR__ . '/auth.php';
