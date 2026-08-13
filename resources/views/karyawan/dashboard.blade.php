@extends('layouts.karyawan')

@section('title', 'Dashboard Cuti - SICUTI')

@section('content')

<style>
    .dashboard-greeting {
        margin-bottom: 24px;
    }

    .dashboard-greeting h2 {
        font-size: 30px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .dashboard-greeting p {
        font-size: 14px;
        color: #6b7280;
        margin-top: 4px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px;
        height: 140px;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .blue {
        background: #eff6ff;
        color: #0d3b82;
    }

    .red {
        background: #fef2f2;
        color: #dc2626;
    }

    .gray {
        background: #f3f4f6;
        color: #4b5563;
    }

    .stat-badge {
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 999px;
    }

    .stat-title {
        font-size: 14px;
        color: #6b7280;
        margin: 0 0 2px;
    }

    .stat-value {
        font-size: 30px;
        font-weight: 700;
        color: #111827;
    }

    .stat-unit {
        font-size: 14px;
        color: #6b7280;
    }

    .recent-card {
        margin-top: 24px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }

    .recent-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #f8fafc;
    }

    .recent-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .see-all {
        color: #0d3b82;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }

    .see-all:hover {
        text-decoration: underline;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .leave-table {
        width: 100%;
        border-collapse: collapse;
    }

    .leave-table th {
        padding: 12px 24px;
        background: #fafafa;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
    }

    .leave-table td {
        padding: 12px 24px;
        font-size: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .leave-table tbody tr:hover {
        background: #f9fafb;
    }

    .status {
        display: inline-flex;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-menunggu {
        background: #eff6ff;
        color: #2563eb;
    }

    .status-disetujui {
        background: #f0fdf4;
        color: #16a34a;
    }

    .status-ditolak {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-dibatalkan {
        background: #f3f4f6;
        color: #4b5563;
    }

    .action-link {
        color: #0d3b82;
    }

    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-greeting h2 {
            font-size: 24px;
        }
    }
</style>

{{-- Greeting --}}
<div class="dashboard-greeting">
    <h2>Halo, {{ $user->name }}</h2>

    <p>
        {{ $karyawan->jabatan ?? '-' }}
        |
        {{ $karyawan->departemen ?? '-' }}
    </p>
</div>

{{-- Statistik --}}
<div class="stats-grid">

    {{-- Sisa Cuti --}}
    <div class="stat-card">
        <div class="stat-top">

            <div class="stat-icon blue">
                <svg width="20" height="20" fill="none"
                     stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

            <span class="stat-badge">Tersedia</span>

        </div>

        <div>
            <p class="stat-title">Sisa Cuti Tahunan</p>

            <span class="stat-value">
                {{ $sisaCutiHari }}
            </span>

            <span class="stat-unit">Hari</span>
        </div>
    </div>

    {{-- Cuti Terpakai --}}
    <div class="stat-card">

        <div class="stat-icon blue">
            <svg width="20" height="20" fill="none"
                 stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>

        <div>
            <p class="stat-title">Cuti Terpakai</p>

            <span class="stat-value">
                {{ $cutiTerpakai }}
            </span>

            <span class="stat-unit">Hari</span>
        </div>

    </div>

    {{-- Cuti Ditolak --}}
    <div class="stat-card">

        <div class="stat-icon red">
            <svg width="20" height="20" fill="none"
                 stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <div>
            <p class="stat-title">Cuti Ditolak</p>

            <span class="stat-value">
                {{ $cutiDitolak }}
            </span>

            <span class="stat-unit">Pengajuan</span>
        </div>

    </div>

    {{-- Tahun --}}
    <div class="stat-card">

        <div class="stat-icon gray">
            <svg width="20" height="20" fill="none"
                 stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>

        <div>
            <p class="stat-title">Cuti Tahun Ini</p>

            <span class="stat-value">
                {{ $tahun }}
            </span>
        </div>

    </div>

</div>

{{-- Pengajuan Terbaru --}}
<div class="recent-card">

    <div class="recent-header">
        <h3>Pengajuan Terbaru</h3>

        <a href="#" class="see-all">
            Lihat Semua →
        </a>
    </div>

    <div class="table-wrapper">

        <table class="leave-table">

            <thead>
                <tr>
                    <th>Jenis Cuti</th>
                    <th>Tanggal</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pengajuanTerbaru as $pengajuan)

                    <tr>

                        <td>
                            {{ $pengajuan->jenisCuti->nama ?? '-' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}
                        </td>

                        <td>
                            {{ $pengajuan->durasi }} Hari
                        </td>

                        <td>

                            @if($pengajuan->status === 'menunggu')

                                <span class="status status-menunggu">
                                    Menunggu Persetujuan
                                </span>

                            @elseif($pengajuan->status === 'disetujui')

                                <span class="status status-disetujui">
                                    Disetujui
                                </span>

                            @elseif($pengajuan->status === 'ditolak')

                                <span class="status status-ditolak">
                                    Ditolak
                                </span>

                            @elseif($pengajuan->status === 'dibatalkan')

                                <span class="status status-dibatalkan">
                                    Dibatalkan
                                </span>

                            @endif

                        </td>

                        <td style="text-align:center">

                            <a href="#" class="action-link">
                                <svg width="20" height="20"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     viewBox="0 0 24 24"
                                     style="margin:auto">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7"/>
                                </svg>
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5"
                            style="text-align:center; padding:24px; color:#6b7280;">
                            Belum ada pengajuan cuti.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection