<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('user')->get();

        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',

            'nik' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            // Membuat akun user
            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Upload foto jika ada
            $foto = null;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto')
                    ->store('foto-karyawan', 'public');
            }

            // Membuat data karyawan
            Karyawan::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'jabatan' => $request->jabatan,
                'departemen' => $request->departemen,
                'no_telepon' => $request->no_telepon,
                'foto' => $foto,
            ]);
        });

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('user');

        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('user');

        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $karyawan->user_id,
            'email' => 'required|email|max:255|unique:users,email,' . $karyawan->user_id,

            'nik' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $karyawan) {

            $karyawan->load('user');

            $karyawan->user->update([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            $data = [
                'nik' => $request->nik,
                'jabatan' => $request->jabatan,
                'departemen' => $request->departemen,
                'no_telepon' => $request->no_telepon,
            ];

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')
                    ->store('foto-karyawan', 'public');
            }

            $karyawan->update($data);
        });

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        DB::transaction(function () use ($karyawan) {

            $user = $karyawan->user;

            $karyawan->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}