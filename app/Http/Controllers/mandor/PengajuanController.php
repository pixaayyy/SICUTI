<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        // Panggil relasi karyawan dan jenis_cuti untuk mencegah N+1 Query problem
        $query = PengajuanCuti::with(['karyawan', 'jenisCuti']);

        // 1. Logika Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Logika Filter Jenis Cuti (berdasarkan nama jenis cuti dari tabel relasi)
        if ($request->filled('jenis_cuti')) {
            $query->whereHas('jenisCuti', function($q) use ($request) {
                $q->where('nama', $request->jenis_cuti);
            });
        }

        // 3. Logika Filter Tanggal (jika nanti daterangepicker sudah aktif)
        if ($request->filled('daterange')) {
            // Contoh format dari frontend: 01/05/2026 - 31/05/2026
            $dates = explode(' - ', $request->daterange);
            if (count($dates) == 2) {
                $start = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
                $end = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');
                
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            }
        }

        // Ambil data terbaru
        $pengajuan = $query->latest()->get();

        // Panggil view pengajuan.blade.php di dalam folder views/mandor/
        return view('mandor.pengajuan', compact('pengajuan'));
    }

    public function show($id)
    {
        $detail = PengajuanCuti::with(['karyawan', 'jenisCuti'])->findOrFail($id);
        return view('mandor.detail_pengajuan', compact('detail'));
    }
}