<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $listJenisCuti = JenisCuti::all();

        $listPeriode = PengajuanCuti::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as value, DATE_FORMAT(created_at, '%M %Y') as label")
            ->distinct()
            ->orderBy('value', 'desc')
            ->get();

        // Hanya ambil pengajuan yang berstatus 'disetujui_mandor'
        $query = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
            ->where('status', 'menunggu_supervisor')
            ->latest();

        if ($request->filled('periode')) {
            $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$request->periode]);
        }

        if ($request->filled('jenis_cuti')) {
            $query->where('jenis_cuti_id', $request->jenis_cuti);
        }

        $pengajuan = $query->paginate(10);

        return view('supervisor.pengajuan', compact('pengajuan', 'listPeriode', 'listJenisCuti'));
    }

    public function show($id)
    {
        $detail = PengajuanCuti::with([
            'karyawan.user', 
            'jenisCuti',
        ])->findOrFail($id);

        // Mengarahkan ke file view detail_pengajuan milik Supervisor
        return view('supervisor.detail_pengajuan', compact('detail'));
        // Jika file kamu ada di root supervisor, gunakan: return view('supervisor.detail_pengajuan', compact('detail'));
    }

    // Aksi: Supervisor Menyetujui Pengajuan
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $pengajuan = PengajuanCuti::with('karyawan')->findOrFail($id);

            $pengajuan->update([
                'status' => 'disetujui',
                'catatan_supervisor' => 'Pengajuan disetujui oleh Supervisor.',
            ]);

            if ($pengajuan->karyawan && $pengajuan->karyawan->sisa_cuti >= $pengajuan->durasi) {
                $pengajuan->karyawan->decrement('sisa_cuti', $pengajuan->durasi);
            }
        });

        return redirect()->route('supervisor.pengajuan.index')
            ->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    // Aksi: Supervisor Menolak Pengajuan
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|min:5|max:500',
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
            'catatan.min' => 'Alasan penolakan minimal berisi 5 karakter.',
        ]);

        $pengajuan = PengajuanCuti::findOrFail($id);

        // Update status menjadi ditolak
        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_supervisor' => $request->catatan,
        ]);

        return redirect()->route('supervisor.pengajuan.index')
            ->with('success', 'Pengajuan cuti berhasil ditolak.');
    }

    public function create()
    {
        $listJenisCuti = \App\Models\JenisCuti::all();

        // Arahkan ke view ajukan_cuti.blade.php
        return view('supervisor.ajukan_cuti', compact('listJenisCuti'));
        
        // Jika file berada di folder pengajuan, gunakan:
        // return view('supervisor.pengajuan.ajukan_cuti', compact('listJenisCuti'));
    }

    
}