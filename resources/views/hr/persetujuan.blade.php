@extends('layouts.hr')
@section('title', 'Daftar Persetujuan Cuti - HR')

@section('content')
<style>
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h2 {
        margin: 0 0 8px 0;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .page-header p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    .table-section {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
        padding: 24px;
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

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-menunggu { background-color: #fff7ed; color: #ea580c; }
    .badge-disetujui { background-color: #f0fdf4; color: #16a34a; }
    .badge-ditolak { background-color: #fef2f2; color: #ef4444; }

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
    
    .pagination-container {
        margin-top: 24px;
    }
</style>

<div class="page-header">
    <h2>Daftar Seluruh Pengajuan Cuti</h2>
    <p>Kelola dan pantau seluruh pengajuan cuti karyawan.</p>
</div>

<div class="table-section">
    <table class="hr-table">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Jenis Cuti</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $item)
            @php
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
                
                <td>
                    <a href="{{ route('hr.pengajuan.show', $item->id) }}" class="btn-detail">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #6b7280; padding: 24px;">Belum ada data pengajuan cuti.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $pengajuans->links() }}
    </div>
</div>
@endsection