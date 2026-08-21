<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\JenisCuti;
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

    public function create()
    {
        // Ambil data user/mandor yang sedang login
        $user = auth()->user(); 

        // Ambil semua data jenis cuti
        $jenisCutis = JenisCuti::all();

        // Ambil sisa cuti user (sesuaikan jika nama kolomnya beda)
        $sisaCuti = $user->sisa_cuti ?? 12;

        return view('mandor.ajukan_cuti', compact('jenisCutis', 'sisaCuti'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'jenis_cuti_id'   => 'required|exists:jenis_cutis,id',
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|string|max:1000',
            'catatan'         => 'nullable|string|max:255',
            'data_pendukung'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('data_pendukung')) {
            $filePath = $request->file('data_pendukung')->store('dokumen_cuti', 'public');
        }

        // Simpan ke Database
        PengajuanCuti::create([
            'user_id'         => auth()->id(), // Sesuaikan dengan kolom ID relasi karyawan di database Anda (misal: karyawan_id)
            'jenis_cuti_id'   => $request->jenis_cuti_id,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan'          => $request->alasan,
            'catatan'         => $request->catatan,
            'data_pendukung'  => $filePath,
            'status'          => 'pending',
        ]);

        return redirect()->route('mandor.pengajuan.index')->with('status', 'Pengajuan cuti berhasil dikirim.');
    }

    public function show($id)
    {
        $detail = PengajuanCuti::with(['karyawan', 'jenisCuti'])->findOrFail($id);
        return view('mandor.detail_pengajuan', compact('detail'));
    }

    public function tolak(Request $request, $id)
    {
        $pengajuan = \App\Models\PengajuanCuti::findOrFail($id);
        $pengajuan->update([
            'status' => 'ditolak',
        ]);

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil ditolak.');
    }

    public function setujui($id)
    {
        $pengajuan = \App\Models\PengajuanCuti::findOrFail($id);
        $pengajuan->update([
            'status' => 'disetujui'
        ]);
        return redirect()->back()->with('success', 'Pengajuan cuti berhasil disetujui.');
    }
}