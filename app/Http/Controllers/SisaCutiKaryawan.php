<?php

namespace App\Http\Controllers;

use App\Models\SisaCuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class SisaCutiController extends Controller
{
    public function index()
    {
        $sisaCuti = SisaCuti::with('karyawan.user')->get();

        return view('sisa-cuti.index', compact('sisaCuti'));
    }

    public function create()
    {
        $karyawan = Karyawan::with('user')
            ->get();

        return view('sisa-cuti.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tahun' => 'required|integer',
            'jatah' => 'required|integer|min:0',
        ]);

        SisaCuti::create([
            'karyawan_id' => $request->karyawan_id,
            'tahun' => $request->tahun,
            'jatah' => $request->jatah,
            'terpakai' => 0,
            'sisa' => $request->jatah,
        ]);

        return redirect()
            ->route('sisa-cuti.index')
            ->with('success', 'Sisa cuti berhasil ditambahkan.');
    }

    public function edit(SisaCuti $sisaCuti)
    {
        $karyawan = Karyawan::with('user')->get();

        return view('sisa-cuti.edit', compact(
            'sisaCuti',
            'karyawan'
        ));
    }

    public function update(Request $request, SisaCuti $sisaCuti)
    {
        $request->validate([
            'jatah' => 'required|integer|min:0',
            'terpakai' => 'required|integer|min:0',
        ]);

        $jatah = $request->jatah;
        $terpakai = $request->terpakai;

        $sisaCuti->update([
            'jatah' => $jatah,
            'terpakai' => $terpakai,
            'sisa' => max(0, $jatah - $terpakai),
        ]);

        return redirect()
            ->route('sisa-cuti.index')
            ->with('success', 'Sisa cuti berhasil diperbarui.');
    }

    public function destroy(SisaCuti $sisaCuti)
    {
        $sisaCuti->delete();

        return redirect()
            ->route('sisa-cuti.index')
            ->with('success', 'Data sisa cuti berhasil dihapus.');
    }
}