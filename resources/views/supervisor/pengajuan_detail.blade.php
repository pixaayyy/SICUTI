@extends('layouts.supervisor')
@section('title', 'Detail Pengajuan Cuti')

@section('content')
    <style>
    .detail-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .detail-card {
        padding: 32px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 16px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    .grid-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item label {
        display: block;
        margin-bottom: 4px;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item p {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        color: #111827;
    }

    .alasan-box {
        padding: 16px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
        margin-bottom: 20px;
    }

    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .bg-menunggu {
        background-color: #fef3c7;
        color: #d97706;
    }

    .bg-disetujui {
        background-color: #eff6ff;
        color: #2563eb;
    }

    .bg-ditolak {
        background-color: #fef2f2;
        color: #ef4444;
    }

    .btn-back {
        padding: 8px 16px;
        border-radius: 8px;
        background-color: #f3f4f6;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .btn-back:hover {
        background-color: #e5e7eb;
    }
    </style>

    <div class="detail-container">
        <div class="detail-card">
            <div class="detail-header">
                <h2>Rincian Pengajuan Cuti</h2>
                <a href="{{ route('supervisor.dashboard') }}" class="btn-back">Kembali</a>
            </div>

            <div class="grid-info">
                <div class="info-item">
                    <label>Nama Karyawan</label>
                    <p>{{ $pengajuan->karyawan->user->name ?? '-' }}</p>
                </div>
                <div class="info-item">
                    <label>Jabatan / Departemen</label>
                    <p>{{ $pengajuan->karyawan->jabatan ?? '-' }} ({{ $pengajuan->karyawan->departemen ?? '-' }})</p>
                </div>
                <div class="info-item">
                    <label>Jenis Cuti</label>
                    <p>{{ $pengajuan->jenisCuti->nama ?? '-' }}</p>
                </div>
                <div class="info-item">
                    <label>Durasi Cuti</label>
                    <p>{{ $pengajuan->durasi }} Hari</p>
                </div>
                <div class="info-item">
                    <label>Tanggal Mulai</label>
                    <p>{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }}</p>
                </div>
                <div class="info-item">
                    <label>Tanggal Selesai</label>
                    <p>{{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}</p>
                </div>
                <div class="info-item">
                    <label>Status Pengajuan</label>
                    <p>
                        <span class="badge-status @if($pengajuan->status == 'disetujui') bg-disetujui @elseif($pengajuan->status == 'ditolak') bg-ditolak @else bg-menunggu @endif">
                            {{ ucfirst($pengajuan->status) }}
                        </span>
                    </p>
                </div>
                <div class="info-item">
                    <label>Tanggal Pengajuan</label>
                    <p>{{ $pengajuan->created_at ? $pengajuan->created_at->format('d M Y, H:i') : '-' }}</p>
                </div>
            </div>

            <div class="alasan-box">
                <label style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 4px;">Alasan Cuti</label>
                <p style="margin: 0; color: #374151; font-size: 14px;">{{ $pengajuan->alasan ?? 'Tidak ada alasan yang disertakan.' }}</p>
            </div>

            @if($pengajuan->data_pendukung)
            <div class="info-item" style="margin-top: 20px;">
                <label>Dokumen Pendukung / Lampiran</label>
                <div style="margin-top: 8px;">
                    <a href="{{ asset('storage/' . $pengajuan->data_pendukung) }}" target="_blank" style="color: #2563eb; font-weight: 600; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Lampiran Dokumen
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection