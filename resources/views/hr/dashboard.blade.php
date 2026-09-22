@extends('layouts.hr')
@section('title', 'Dashboard HR')

@section('content')
<style>
    /* Styling khusus konten dashboard */
    .dashboard-header {
        margin-bottom: 24px;
    }

    .dashboard-header h2 {
        margin: 0 0 8px 0;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .dashboard-header p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    .metric-card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
        position: relative;
        overflow: hidden;
    }

    /* Efek bayangan di pojok kanan atas card */
    .metric-card::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        opacity: 0.1;
    }

    .card-menunggu::after { background-color: #2563eb; }
    .card-disetujui::after { background-color: #10b981; }
    .card-ditolak::after { background-color: #ef4444; }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .icon-menunggu { background-color: #eff6ff; color: #2563eb; }
    .icon-disetujui { background-color: #f0fdf4; color: #10b981; }
    .icon-ditolak { background-color: #fef2f2; color: #ef4444; }

    .metric-title {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .metric-value {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    /* Table Section */
    .table-section {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
        padding: 24px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
    }

    .btn-lihat-semua {
        color: #0b3b84;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .btn-lihat-semua:hover {
        text-decoration: underline;
    }

    .hr-table {
        width: 100%;
        border-collapse: collapse;
    }

    .hr-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
    }

    .hr-table td {
        padding: 16px;
        font-size: 14px;
        color: #111827;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    /* Karyawan Profil di Tabel */
    .karyawan-profil {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .inisial-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }

    .karyawan-nama {
        font-weight: 500;
    }

    /* Badges Status - Sesuai Mockup */
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-menunggu { background-color: #fff7ed; color: #ea580c; }
    .badge-disetujui { background-color: #f0fdf4; color: #16a34a; }
    .badge-ditolak { background-color: #fef2f2; color: #ef4444; } /* Warna merah untuk ditolak */

    /* Tombol Aksi */
    .btn-detail {
        background-color: #eff6ff;
        color: #2563eb;
        border: none;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-detail:hover {
        background-color: #dbeafe;
    }
</style>

<div class="dashboard-header">
    <h2>Ringkasan Dashboard</h2>
    <p>Pantau pengajuan cuti dan distribusi departemen.</p>
</div>

<!-- Metrics Card -->
<div class="metrics-grid">
    <div class="metric-card card-menunggu">
        <div class="metric-icon icon-menunggu">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        </div>
        <div class="metric-title">Menunggu Persetujuan</div>
        <h3 class="metric-value">{{ $metrics['menunggu'] }}</h3>
    </div>

    <div class="metric-card card-disetujui">
        <div class="metric-icon icon-disetujui">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="metric-title">Total Disetujui (Bulan Ini)</div>
        <h3 class="metric-value">{{ $metrics['disetujui'] }}</h3>
    </div>

    <div class="metric-card card-ditolak">
        <div class="metric-icon icon-ditolak">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="metric-title">Ditolak</div>
        <h3 class="metric-value">{{ $metrics['ditolak'] }}</h3>
    </div>
</div>

<!-- Table Section -->
<div class="table-section">
    <div class="table-header">
        <h3>Pengajuan Cuti Office Terbaru</h3>
        <a href="{{ route('hr.persetujuan') }}" class="btn-lihat-semua">Lihat Semua <span>&rarr;</span></a>
    </div>

    <table class="hr-table">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Jenis Cuti</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($terbaru as $item)
            @php
                // Membuat inisial nama secara otomatis (Misal: "Budi Santoso" jadi "BS")
                $nama = $item->karyawan->user->name ?? 'Unknown';
                $words = explode(' ', $nama);
                $inisial = '';
                foreach (array_slice($words, 0, 2) as $w) {
                    $inisial .= strtoupper(substr($w, 0, 1));
                }
            @endphp
            <tr>
                <td>
                    <div class="karyawan-profil">
                        <div class="inisial-avatar">{{ $inisial }}</div>
                        <div class="karyawan-nama">{{ $nama }}</div>
                    </div>
                </td>
                
                <td>{{ $item->karyawan->departemen ?? '-' }}</td>
                <td>{{ $item->jenisCuti->nama ?? '-' }}</td>
                
                <td>
                    {{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d M') : '-' }} - 
                    {{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d M') : '-' }} 
                    ({{ $item->durasi }} Hari)
                </td>
                
                <td>
                    <!-- Tampilan Badge Berdasarkan Status -->
                    @if(in_array($item->status, ['menunggu', 'menunggu_supervisor']))
                        <span class="badge badge-menunggu">Menunggu</span>
                    @elseif($item->status == 'disetujui')
                        <span class="badge badge-disetujui">Disetujui</span>
                    @elseif($item->status == 'ditolak')
                        <span class="badge badge-ditolak">Ditolak</span>
                    @else
                        <span class="badge" style="background-color: #f3f4f6; color: #374151;">{{ ucfirst($item->status) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #6b7280; padding: 24px;">Belum ada data pengajuan cuti terbaru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection