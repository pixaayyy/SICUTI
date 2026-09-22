<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data pengajuan cuti yang sudah final (disetujui atau ditolak)
        $query = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
                    ->whereIn('status', ['disetujui', 'ditolak']);

        // Fitur pencarian sederhana (berdasarkan ID atau Nama Karyawan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('karyawan.user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan dari yang paling baru diperbarui
        $riwayats = $query->latest('updated_at')->paginate(10);

        return view('hr.riwayat', compact('riwayats'));
    }
}