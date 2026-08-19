<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\User;
use App\Notifications\StatusCutiNotification;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    /**
     * Halaman Ajukan Cuti
     */
    public function create()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        // Cek apakah akun memiliki data karyawan
        if (!$karyawan) {
            return redirect()
                ->route('karyawan.dashboard')
                ->withErrors([
                    'msg' => 'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }

        // Ambil semua jenis cuti
        $jenisCutis = JenisCuti::orderBy('nama')->get();

        // Jatah cuti tahunan
        $jatahCuti = 12;

        // Tahun berjalan
        $tahun = Carbon::now()->year;

        // Hitung cuti yang sudah disetujui
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

        // Hitung sisa cuti
        $sisaCuti = max(
            0,
            $jatahCuti - $cutiTerpakai
        );

        return view(
            'karyawan.cuti.create',
            compact(
                'jenisCutis',
                'sisaCuti'
            )
        );
    }


    /**
     * Menyimpan pengajuan cuti
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        // Cek data karyawan
        if (!$karyawan) {
            return back()
                ->withInput()
                ->withErrors([
                    'msg' => 'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }

        // Validasi form
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


        // ==============================
        // HITUNG DURASI CUTI
        // ==============================

        $start = Carbon::parse(
            $validated['tanggal_mulai']
        );

        $end = Carbon::parse(
            $validated['tanggal_selesai']
        );

        $durasi = $start->diffInDays($end) + 1;


        // ==============================
        // CEK SISA CUTI
        // ==============================

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


        // ==============================
        // CEK APAKAH DURASI MELEBIHI SISA
        // ==============================

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


        // ==============================
        // UPLOAD DOKUMEN
        // ==============================

        $pathDokumen = null;

        if ($request->hasFile('data_pendukung')) {

            $pathDokumen = $request
                ->file('data_pendukung')
                ->store(
                    'dokumen_cuti',
                    'public'
                );
        }


        // ==============================
        // SIMPAN PENGAJUAN CUTI
        // ==============================

        /*
        |--------------------------------------------------------------------------
        | PENTING
        |--------------------------------------------------------------------------
        | Hasil PengajuanCuti::create() disimpan ke dalam variabel
        | $pengajuan agar bisa digunakan untuk notifikasi.
        */

        $pengajuan = PengajuanCuti::create([
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


        // ==============================
        // KIRIM NOTIFIKASI KE MANDOR
        // ==============================

        $mandors = User::where(
            'role',
            'mandor'
        )->get();


        $pesan =
            'Pengajuan cuti baru masuk dari ' .
            $user->name;


        foreach ($mandors as $mandor) {

            $mandor->notify(
                new StatusCutiNotification(
                    $pengajuan,
                    $pesan
                )
            );
        }


        // ==============================
        // REDIRECT
        // ==============================

        return redirect()
            ->route('karyawan.cuti.index')
            ->with(
                'status',
                'Hore! Pengajuan cuti Anda berhasil dikirim.'
            );
    }


    /**
     * Riwayat Cuti Karyawan
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $karyawan = $user->karyawan;

        // Cek data karyawan
        if (!$karyawan) {

            return redirect()
                ->route('karyawan.dashboard')
                ->withErrors([
                    'msg' =>
                        'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }


        // Ambil jenis cuti untuk filter
        $jenisCutis = JenisCuti::orderBy(
            'nama'
        )->get();


        // Query pengajuan cuti
        $query = PengajuanCuti::with(
                'jenisCuti'
            )
            ->where(
                'karyawan_id',
                $karyawan->id
            );


        // ==============================
        // FILTER JENIS CUTI
        // ==============================

        if ($request->filled('jenis_cuti_id')) {

            $query->where(
                'jenis_cuti_id',
                $request->jenis_cuti_id
            );
        }


        // ==============================
        // FILTER TANGGAL
        // ==============================

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

        } elseif ($request->filled('tanggal_dari')) {

            $query->whereDate(
                'tanggal_selesai',
                '>=',
                $request->tanggal_dari
            );

        } elseif ($request->filled('tanggal_sampai')) {

            $query->whereDate(
                'tanggal_mulai',
                '<=',
                $request->tanggal_sampai
            );
        }


        // Ambil data terbaru
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


    /**
     * Status Pengajuan Cuti
     */
    public function status()
    {
        $karyawan = Auth::user()->karyawan;


        // Cek data karyawan
        if (!$karyawan) {

            return back()
                ->withErrors([
                    'msg' =>
                        'Data karyawan tidak ditemukan untuk akun ini.'
                ]);
        }


        // Ambil pengajuan karyawan
        $pengajuanCuti = PengajuanCuti::with(
                'jenisCuti'
            )
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
            compact(
                'pengajuanCuti'
            )
        );
    }
}