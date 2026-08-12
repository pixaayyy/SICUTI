<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    public function index()
    {
        $jenisCuti = JenisCuti::latest()->get();

        return view('jenis-cuti.index', compact('jenisCuti'));
    }

    public function create()
    {
        return view('jenis-cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        JenisCuti::create([
            'nama' => $request->nama,
        ]);

        return redirect()
            ->route('jenis-cuti.index')
            ->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    public function show(JenisCuti $jenisCuti)
    {
        return view('jenis-cuti.show', compact('jenisCuti'));
    }

    public function edit(JenisCuti $jenisCuti)
    {
        return view('jenis-cuti.edit', compact('jenisCuti'));
    }

    public function update(Request $request, JenisCuti $jenisCuti)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $jenisCuti->update([
            'nama' => $request->nama,
        ]);

        return redirect()
            ->route('jenis-cuti.index')
            ->with('success', 'Jenis cuti berhasil diperbarui.');
    }

    public function destroy(JenisCuti $jenisCuti)
    {
        $jenisCuti->delete();

        return redirect()
            ->route('jenis-cuti.index')
            ->with('success', 'Jenis cuti berhasil dihapus.');
    }
}