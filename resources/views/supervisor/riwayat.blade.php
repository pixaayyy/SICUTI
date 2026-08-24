@extends('layouts.supervisor')
@section('title', 'Riwayat Keputusan - Supervisor')

@section('content')
<style>
    /* Styling konsisten dengan Dashboard Supervisor */
    .page-header { margin-bottom: 24px; }
    .page-header h2 { margin: 0 0 4px 0; font-size: 24px; color: #111827; font-weight: 700; }
    .page-header p { margin: 0; font-size: 14px; color: #6b7280; }

    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 24px; }
    .stat-card { background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: space-between; }
    
    .table-card { background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; }
    
    .card-header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px; }
    .card-header-flex h3 { margin: 0; font-size: 16px; color: #111827; font-weight: 700; }
    
    .search-input { padding: 8px 12px 8px 36px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; width: 260px; }
    .search-input:focus { border-color: #2563eb; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1); }

    .custom-table { width: 100%; border-collapse: collapse; text-align: left; }
    .custom-table th { padding: 12px 16px; font-size: 11px; color: #6b7280; border-bottom: 1px solid #e5e7eb; text-transform: uppercase; font-weight: 600; }
    .custom-table td { padding: 16px; font-size: 13px; border-bottom: 1px solid #f3f4f6; color: #111827; vertical-align: middle; }
    
    .badge-status { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
    .bg-blue { background: #eff6ff; color: #2563eb; }
    .bg-red { background: #fef2f2; color: #ef4444; }
    
    .btn-detail { background: #eff6ff; color: #2563eb; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; }
    .btn-detail:hover { background: #dbeafe; }
</style>

<!-- Header Halaman -->
<div class="page-header">
    <h2>Riwayat Keputusan</h2>
    <p>Tinjau seluruh permohonan cuti yang telah Anda proses.</p>
</div>

<!-- Statistik Kartu -->
<div class="stats-grid">
    <div class="stat-card">
        <span style="font-size: 12px; color: #6b7280; font-weight: 600;">TOTAL DIPROSES</span>
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
            <span style="font-size: 32px; font-weight: bold; color: #111827;">{{ $totalDiproses }}</span>
            <span style="font-size: 12px; color: #6b7280;">Pengajuan</span>
        </div>
    </div>
    <div class="stat-card">
        <span style="font-size: 12px; color: #6b7280; font-weight: 600;">DISETUJUI</span>
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
            <span style="font-size: 32px; font-weight: bold; color: #111827;">{{ $totalDisetujui }}</span>
            <span style="font-size: 12px; background: #eff6ff; color: #2563eb; padding: 4px 8px; border-radius: 6px; font-weight: 600;">Disetujui</span>
        </div>
    </div>
    <div class="stat-card">
        <span style="font-size: 12px; color: #6b7280; font-weight: 600;">DITOLAK</span>
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
            <span style="font-size: 32px; font-weight: bold; color: #111827;">{{ $totalDitolak }}</span>
            <span style="font-size: 12px; background: #fef2f2; color: #ef4444; padding: 4px 8px; border-radius: 6px; font-weight: 600;">Ditolak</span>
        </div>
    </div>
</div>

<!-- Tabel Daftar Keputusan -->
<div class="table-card">
    <div class="card-header-flex">
        <h3>Daftar Keputusan</h3>
        
        <form method="GET" action="{{ route('supervisor.riwayat') }}">
            <div style="position: relative;">
                <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau ID..." class="search-input">
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID Pengajuan</th>
                    <th>Nama Karyawan</th>
                    <th>Jenis Cuti</th>
                    <th>Keputusan</th>
                    <th>Tanggal Keputusan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $item)
                    <tr>
                        <td style="font-weight: 600;">REQ-{{ str_pad($item->pengajuan_cuti_id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->pengajuanCuti->karyawan->user->name ?? 'U') }}&background=random" style="width: 32px; height: 32px; border-radius: 50%;">
                                <div>
                                    <div style="font-weight: 600; color: #111827;">{{ $item->pengajuanCuti->karyawan->user->name ?? '-' }}</div>
                                    <div style="font-size: 11px; color: #6b7280;">{{ $item->pengajuanCuti->karyawan->jabatan ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->pengajuanCuti->jenisCuti->nama ?? '-' }}</td>
                        <td>
                            @if($item->status == 'disetujui')
                                <span class="badge-status bg-blue">
                                    <span style="width: 6px; height: 6px; background: #2563eb; border-radius: 50%;"></span> Disetujui
                                </span>
                            @else
                                <span class="badge-status bg-red">
                                    <span style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%;"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td style="color: #4b5563;">{{ $item->updated_at ? $item->updated_at->format('d M Y, H:i') : '-' }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('supervisor.pengajuan.show', $item->pengajuan_cuti_id) }}" class="btn-detail" title="Detail Pengajuan">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #6b7280; padding: 32px;">Belum ada riwayat keputusan cuti.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px;">
        {{ $riwayats->links() }}
    </div>
</div>
@endsection