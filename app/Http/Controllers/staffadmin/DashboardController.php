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
        // 1. Total Pengajuan Selesai (Di-acc Supervisor)
        $total_selesai = PengajuanCuti::where('status', 'disetujui')->count();

        // 2. Total Karyawan Unik yang Cuti pada Bulan Ini (Berdasarkan yang di-acc Supervisor)
        $karyawan_cuti = PengajuanCuti::where('status', 'disetujui')
            ->whereYear('tanggal_mulai', Carbon::now()->year)
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
            $chartLabels[] = $date->translatedFormat('M');

            $chartData[] = PengajuanCuti::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('staffadmin.dashboard', compact(
            'total_selesai',
            'karyawan_cuti',
            'rata_durasi',
            'chartLabels',
            'chartData'
        ));
    }
}