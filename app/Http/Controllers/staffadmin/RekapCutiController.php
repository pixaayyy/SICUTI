<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapCutiController extends Controller
{
    public function index(Request $request)
    {
        $tahun       = $request->get('tahun', now()->year);
        $bulan       = $request->get('bulan'); 
        $departemen  = $request->get('departemen');
        $jenisCutiId = $request->get('jenis_cuti');
        $status      = $request->get('status');

        $query = Karyawan::with([
            'user',
            'sisaCuti' => function($q) use ($tahun) {
                $q->where('tahun', $tahun);
            },
            'pengajuanCuti' => function($q) use ($tahun, $bulan, $jenisCutiId) {
                $q->with('jenisCuti');
                $q->whereYear('tanggal_mulai', $tahun);
                if (!empty($bulan)) {
                    $q->whereMonth('tanggal_mulai', $bulan);
                }
                if (!empty($jenisCutiId)) {
                    $q->where('jenis_cuti_id', $jenisCutiId);
                }
            }
        ]);

        if (!empty($departemen)) {
            $query->where('departemen', $departemen);
        }

        if (!empty($jenisCutiId) || !empty($bulan)) {
            $query->whereHas('pengajuanCuti', function($q) use ($tahun, $bulan, $jenisCutiId) {
                $q->whereYear('tanggal_mulai', $tahun);
                if (!empty($bulan)) {
                    $q->whereMonth('tanggal_mulai', $bulan);
                }
                if (!empty($jenisCutiId)) {
                    $q->where('jenis_cuti_id', $jenisCutiId);
                }
            });
        }

        $karyawans = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $departemens = Karyawan::whereNotNull('departemen')
            ->where('departemen', '!=', '')
            ->distinct()
            ->orderBy('departemen')
            ->pluck('departemen');

        $listJenisCuti = JenisCuti::orderBy('nama')->get();

        return view('staffadmin.rekapcuti', compact(
            'karyawans',
            'departemens',
            'listJenisCuti',
            'tahun',
            'bulan',
            'departemen',
            'jenisCutiId',
            'status'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $tahun       = $request->get('tahun', now()->year);
        $bulan       = $request->get('bulan'); 
        $departemen  = $request->get('departemen');
        $jenisCutiId = $request->get('jenis_cuti');

        $query = Karyawan::with([
            'user',
            'sisaCuti' => function($q) use ($tahun) {
                $q->where('tahun', $tahun);
            },
            'pengajuanCuti' => function($q) use ($tahun, $bulan, $jenisCutiId) {
                $q->whereYear('tanggal_mulai', $tahun);
                if (!empty($bulan)) $q->whereMonth('tanggal_mulai', $bulan);
                if (!empty($jenisCutiId)) $q->where('jenis_cuti_id', $jenisCutiId);
            }
        ]);

        if (!empty($departemen)) {
            $query->where('departemen', $departemen);
        }

        $karyawans = $query->get();

        $fileName = 'Rekap_Cuti_' . $tahun . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($karyawans) {
            $file = fopen('php://output', 'w');
            // Header kolom CSV
            fputcsv($file, ['NIK', 'Nama Karyawan', 'Departemen', 'Jatah Cuti', 'Cuti Diambil', 'Sisa Kuota', 'Status Kuota']);

            foreach ($karyawans as $row) {
                $sisaCuti = $row->sisaCuti?->first() ?? $row->sisaCuti;
                $jatahCuti = $sisaCuti?->jatah ?? 12;
                $cutiDiambil = $sisaCuti?->terpakai ?? $row->pengajuanCuti->sum('durasi');
                $sisa = $sisaCuti?->sisa ?? ($jatahCuti - $cutiDiambil);

                if ($sisa <= 0) $statusText = 'Habis';
                elseif ($sisa <= 3) $statusText = 'Kritis';
                else $statusText = 'Aman';

                $nama = $row->user->name ?? $row->nama ?? $row->name ?? 'Karyawan';

                fputcsv($file, [
                    $row->nik ?? '-',
                    $nama,
                    $row->departemen ?? '-',
                    $jatahCuti,
                    $cutiDiambil,
                    $sisa,
                    $statusText
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}