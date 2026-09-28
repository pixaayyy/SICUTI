<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
   public function create()
    {
        $daftar_pegawai = \App\Models\User::with('karyawan')->orderBy('created_at', 'desc')->get();
        
        return view('staffadmin.tambahpegawai', compact('daftar_pegawai')); 
    }

    public function store(Request $request)
    {
        // Tambahkan validasi untuk departemen dan tanggal_bergabung
        $request->validate([
            'name'              => 'required|string|max:255',
            'username'          => 'required|string|max:255|unique:users,username',
            'email'             => 'required|email|max:255|unique:users,email',
            'password'          => 'required|min:8',
            'role'              => 'required|in:karyawan,mandor,supervisor,staff_administrasi,hr',
            'departemen'        => 'required|string|max:255', // Validasi baru
            'tanggal_bergabung' => 'required|date', // Validasi baru
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        \App\Models\Karyawan::create([
            'user_id'           => $user->id,
            'departemen'        => $request->departemen,
            'tanggal_bergabung' => $request->tanggal_bergabung,
        ]);

        return redirect()->route('staffadmin.pegawai.create')->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);
        $pegawai->delete();

        return redirect()->back()->with('success', 'Data pegawai berhasil dihapus!');
    }
}