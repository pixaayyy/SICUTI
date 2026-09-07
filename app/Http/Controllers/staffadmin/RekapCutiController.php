<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class RekapCutiController extends Controller
{
    public function index(Request $request)
    {
        // Tahun yang dipilih
        $tahun = $request->get('tahun', now()->year);

        // Departemen yang dipilih
        $departemen = $request->get('departemen');

        // Query karyawan
        $query = Karyawan::with([
            'user',
            'sisaCuti'
        ]);

        // Filter departemen
        if (!empty($departemen)) {
            $query->where('departemen', $departemen);
        }

        // Ambil data karyawan
        $karyawans = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Ambil daftar departemen dari database
        $departemens = Karyawan::whereNotNull('departemen')
            ->where('departemen', '!=', '')
            ->distinct()
            ->orderBy('departemen')
            ->pluck('departemen');

        return view('staffadmin.rekapcuti', compact(
            'karyawans',
            'departemens',
            'tahun',
            'departemen'
        ));
    }
}