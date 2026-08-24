<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])->whereIn('status', ['disetujui', 'ditolak']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('jenis_cuti')) {
            $query->whereHas('jenisCuti', function ($q) use ($request) {$q->where('nama', $request->jenis_cuti);});
        }

        if ($request->filled('periode')) {
            $parts = explode('-', $request->periode);
            if (count($parts) === 2) {
                $query->whereMonth('tanggal_mulai', $parts[0])
                      ->whereYear('tanggal_mulai', $parts[1]);
            }
        }
        $riwayat = $query->latest('updated_at')->paginate(10);
        return view('mandor.riwayat', compact('riwayat'));
    }
}