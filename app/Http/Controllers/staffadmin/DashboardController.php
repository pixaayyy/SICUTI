<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pengajuan Selesai / Disetujui
        // (Sesuaikan string 'approved' dengan nilai status di database Anda, misal: 'approved', 'selesai', atau 'disetujui')
        $total_selesai = PengajuanCuti::where('status', 'approved')->count();

        // 2. Total Karyawan Unik yang Cuti pada Bulan Ini
        $karyawan_cuti = PengajuanCuti::whereYear('tanggal_mulai', Carbon::now()->year)
            ->whereMonth('tanggal_mulai', Carbon::now()->month)
            ->distinct('karyawan_id')
            ->count('karyawan_id');

        // 3. Rata-rata Durasi Cuti (dibulatkan 1 angka di belakang koma)
        $rata_durasi = round(PengajuanCuti::avg('durasi') ?? 0, 1);

        // 4. Data untuk Grafik Tren Cuti 6 Bulan Terakhir
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M'); // Contoh: Okt, Nov, Des, Jan, Feb, Mar
            
            // Menghitung jumlah pengajuan berdasarkan bulan pembuatan data
            $chartData[] = PengajuanCuti::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Me-return view dashboard dan passing data dinamis ke view
        return view('staffadmin.dashboard', compact(
            'total_selesai',
            'karyawan_cuti',
            'rata_durasi',
            'chartLabels',
            'chartData'
        ));
    }
}