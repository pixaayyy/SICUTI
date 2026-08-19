<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanCuti::with(['karyawan', 'jenisCuti']);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Jenis Cuti (berdasarkan ID atau Nama tergantung database Anda)
        if ($request->filled('jenis_cuti')) {
            $query->where('jenis_cuti_id', $request->jenis_cuti); 
            // Jika jenis cuti di database berupa string/nama, gunakan:
            // $query->whereHas('jenisCuti', function($q) use ($request) {
            //     $q->where('nama', $request->jenis_cuti);
            // });
        }

        // Filter Tanggal (Dari tanggal_mulai sampai tanggal_selesai)
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal_mulai')) {
            $query->where('tanggal_mulai', '>=', $request->tanggal_mulai);
        } elseif ($request->filled('tanggal_selesai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_selesai);
        }

        $pengajuan = $query->latest()->get();

        return view('mandor.pengajuan', compact('pengajuan'));
    }

    public function show($id)
    {
        $detail = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])->findOrFail($id);
        return view('mandor.detail_pengajuan', compact('detail'));
    }
    public function getDetail($id)
    {
        $detail = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])->findOrFail($id);
        return response()->json($detail);
    }
    public function setujui($id)
    {
        $pengajuan = PengajuanCuti::findOrFail($id);
        $pengajuan->update(['status' => 'disetujui']);

        return redirect()->route('mandor.pengajuan.index')->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    public function tolak($id)
    {
        $pengajuan = PengajuanCuti::findOrFail($id);
        $pengajuan->update(['status' => 'ditolak']);

        return redirect()->route('mandor.pengajuan.index')->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
}