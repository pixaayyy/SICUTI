<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisCuti;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $menunggu = PengajuanCuti::where('status', 'menunggu_supervisor')->count();
        $disetujui = PengajuanCuti::where('status', 'disetujui')
            ->whereMonth('created_at', now()->month)
            ->count();
        $ditolak = PengajuanCuti::where('status', 'ditolak')
            ->whereMonth('created_at', now()->month)
            ->count();

        $antreanTerbaru = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
            ->where('status', 'menunggu_supervisor')
            ->latest()
            ->take(5)
            ->get();

        $jenisCutiList = JenisCuti::all();
        $chartLabels = [];
        $chartData = [];

        foreach ($jenisCutiList as $jenis) {
            $chartLabels[] = $jenis->nama;
            $chartData[] = PengajuanCuti::where('jenis_cuti_id', $jenis->id)->count();
        }

        return view('supervisor.dashboard', compact(
            'user', 
            'menunggu', 
            'disetujui', 
            'ditolak', 
            'antreanTerbaru', 
            'chartLabels', 
            'chartData'
        ));
    }
}