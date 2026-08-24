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
        $query = PengajuanCuti::with(['karyawan', 'jenisCuti']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_cuti')) {
            $query->whereHas('jenisCuti', function ($q) use ($request) {
                $q->where('nama', $request->jenis_cuti);
            });
        }

        if ($request->filled('daterange')) {
            $dates = explode(' - ', $request->daterange);
            if (count($dates) == 2) {
                $start = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
                $end = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            }
        }
        $pengajuan = $query->latest()->get();
        return view('mandor.pengajuan', compact('pengajuan'));
    }

    public function create()
    {
        $user = auth()->user();
        $jenisCutis = JenisCuti::all();
        $sisaCuti = $user->sisa_cuti ?? 12;

        return view('mandor.ajukan_cuti', compact('jenisCutis', 'sisaCuti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti_id' => 'required|exists:jenis_cutis,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:1000',
            'catatan' => 'nullable|string|max:255',
            'data_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('data_pendukung')) {
            $filePath = $request->file('data_pendukung')->store('dokumen_cuti', 'public');
        }

        PengajuanCuti::create([
            'user_id' => auth()->id(),
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'catatan' => null,
            'data_pendukung' => $filePath,
            'status' => 'menunggu',
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
        $request->validate(['catatan' => 'required|string|max:255']);
        $pengajuan = \App\Models\PengajuanCuti::findOrFail($id);
        $pengajuan->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
    public function setujui($id)
    {
        $pengajuan = PengajuanCuti::findOrFail($id);
        $pengajuan->update([
            'status' => 'menunggu_supervisor',
            'catatan' => 'Disetujui oleh Mandor.',
        ]);

        return redirect()->route('mandor.pengajuan.index')->with('success', 'Pengajuan disetujui dan diteruskan ke Supervisor.');
    }
}