<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti; // Memakai Model Utama Anda
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil daftar bulan & tahun dinamis HANYA dari data yang ada di tabel 'pengajuan_cuti'
        $listPeriode = PengajuanCuti::selectRaw("YEAR(tanggal_mulai) as year, MONTH(tanggal_mulai) as month")
            ->whereNotNull('tanggal_mulai')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1)->locale('id');
                return (object) [
                    'value' => $date->format('m-Y'),
                    'label' => $date->translatedFormat('F Y'),
                ];
            });

        // 2. Ambil data jenis cuti untuk dropdown filter
        $listJenisCuti = JenisCuti::all();

        // 3. Query data pengajuan cuti beserta relasinya
        $query = PengajuanCuti::with(['karyawan.user', 'jenisCuti']);

        // Filter berdasarkan Periode (Bulan-Tahun)
        if ($request->filled('periode')) {
            [$bulan, $tahun] = explode('-', $request->periode);
            $query->whereMonth('tanggal_mulai', $bulan)
                  ->whereYear('tanggal_mulai', $tahun);
        }

        // Filter berdasarkan Jenis Cuti
        if ($request->filled('jenis_cuti')) {
            $query->where('jenis_cuti_id', $request->jenis_cuti);
        }

        $pengajuan = $query->latest()->paginate(10);

        // Langsung mengarah ke file resources/views/supervisor/pengajuan.blade.php
        return view('supervisor.pengajuan', compact('pengajuan', 'listPeriode', 'listJenisCuti'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanCuti::with(['karyawan.user', 'jenisCuti', 'approvals'])->findOrFail($id);
        return view('supervisor.pengajuan_detail', compact('pengajuan'));
    }
}