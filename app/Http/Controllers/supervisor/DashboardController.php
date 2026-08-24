<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bulanIni = now()->month;

        // Hitung Statistik
        $menunggu = PengajuanCuti::where('status', 'menunggu_supervisor')->count();
        $disetujui = PengajuanCuti::where('status', 'disetujui')
                        ->whereMonth('updated_at', $bulanIni)->count();
        $ditolak = PengajuanCuti::whereIn('status', ['ditolak', 'ditolak_supervisor'])
                        ->whereMonth('updated_at', $bulanIni)->count();

        // Ambil 5 Antrean Terbaru
        $antreanTerbaru = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
                        ->where('status', 'menunggu_supervisor')
                        ->latest()
                        ->take(5)
                        ->get();

        // Ambil Data untuk Diagram Lingkaran (Hanya yang sudah disetujui)
        $distribusi = PengajuanCuti::with('jenisCuti')
                        ->selectRaw('jenis_cuti_id, count(*) as total')
                        ->where('status', 'disetujui')
                        ->groupBy('jenis_cuti_id')
                        ->get();

        // Format data untuk Chart.js
        $chartLabels = [];
        $chartData = [];
        foreach ($distribusi as $item) {
            $chartLabels[] = $item->jenisCuti->nama ?? 'Lainnya';
            $chartData[] = $item->total;
        }

        return view('supervisor.dashboard', compact(
            'user', 'menunggu', 'disetujui', 'ditolak', 'antreanTerbaru', 'chartLabels', 'chartData'
        ));
    }
}