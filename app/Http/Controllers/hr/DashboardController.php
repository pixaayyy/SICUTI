<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;
use Carbon\Carbon; // Untuk memanipulasi format bulan/waktu

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Metrics (Ringkasan Atas)
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $metrics = [
            // Asumsi status menunggu HR. Sesuaikan jika HR memantau status 'menunggu_supervisor' dsb.
            'menunggu' => PengajuanCuti::whereIn('status', ['menunggu', 'menunggu_supervisor'])->count(), 
            
            // Total disetujui khusus bulan ini
            'disetujui' => PengajuanCuti::where('status', 'disetujui')
                                        ->whereMonth('updated_at', $bulanIni)
                                        ->whereYear('updated_at', $tahunIni)
                                        ->count(),
                                        
            'ditolak' => PengajuanCuti::where('status', 'ditolak')->count()
        ];

        // 2. Ambil 5 Data Pengajuan Terbaru untuk Tabel
        // Eager loading relasi karyawan.user dan jenisCuti agar query lebih cepat
        $terbaru = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
                                ->latest() // Urutkan dari yang paling baru
                                ->take(5)  // Ambil 5 data saja
                                ->get();

        return view('hr.dashboard', compact('metrics', 'terbaru'));
    }
}