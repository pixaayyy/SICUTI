<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data pengajuan cuti dengan status final (disetujui atau ditolak)
        $query = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
            ->whereIn('status', ['disetujui', 'ditolak']);

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Asumsi pencarian berdasarkan ID atau Nama Karyawan
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('karyawan.user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan berdasarkan yang paling baru diupdate (tanggal selesai)
        $riwayats = $query->latest('updated_at')->paginate(10);

        // Sesuaikan nama view dengan struktur foldermu
        return view('staffadmin.riwayat', compact('riwayats')); 
    }
}