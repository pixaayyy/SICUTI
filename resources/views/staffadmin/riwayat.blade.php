@extends('layouts.staffadmin') <!-- Sesuaikan dengan nama layout staff admin -->
@section('title', 'Riwayat Pengajuan Selesai - Staff Administrasi')

@section('content')
<style>
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h2 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .page-header p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    .table-card {
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .card-header-flex {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
    }

    .search-input {
        width: 260px;
        padding: 10px 12px 10px 36px;
        font-size: 13px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        outline: none;
        background-color: #f9fafb;
    }

    .search-input:focus {
        border-color: #2563eb;
        background-color: #ffffff;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
    }

    .custom-table td {
        padding: 16px;
        font-size: 13px;
        color: #111827;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .badge-id {
        background-color: #eff6ff;
        color: #2563eb;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid transparent;
    }

    .bg-green {
        background-color: #ecfdf5;
        color: #10b981;
        border-color: #a7f3d0;
    }

    .bg-red {
        background-color: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }
</style>

<!-- Header Halaman -->
<div class="page-header">
    <h2>Riwayat Pengajuan Selesai</h2>
    <p>Daftar seluruh pengajuan cuti yang telah disetujui atau ditolak.</p>
</div>

<!-- Tabel Daftar Keputusan -->
<div class="table-card">
    <div class="card-header-flex">
        <!-- Form Pencarian (Tombol Filter sudah dihapus) -->
        <form method="GET" action="{{ route('staffadmin.riwayat') }}" style="display: flex; gap: 12px;">
            <div style="position: relative;">
                <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID atau Nama..." class="search-input">
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID Pengajuan</th>
                    <th>Nama</th>
                    <th>Tanggal Selesai</th>
                    <th>Hasil Keputusan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $item)
                    <tr>
                        <td>
                            <span class="badge-id">#REQ-{{ date('Y', strtotime($item->created_at)) }}-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->karyawan->user->name ?? 'U') }}&background=random" style="width: 36px; height: 36px; border-radius: 50%;">
                                <div>
                                    <div style="font-weight: 600; color: #111827;">{{ $item->karyawan->user->name ?? '-' }}</div>
                                    <div style="font-size: 12px; color: #6b7280;">{{ $item->karyawan->departemen ?? 'Department' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: #111827;">{{ $item->updated_at ? $item->updated_at->format('d M Y') : '-' }}</div>
                            <div style="font-size: 12px; color: #6b7280;">{{ $item->updated_at ? $item->updated_at->format('H:i') . ' WIB' : '-' }}</div>
                        </td>
                        <td>
                            @if($item->status == 'disetujui')
                                <span class="badge-status bg-green">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Disetujui
                                </span>
                            @else
                                <span class="badge-status bg-red">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 32px;">Belum ada riwayat pengajuan selesai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; color: #6b7280; font-size: 13px;">
        <div>Menampilkan data riwayat</div>
        <div>{{ $riwayats->links() }}</div>
    </div>
</div>
@endsection