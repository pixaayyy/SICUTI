<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;
use App\Models\Karyawan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. Perhitungan menggunakan status huruf kecil ('menunggu', 'disetujui', 'ditolak')
        $menunggu = PengajuanCuti::where('status', 'menunggu')->count();
        
        $disetujuiBulanIni = PengajuanCuti::where('status', 'disetujui')
                                          ->whereMonth('created_at', $bulanIni)
                                          ->whereYear('created_at', $tahunIni)
                                          ->count();
                                          
        $ditolakTotal = PengajuanCuti::where('status', 'ditolak')->count();
        
        $totalAnggota = Karyawan::count();

        // 2. Ambil data pengajuan dengan relasi jenisCuti dan user
        $pengajuanTerbaru = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
                                         ->where('status', 'menunggu')
                                         ->latest()
                                         ->take(5)
                                         ->get();

        // 3. Data Grafik
        $grafik = [
            'disetujui' => $disetujuiBulanIni,
            'ditolak' => PengajuanCuti::where('status', 'ditolak')->whereMonth('created_at', $bulanIni)->count(),
            'menunggu' => PengajuanCuti::where('status', 'menunggu')->whereMonth('created_at', $bulanIni)->count(),
        ];
        
        $totalGrafik = array_sum($grafik);
        $totalGrafik = $totalGrafik == 0 ? 1 : $totalGrafik;

        return view('mandor.dashboard', compact(
            'menunggu', 'disetujuiBulanIni', 'ditolakTotal', 'totalAnggota', 
            'pengajuanTerbaru', 'grafik', 'totalGrafik'
        ));
    }
}