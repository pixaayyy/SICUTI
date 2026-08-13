<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function create()
    {
        // Anggap saja kita mengambil data sisa cuti dari database. 
        // Sementara kita hardcode 12 sesuai desain UI kamu.
        $sisaCuti = 12; 
        
        return view('karyawan.cuti.create', compact('sisaCuti'));
    }

    public function store(Request $request)
    {
        // Validasi input sesuai dengan field di form
        $request->validate([
            'jenis_cuti' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120', // Maks 5MB sesuai UI
        ]);

        // TODO: Logika simpan data ke database tabel 'pengajuan_cuti' akan diletakkan di sini.

        return redirect()->route('karyawan.cuti.create')->with('status', 'Pengajuan cuti berhasil dikirim!');
    }
}