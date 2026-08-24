<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $supervisorId = Auth::id();

        // Hitung statistik berdasarkan approver_id di tabel approvals
        $totalDiproses = Approval::where('approver_id', $supervisorId)
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->count();
        
        $totalDisetujui = Approval::where('approver_id', $supervisorId)
            ->where('status', 'disetujui')
            ->count();

        $totalDitolak = Approval::where('approver_id', $supervisorId)
            ->where('status', 'ditolak')
            ->count();

        // Ambil data riwayat dari tabel approvals dengan relasi ke pengajuanCuti, karyawan, dan user
        $query = Approval::with(['pengajuanCuti.karyawan.user', 'pengajuanCuti.jenisCuti'])
            ->where('approver_id', $supervisorId)
            ->whereIn('status', ['disetujui', 'ditolak']);

        // Fitur Pencarian berdasarkan nama karyawan atau ID pengajuan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pengajuan_cuti_id', 'like', "%{$search}%")
                  ->orWhereHas('pengajuanCuti.karyawan.user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $riwayats = $query->latest('updated_at')->paginate(10);

        return view('supervisor.riwayat', compact('totalDiproses', 'totalDisetujui', 'totalDitolak', 'riwayats'));
    }
}