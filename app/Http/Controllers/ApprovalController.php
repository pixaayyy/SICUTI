<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PengajuanCuti; // Gunakan model yang benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\StatusCutiNotification; // Tambahkan ini wajib!

class ApprovalController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanCuti::with([
            'karyawan.user',
            'jenisCuti'
        ])
        ->where('status', 'menunggu')
        ->latest()
        ->get();

        return view('approvals.index', compact('pengajuan'));
    }

    public function approve(Request $request, PengajuanCuti $pengajuanCuti)
    {
        $request->validate([
            'catatan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $pengajuanCuti) {
            $pengajuanCuti->update([
                'status' => 'disetujui',
                'catatan' => $request->catatan,
            ]);

            Approval::create([
                'pengajuan_cuti_id' => $pengajuanCuti->id,
                'approver_id' => Auth::id(),
                'status' => 'disetujui',
                'catatan' => $request->catatan,
                'approved_at' => now(),
            ]);

            // KIRIM NOTIFIKASI KE KARYAWAN (Jika menggunakan Opsi 2 Notifikasi Laravel)
            $userKaryawan = $pengajuanCuti->karyawan->user ?? null;
            if ($userKaryawan) {
                $userKaryawan->notify(new StatusCutiNotification([
                    'judul' => 'Cuti Disetujui!',
                    'pesan' => 'Pengajuan cuti Anda telah disetujui.'
                ]));
            }
        });

        return back()->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    public function reject(Request $request, PengajuanCuti $pengajuanCuti)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $pengajuanCuti) {
            $pengajuanCuti->update([
                'status' => 'ditolak',
                'catatan' => $request->catatan,
            ]);

            Approval::create([
                'pengajuan_cuti_id' => $pengajuanCuti->id,
                'approver_id' => Auth::id(),
                'status' => 'ditolak',
                'catatan' => $request->catatan,
                'approved_at' => now(),
            ]);

            // KIRIM NOTIFIKASI KE KARYAWAN (Jika menggunakan Opsi 2 Notifikasi Laravel)
            $userKaryawan = $pengajuanCuti->karyawan->user ?? null;
            if ($userKaryawan) {
                $userKaryawan->notify(new StatusCutiNotification([
                    'judul' => 'Cuti Ditolak',
                    'pesan' => 'Pengajuan cuti Anda ditolak. Alasan: ' . $request->catatan
                ]));
            }
        });

        return back()->with('success', 'Pengajuan cuti ditolak.');
    }

    public function store(Request $request)
    {
        // 1. Validasi dan simpan data cuti (UBAH Cuti() menjadi PengajuanCuti())
        $cuti = new PengajuanCuti();
        $cuti->karyawan_id = Auth::user()->karyawan->id;
        $cuti->tanggal_mulai = $request->tanggal_mulai;
        $cuti->status = 'menunggu'; // Sesuaikan dengan status default di database Anda, sepertinya 'menunggu'
        // ... (simpan field lainnya sesuai database Anda)
        $cuti->save();

        // 2. KIRIM NOTIFIKASI KE DIRI SENDIRI (Sebagai pengingat histori)
        $dataNotif = [
            'judul' => 'Cuti Berhasil Diajukan',
            'pesan' => 'Pengajuan cuti Anda sedang menunggu persetujuan HRD/Atasan.'
        ];

        Auth::user()->notify(new StatusCutiNotification($dataNotif));

        return redirect()->route('karyawan.cuti.index')->with('success', 'Cuti berhasil diajukan');
    }
}