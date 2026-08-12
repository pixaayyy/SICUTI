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

        $sisaCuti = SisaCuti::where('karyawan_id', $karyawan->id)
            ->latest('tahun')
            ->first();

        $tahun = $sisaCuti->tahun ?? date('Y');

        $jatahCuti = $sisaCuti->jatah ?? 0;
        $cutiTerpakai = $sisaCuti->terpakai ?? 0;
        $sisaCutiHari = $sisaCuti->sisa ?? 0;

        $cutiDitolak = PengajuanCuti::where('karyawan_id', $karyawan->id)
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