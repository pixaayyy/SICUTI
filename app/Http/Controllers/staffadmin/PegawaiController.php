<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Menampilkan form tambah pegawai.
     */
    public function create()
        {
            // Hapus kata 'pegawai.' di tengah
            return view('staffadmin.tambahpegawai'); 
        }
    /**
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:karyawan,mandor,supervisor,staff_administrasi,hr',
        ]);

        // 1. Simpan data akun ke tabel 'users'
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // 2. Jika role yang dipilih adalah 'karyawan', otomatis buat relasinya di tabel 'karyawan'
        if ($request->role === 'karyawan') {
            \App\Models\Karyawan::create([
                'user_id' => $user->id,
                // Catatan: Jika di tabel karyawan Anda ada kolom lain yang wajib (NOT NULL)
                // seperti 'nama_lengkap' atau 'nip', silakan tambahkan di bawah ini, contoh:
                // 'nama' => $request->name,
            ]);
        }

        return redirect()->route('staffadmin.pegawai.create')
                         ->with('success', 'Data pegawai berhasil ditambahkan!');
    }
}