<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use App\Models\SisaCuti;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;

class DashboardkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;
        $tahun = date('Y'); 

        // Proteksi: Jika user belum punya data di tabel karyawan, tampilkan dashboard kosong
        if (!$karyawan) {
            return view('karyawan.dashboard', [
                'user' => $user,
                'karyawan' => null,
                'tahun' => $tahun,
                'jatahCuti' => 0,
                'cutiTerpakai' => 0,
                'sisaCutiHari' => 0,
                'cutiDitolak' => 0,
                'pengajuanTerbaru' => []
            ]);
        }

        $dataSisaCuti = SisaCuti::where('karyawan_id', $karyawan->id)
            ->latest('tahun')
            ->first();
            
        $jatahCuti = $dataSisaCuti->jatah ?? 12;

        $cutiTerpakai = PengajuanCuti::where('karyawan_id', $karyawan->id)
            ->whereYear('tanggal_mulai', $tahun)
            ->where('status', 'disetujui') 
            ->sum('durasi');

        $sisaCutiHari = $jatahCuti - $cutiTerpakai;

        if ($sisaCutiHari < 0) {
            $sisaCutiHari = 0;
        }

        $cutiDitolak = PengajuanCuti::where('karyawan_id', $karyawan->id)
            ->whereYear('tanggal_mulai', $tahun)
            ->where('status', 'ditolak')
            ->count();

        $pengajuanTerbaru = PengajuanCuti::with('jenisCuti')
            ->where('karyawan_id', $karyawan->id)
            ->latest()
            ->take(5)
            ->get();

        return view('karyawan.dashboard', compact(
            'user',
            'karyawan',
            'tahun',
            'jatahCuti',
            'cutiTerpakai',
            'sisaCutiHari',
            'cutiDitolak',
            'pengajuanTerbaru'
        ));
    }
}