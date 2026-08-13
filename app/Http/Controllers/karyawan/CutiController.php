<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()
                ->route('karyawan.dashboard')
                ->withErrors([
                    'msg' => 'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }

        $jenisCutis = JenisCuti::orderBy('nama')->get();
        $jatahCuti = 12;
        $tahun = Carbon::now()->year;

        $cutiTerpakai = PengajuanCuti::where('karyawan_id', $karyawan->id)
            ->where('status', 'Disetujui')
            ->whereYear('tanggal_mulai', $tahun)
            ->sum('durasi');

        $sisaCuti = max(0, $jatahCuti - $cutiTerpakai);

        return view(
            'karyawan.cuti.create',
            compact(
                'jenisCutis',
                'sisaCuti'
            )
        );
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return back()
                ->withInput()
                ->withErrors([
                    'msg' => 'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }

        $validated = $request->validate([
            'jenis_cuti_id' => [
                'required',
                'exists:jenis_cuti,id'
            ],
            'tanggal_mulai' => [
                'required',
                'date'
            ],
            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai'
            ],
            'alasan' => [
                'required',
                'string',
                'max:1000'
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:500'
            ],
            'data_pendukung' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120'
            ],
        ]);

        $start = Carbon::parse(
            $validated['tanggal_mulai']
        );

        $end = Carbon::parse(
            $validated['tanggal_selesai']
        );

        $durasi = $start->diffInDays($end) + 1;

        $jatahCuti = 12;
        $tahun = Carbon::now()->year;

        $cutiTerpakai = PengajuanCuti::where(
                'karyawan_id',
                $karyawan->id
            )
            ->where(
                'status',
                'Disetujui'
            )
            ->whereYear(
                'tanggal_mulai',
                $tahun
            )
            ->sum('durasi');

        $sisaCuti = max(
            0,
            $jatahCuti - $cutiTerpakai
        );

        if ($durasi > $sisaCuti) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal_selesai' =>
                        'Durasi cuti yang diajukan (' .
                        $durasi .
                        ' hari) melebihi sisa cuti Anda (' .
                        $sisaCuti .
                        ' hari).'
                ]);
        }

        $pathDokumen = null;

        if ($request->hasFile('data_pendukung')) {
            $pathDokumen = $request
                ->file('data_pendukung')
                ->store(
                    'dokumen_cuti',
                    'public'
                );
        }

        PengajuanCuti::create([
            'karyawan_id' => $karyawan->id,
            'jenis_cuti_id' =>
                $validated['jenis_cuti_id'],
            'tanggal_mulai' =>
                $validated['tanggal_mulai'],
            'tanggal_selesai' =>
                $validated['tanggal_selesai'],
            'durasi' =>
                $durasi,
            'alasan' =>
                $validated['alasan'],
            'catatan' =>
                $validated['catatan'] ?? null,
            'data_pendukung' =>
                $pathDokumen,
            'status' =>
                'Menunggu',
        ]);

        return redirect()
            ->route('karyawan.cuti.index')
            ->with(
                'status',
                'Hore! Pengajuan cuti Anda berhasil dikirim.'
            );
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()
                ->route('karyawan.dashboard')
                ->withErrors([
                    'msg' =>
                        'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }

        $jenisCutis = JenisCuti::orderBy('nama')->get();

        $query = PengajuanCuti::with('jenisCuti')
            ->where(
                'karyawan_id',
                $karyawan->id
            );

        if ($request->filled('jenis_cuti_id')) {
            $query->where(
                'jenis_cuti_id',
                $request->jenis_cuti_id
            );
        }

        if (
            $request->filled('tanggal_dari') &&
            $request->filled('tanggal_sampai')
        ) {
            $query->where(function ($q) use ($request) {
                $q->whereDate(
                    'tanggal_mulai',
                    '<=',
                    $request->tanggal_sampai
                )
                ->whereDate(
                    'tanggal_selesai',
                    '>=',
                    $request->tanggal_dari
                );
            });
        }
        elseif ($request->filled('tanggal_dari')) {
            $query->whereDate(
                'tanggal_selesai',
                '>=',
                $request->tanggal_dari
            );
        }
        elseif ($request->filled('tanggal_sampai')) {
            $query->whereDate(
                'tanggal_mulai',
                '<=',
                $request->tanggal_sampai
            );
        }

        $pengajuanCuti = $query
            ->latest()
            ->get();

        return view(
            'karyawan.cuti.index',
            compact(
                'pengajuanCuti',
                'jenisCutis'
            )
        );
    }

    public function status()
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            return back()
                ->withErrors([
                    'msg' =>
                        'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }

        $pengajuanCuti = PengajuanCuti::with('jenisCuti')
            ->where(
                'karyawan_id',
                $karyawan->id
            )
            ->whereIn(
                'status',
                [
                    'Menunggu',
                    'Disetujui',
                    'Ditolak'
                ]
            )
            ->latest()
            ->get();

        return view(
            'karyawan.cuti.status',
            compact('pengajuanCuti')
        );
    }
}