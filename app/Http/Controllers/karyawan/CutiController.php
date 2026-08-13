<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\JenisCuti; // Wajib dipanggil untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Wajib dipanggil untuk menghitung durasi hari

class CutiController extends Controller
{
    public function create()
    {
        $sisaCuti = 12; 
        
        // Mengambil data jenis cuti dari database (tabel jenis_cuti)
        $jenisCutis = JenisCuti::all(); 
        
        return view('karyawan.cuti.create', compact('sisaCuti', 'jenisCutis'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input sesuai nama kolom di Model baru
        $request->validate([
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'catatan' => 'nullable|string', // Menggantikan keterangan_khusus
            'data_pendukung' => 'nullable|file|mimes:pdf,jpg,png|max:5120', // Menggantikan dokumen
        ]);

        // 2. Hitung Durasi Cuti (Menggunakan Carbon)
        $start = Carbon::parse($request->tanggal_mulai);
        $end = Carbon::parse($request->tanggal_selesai);
        $durasi = $start->diffInDays($end) + 1; // Ditambah 1 agar misal tgl 13 ke 13 dihitung 1 hari

        // 3. Logika Upload Dokumen
        $pathDokumen = null;
        if ($request->hasFile('data_pendukung')) {
            $pathDokumen = $request->file('data_pendukung')->store('dokumen_cuti', 'public');
        }

        // 4. Pastikan User memiliki data Karyawan
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return back()->withErrors(['msg' => 'Data karyawan tidak ditemukan untuk akun ini.']);
        }

        // 5. Simpan Data ke Database
        PengajuanCuti::create([
            'karyawan_id' => $karyawan->id,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $durasi,
            'alasan' => $request->alasan,
            'catatan' => $request->catatan,
            'data_pendukung' => $pathDokumen,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('karyawan.cuti.create')->with('status', 'Hore! Pengajuan cuti Anda berhasil dikirim.');
    }
}