<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Hanya mengambil pengajuan cuti yang sudah diproses (disetujui / ditolak)
        $query = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
                    ->whereIn('status', ['disetujui', 'ditolak']);

        // 1. Filter Status (disetujui / ditolak)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Filter Jenis Cuti
        if ($request->filled('jenis_cuti')) {
            $query->whereHas('jenisCuti', function ($q) use ($request) {
                $q->where('nama', $request->jenis_cuti);
            });
        }

        // 3. Filter Periode (Format MM-YYYY, contoh: 05-2026)
        if ($request->filled('periode')) {
            $parts = explode('-', $request->periode);
            if (count($parts) === 2) {
                $query->whereMonth('tanggal_mulai', $parts[0])
                      ->whereYear('tanggal_mulai', $parts[1]);
            }
        }

        // Ambil data terbaru berdasarkan waktu keputusan (updated_at)
        $riwayat = $query->latest('updated_at')->paginate(10);

        return view('mandor.riwayat', compact('riwayat'));
    }
}