<?php

namespace App\Http\Controllers\Mandor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Carbon\Carbon;

class AnggotaTimController extends Controller
{
    public function index(Request $request)
    {
        $tahunIni = Carbon::now()->year;

        $search = $request->input('search');


        // ==========================================
        // QUERY ANGGOTA
        // ==========================================

        $query = Karyawan::with([
            'user',
            'sisaCuti' => function ($q) use ($tahunIni) {
                $q->where('tahun', $tahunIni);
            }
        ]);


        // ==========================================
        // SEARCH
        // ==========================================

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('jabatan', 'like', "%{$search}%")

                  ->orWhere('departemen', 'like', "%{$search}%")

                  ->orWhereHas('user', function ($userQuery) use ($search) {

                      $userQuery->where(
                          'name',
                          'like',
                          "%{$search}%"
                      );

                  });

            });

        }


        // ==========================================
        // AMBIL DATA
        // ==========================================

        $anggotaTim = $query
            ->orderBy('created_at', 'desc')
            ->get();


        return view(
            'mandor.anggota',
            compact(
                'anggotaTim',
                'search'
            )
        );
    }
}