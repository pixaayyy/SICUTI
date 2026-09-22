@extends('layouts.hr')
@section('title', 'Riwayat Persetujuan - HR')

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

    .filter-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 350px;
    }
    .search-input {
        width: 100%;
        padding: 10px 12px 10px 38px;
        font-size: 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        background-color: #f9fafb;
    }
    .search-input:focus { border-color: #2563eb; background-color: #ffffff; }
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .table-card {
        background-color: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .hr-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .hr-table th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        letter-spacing: 0.5px;
    }
    .hr-table td {
        padding: 16px;
        font-size: 13px;
        color: #111827;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .badge-id {
        font-weight: 600;
        color: #111827;
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
        font-size: 13px;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .bg-green { background-color: #f0fdf4; color: #16a34a; }
    .bg-red { background-color: #fef2f2; color: #ef4444; }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #6b7280;
        font-size: 13px;
    }
</style>

<!-- Header Halaman -->
<div class="page-header">
    <h2>Riwayat Keputusan</h2>
</div>

<!-- Filter & Search Bar -->
<div class="filter-card">
    <form method="GET" action="{{ route('hr.riwayat') }}" class="search-box">
        <span class="search-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, Name..." class="search-input">
    </form>
</div>

<!-- Tabel Riwayat -->
<div class="table-card">
    <div style="overflow-x: auto;">
        <table class="hr-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Employee Name</th>
                    <th>Dept</th>
                    <th>Date Processed</th>
                    <th>Decision</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $item)
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
                        <span class="badge-id">REQ-{{ date('Y', strtotime($item->created_at)) }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td>
                        <div class="karyawan-profil">
                            <div class="inisial-avatar">{{ $inisial }}</div>
                            <div>
                                <div style="font-weight: 600;">{{ $nama }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->karyawan->departemen ?? '-' }}</td>
                    <td>
                        <div>{{ $item->updated_at ? $item->updated_at->format('M d, Y') : '-' }}</div>
                        <div style="font-size: 11px; color: #6b7280;">{{ $item->updated_at ? $item->updated_at->format('H:i') : '' }}</div>
                    </td>
                    <td>
                        @if($item->status == 'disetujui')
                            <span class="badge-status bg-green">Approved</span>
                        @else
                            <span class="badge-status bg-red">Rejected</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #6b7280; padding: 32px;">Belum ada riwayat keputusan cuti.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        <div>Menampilkan data riwayat keputusan</div>
        <div>{{ $riwayats->links() }}</div>
    </div>
</div>
@endsection