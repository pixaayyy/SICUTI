<?php

namespace App\Http\Controllers\HR;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCuti;

class PengajuanController extends Controller
{
    // Mengarahkan ke halaman "Lihat Semua" (Persetujuan Cuti)
    public function index()
    {
        // Menarik semua data pengajuan cuti dari yang terbaru
        $pengajuans = PengajuanCuti::with(['karyawan.user', 'jenisCuti'])
                        ->latest()
                        ->paginate(10);

        return view('hr.persetujuan', compact('pengajuans'));
    }

    // Menampilkan detail spesifik dari satu pengajuan (Tombol Detail)
    public function show($id)
    {
        // Cari data berdasarkan ID, jika tidak ada maka muncul error 404
        $pengajuan = PengajuanCuti::with(['karyawan.user', 'jenisCuti', 'approvals'])->findOrFail($id);

        return view('hr.pengajuan_detail', compact('pengajuan'));
    }

    // Memproses aksi setujui atau tolak dari HR
    public function proses(Request $request, $id)
    {
        $pengajuan = PengajuanCuti::findOrFail($id);

        // Ambil data action dari button mana yang diklik (setujui / tolak)
        $action = $request->input('action');
        
        if ($action == 'setujui') {
            $pengajuan->status = 'disetujui';
        } elseif ($action == 'tolak') {
            $pengajuan->status = 'ditolak';
        }

        // Simpan catatan jika HR mengisi textarea
        if ($request->filled('catatan')) {
            $pengajuan->catatan = $request->catatan;
        }

        $pengajuan->save();

        // Redirect kembali ke halaman persetujuan dengan pesan sukses
        return redirect()->route('hr.persetujuan')->with('success', 'Pengajuan cuti berhasil di' . $action);
    }

    // Fungsi untuk mengunduh lampiran
    public function download($id)
    {
        $pengajuan = PengajuanCuti::findOrFail($id);
        $filePath = $pengajuan->data_pendukung; 

        if (!$filePath) {
            return back()->with('error', 'Tidak ada file lampiran untuk pengajuan ini.');
        }

        // Karena path di database adalah "dokumen_cuti/namafile.jpg"
        // Kita gunakan disk 'public' secara langsung
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        // Fallback cadangan jika file tersimpan dengan cara lain
        $fullPath = storage_path('app/public/' . $filePath);
        if (file_exists($fullPath)) {
            return response()->download($fullPath);
        }

        return back()->with('error', 'File fisik tidak ditemukan di direktori storage server.');
    }

}