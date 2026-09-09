<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Karyawan\CutiController;
use App\Http\Controllers\Karyawan\DashboardkController;
use App\Http\Controllers\Mandor\PengajuanController;
use App\Http\Controllers\Mandor\AnggotaTimController;
use App\Http\Controllers\mandor\RiwayatController;
use App\Http\Controllers\Supervisor\PengajuanController as SupervisorPengajuanController;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\RiwayatController as SupervisorRiwayatController; // <-- TAMBAHKAN BARIS INI
use App\Http\Controllers\StaffAdmin\DashboardController;
use App\Http\Controllers\StaffAdmin\RekapCutiController;
use App\Http\Controllers\StaffAdmin\RiwayatController as StaffAdminRiwayatController;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'karyawan') return redirect()->route('karyawan.dashboard');
        if ($role === 'mandor') return redirect()->route('mandor.dashboard');
        if ($role === 'supervisor') return redirect()->route('supervisor.dashboard');
        if ($role === 'staff_administrasi') return redirect()->route('staffadmin.dashboard');
        
    }
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// role karyawan
Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [DashboardkController::class, 'index'])->name('dashboard');
    Route::get('/ajukan-cuti', [CutiController::class, 'create'])->name('cuti.create');
    Route::post('/ajukan-cuti', [CutiController::class, 'store'])->name('cuti.store');
    Route::get('/status-pengajuan', [CutiController::class, 'status'])->name('cuti.status');
    Route::get('/riwayat-cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');        
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');
});

// role mandor
Route::middleware(['auth'])->prefix('mandor')->name('mandor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Mandor\DashboardController::class, 'index'])->name('dashboard');    
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/profil', function() { return 'Halaman Profil Mandor'; })->name('profil');

    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');   
    Route::get('/pengajuan/{id}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{id}/setujui', [PengajuanController::class, 'setujui'])->name('pengajuan.setujui');
    Route::post('/pengajuan/{id}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');
    Route::get('/anggota-tim', [AnggotaTimController::class,'index'])->name('anggota');
});

// role supervisor
Route::middleware(['auth'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/pengajuan/create', [SupervisorPengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan/store', [SupervisorPengajuanController::class, 'store'])->name('pengajuan.store');
    
    Route::get('/pengajuan', [SupervisorPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{id}', [SupervisorPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{id}/approve', [SupervisorPengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{id}/reject', [SupervisorPengajuanController::class, 'reject'])->name('pengajuan.reject');
    // Route::get('/pengajuan', [SupervisorPengajuanController::class, 'index'])->name('pengajuan.index');
    // Route::get('/pengajuan/{id}', [SupervisorPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/riwayat-keputusan', [SupervisorRiwayatController::class, 'index'])->name('riwayat');
});


// role staff administrasi
Route::prefix('staff-admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('staffadmin.dashboard');
    Route::get('/rekapcuti', [RekapCutiController::class, 'index'])->name('staffadmin.rekapcuti');        
    Route::get('/riwayat', [StaffAdminRiwayatController::class, 'index'])->name('staffadmin.riwayat');
});

require __DIR__ . '/auth.php';