@extends('layouts.karyawan')

@section('title', 'Dashboard Cuti - SICUTI')

@section('content')

    <style>
        .dashboard-container {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
        }
        .greeting-section h2 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .greeting-section p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        @media (min-width: 640px) {
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 140px;
            position: relative;
            overflow: hidden;
        }
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-icon.blue { background: #eff6ff; color: #0D3B82; }
        .stat-icon.red { background: #fef2f2; color: #ef4444; }
        .stat-icon.gray { background: #f3f4f6; color: #4b5563; }
        
        .badge-tersedia {
            background: #eff6ff;
            color: #2563eb;
            font-size: 11px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 9999px;
        }
        .stat-title {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 500;
            margin-bottom: 4px;
        }
        .stat-value-wrapper {
            display: flex;
            align-items: baseline;
            gap: 6px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }
        .stat-unit {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .card-table-container {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .table-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid #f3f4f6;
        }
        .table-header-flex h3 {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .table-header-flex a {
            color: #0D3B82;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }
        .table-header-flex a:hover {
            text-decoration: underline;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        .custom-table th {
            background: #ffffff;
            border-bottom: 1px solid #f3f4f6;
            padding: 16px 24px;
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .custom-table td {
            padding: 16px 24px;
            font-size: 14px;
            border-bottom: 1px solid #f9fafb;
        }
        .custom-table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-menunggu { background: #eff6ff; color: #2563eb; }
        .status-disetujui { background: #f0fdf4; color: #16a34a; }
        .status-ditolak { background: #fef2f2; color: #ef4444; }
        .status-dibatalkan { background: #f3f4f6; color: #4b5563; }

        .action-btn {
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .action-btn:hover {
            color: #1e3a8a;
        }

        /* =========================================================
        CSS UNTUK POPUP MODAL (TANPA JS) MENGGUNAKAN :TARGET 
        ========================================================= */
        .modal-window {
            position: fixed;
            background-color: rgba(0, 0, 0, 0.4);
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 999;
            /* Disembunyikan secara default */
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Modal akan muncul saat ID-nya ditargetkan oleh URL (href) */
        .modal-window:target {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Efek pop-art muncul dari bawah sedikit */
            transform: translateY(-20px);
            transition: all 0.3s;
        }

        .modal-window:target .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f8fafc;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
        }

        .modal-close {
            color: #9ca3af;
            text-decoration: none;
            font-size: 24px;
            line-height: 1;
            font-weight: bold;
        }

        .modal-close:hover {
            color: #ef4444;
        }

        .modal-body {
            padding: 24px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .detail-label {
            width: 130px;
            font-weight: 600;
            color: #6b7280;
        }

        .detail-value {
            flex: 1;
            color: #111827;
            font-weight: 500;
        }
    </style>

    <div class="dashboard-container">

        {{-- Greeting --}}
        <div class="greeting-section mb-8">
            <h2>Halo, {{ $user->name }}</h2>
            <p>
                {{ $karyawan->jabatan ?? '-' }} | {{ $karyawan->departemen ?? '-' }}
            </p>
        </div>

        {{-- Statistik --}}
        <div class="stats-grid">

            {{-- Sisa Cuti --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="badge-tersedia">Tersedia</span>
                </div>
                <div>
                    <p class="stat-title">Sisa Cuti Tahunan</p>
                    <div class="stat-value-wrapper">
                        <span class="stat-number">{{ $sisaCutiHari }}</span>
                        <span class="stat-unit">Hari</span>
                    </div>
                </div>
            </div>

            {{-- Cuti Terpakai --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="stat-title">Cuti Terpakai</p>
                    <div class="stat-value-wrapper">
                        <span class="stat-number">{{ $cutiTerpakai }}</span>
                        <span class="stat-unit">Hari</span>
                    </div>
                </div>
            </div>

            {{-- Cuti Ditolak --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon red">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="stat-title">Cuti Ditolak</p>
                    <div class="stat-value-wrapper">
                        <span class="stat-number">{{ $cutiDitolak }}</span>
                        <span class="stat-unit">Pengajuan</span>
                    </div>
                </div>
            </div>

            {{-- Cuti Tahun Ini --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon gray">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="stat-title">Cuti Tahun Ini</p>
                    <span class="stat-number">{{ $tahun }}</span>
                </div>
            </div>

        </div>

        {{-- Pengajuan Terbaru --}}
        <div class="card-table-container">
            
            <div class="table-header-flex">
                <h3>Pengajuan Terbaru</h3>
                <a href="{{ route('karyawan.cuti.index') }}">Lihat Semua →</a>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Jenis Cuti</th>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th style="text-align: right; padding-right: 32px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanTerbaru as $pengajuan)
                            <tr>
                                <td style="font-weight: 500; color: #111827;">
                                    {{ $pengajuan->jenisCuti->nama ?? '-' }}
                                </td>
                                <td style="color: #6b7280; font-size: 13px;">
                                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }} 
                                    @if($pengajuan->tanggal_selesai && $pengajuan->tanggal_mulai != $pengajuan->tanggal_selesai)
                                        - {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </td>
                                <td style="color: #4b5563; font-size: 13px; font-weight: 500;">
                                    {{ $pengajuan->durasi }} Hari
                                </td>
                                <td>
                                    @if($pengajuan->status === 'menunggu')
                                        <span class="status-badge status-menunggu">Menunggu Persetujuan</span>
                                    @elseif($pengajuan->status === 'disetujui')
                                        <span class="status-badge status-disetujui">Disetujui</span>
                                    @elseif($pengajuan->status === 'ditolak')
                                        <span class="status-badge status-ditolak">Ditolak</span>
                                    @elseif($pengajuan->status === 'dibatalkan')
                                        <span class="status-badge status-dibatalkan">Dibatalkan</span>
                                    @endif
                                </td>
                                <td style="text-align: right; padding-right: 32px;">
                                    <!-- BAGIAN INI DIUBAH: href diarahkan ke ID modal yang sesuai -->
                                    <a href="#modal-detail-{{ $pengajuan->id }}" class="action-btn">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #6b7280; padding: 24px;">
                                    Belum ada pengajuan cuti.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @foreach($pengajuanTerbaru as $pengajuan)
    <div id="modal-detail-{{ $pengajuan->id }}" class="modal-window">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Pengajuan Cuti</h3>
                <!-- Link '#' akan menghapus ID target dari URL, sehingga modal tertutup -->
                <a href="#" class="modal-close" title="Tutup">&times;</a>
            </div>
            
            <div class="modal-body">
                <div class="detail-row">
                    <div class="detail-label">Jenis Cuti</div>
                    <div class="detail-value">: {{ $pengajuan->jenisCuti->nama ?? '-' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal</div>
                    <div class="detail-value">: 
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }} 
                        @if($pengajuan->tanggal_selesai && $pengajuan->tanggal_mulai != $pengajuan->tanggal_selesai)
                            s/d {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}
                        @endif
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Durasi</div>
                    <div class="detail-value">: {{ $pengajuan->durasi }} Hari</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">: 
                        @if($pengajuan->status === 'menunggu')
                            <span style="color: #2563eb; font-weight: 700;">Menunggu Persetujuan</span>
                        @elseif($pengajuan->status === 'disetujui')
                            <span style="color: #16a34a; font-weight: 700;">Disetujui</span>
                        @elseif($pengajuan->status === 'ditolak')
                            <span style="color: #ef4444; font-weight: 700;">Ditolak</span>
                        @elseif($pengajuan->status === 'dibatalkan')
                            <span style="color: #4b5563; font-weight: 700;">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Keterangan</div>
                    <div class="detail-value">: {{ $pengajuan->keterangan ?? '-' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Lampiran Surat</div>
                    <div class="detail-value" style="flex: 1;">: 
                        @if($pengajuan->data_pendukung)
                            <br>
                            <a href="{{ asset('storage/' . $pengajuan->data_pendukung) }}" target="_blank" style="display: inline-block; margin-top: 8px;">
                                <img src="{{ asset('storage/' . $pengajuan->data_pendukung) }}" alt="Bukti Data Pendukung" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #e5e7eb; object-fit: contain;">
                            </a>
                        @else
                            <span style="color: #9ca3af; font-style: italic;">Tidak ada lampiran</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

@endsection