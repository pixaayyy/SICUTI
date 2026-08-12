<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function approve(
        Request $request,
        PengajuanCuti $pengajuanCuti
    ) {
        $request->validate([
            'catatan' => 'nullable|string',
        ]);

        DB::transaction(function () use (
            $request,
            $pengajuanCuti
        ) {

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
        });

        return back()->with(
            'success',
            'Pengajuan cuti berhasil disetujui.'
        );
    }

    public function reject(
        Request $request,
        PengajuanCuti $pengajuanCuti
    ) {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        DB::transaction(function () use (
            $request,
            $pengajuanCuti
        ) {

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
        });

        return back()->with(
            'success',
            'Pengajuan cuti ditolak.'
        );
    }
}