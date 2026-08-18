@extends('layouts.karyawan')

@section('title', 'Riwayat Cuti')

@section('content')

<style>
    .history-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px;
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid #0b3c7c;
    }

    .history-header h2 {
        margin: 0;
        color: #222;
        font-size: 30px;
        font-weight: 700;
    }

    .history-header p {
        margin-top: 8px;
        color: #777;
        font-size: 14px;
    }

    .btn-add {
        display: inline-block;
        padding: 11px 18px;
        color: white;
        background-color: #0b3c7c;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-add:hover {
        background-color: #082a5c;
    }

    .alert-success {
        padding: 15px 18px;
        margin-bottom: 20px;
        color: #166534;
        background-color: #dcfce7;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        font-size: 14px;
    }

    .filter-card {
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .filter-header {
        margin-bottom: 18px;
    }

    .filter-header h3 {
        margin: 0;
        color: #222;
        font-size: 18px;
        font-weight: 700;
    }

    .filter-header p {
        margin: 6px 0 0;
        color: #777;
        font-size: 13px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        margin-bottom: 7px;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
    }

    .filter-group select,
    .filter-group input {
        width: 100%;
        height: 42px;
        padding: 0 12px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background-color: white;
        color: #374151;
        font-size: 13px;
        outline: none;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        border-color: #0b3c7c;
        box-shadow: 0 0 0 2px rgba(11, 60, 124, 0.1);
    }

    .filter-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        height: 42px;
        padding: 0 18px;
        border: none;
        border-radius: 7px;
        background-color: #0b3c7c;
        color: white;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-filter:hover {
        background-color: #082a5c;
    }

    .btn-reset {
        height: 42px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background-color: #f3f4f6;
        color: #374151;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-reset:hover {
        background-color: #e5e7eb;
    }

    .filter-result {
        margin-bottom: 15px;
        color: #666;
        font-size: 13px;
    }

    .filter-result strong {
        color: #0b3c7c;
    }

    .table-card {
        overflow: hidden;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .cuti-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .cuti-table thead {
        background-color: #f8fafc;
    }

    .cuti-table th {
        padding: 16px;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .cuti-table td {
        padding: 16px;
        color: #374151;
        border-bottom: 1px solid #eeeeee;
        font-size: 14px;
        vertical-align: middle;
    }

    .cuti-table tbody tr {
        transition: 0.2s;
    }

    .cuti-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .cuti-table tbody tr:last-child td {
        border-bottom: none;
    }

    .jenis-cuti {
        color: #222;
        font-weight: 600;
    }

    .date-text {
        white-space: nowrap;
    }

    .date-separator {
        margin: 0 5px;
        color: #9ca3af;
    }

    .reason {
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-menunggu {
        color: #92400e;
        background-color: #fef3c7;
    }

    .status-disetujui {
        color: #166534;
        background-color: #dcfce7;
    }

    .status-ditolak {
        color: #991b1b;
        background-color: #fee2e2;
    }

    .status-lain {
        color: #374151;
        background-color: #f3f4f6;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 55px;
        height: 55px;
        margin: 0 auto 15px;
        color: #9ca3af;
    }

    .empty-title {
        margin: 0;
        color: #555;
        font-size: 16px;
        font-weight: 700;
    }

    .empty-description {
        margin-top: 6px;
        color: #999;
        font-size: 13px;
    }

    @media (max-width: 950px) {
        .filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .filter-buttons {
            grid-column: span 2;
        }
    }

    @media (max-width: 768px) {
        .history-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
        }

        .history-header h2 {
            font-size: 25px;
        }

        .btn-add {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-buttons {
            grid-column: auto;
            width: 100%;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }
    }
</style>

<div class="history-container">
    <div class="history-header">
        <div>
            <h2>Riwayat Cuti</h2>
            <p>Lihat seluruh riwayat pengajuan cuti Anda.</p>
        </div>
        <a href="{{ route('karyawan.cuti.create') }}" class="btn-add">
            + Ajukan Cuti
        </a>
    </div>

    @if(session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="filter-card">
        <div class="filter-header">
            <h3>Filter Riwayat Cuti</h3>
            <p>Cari riwayat cuti berdasarkan jenis cuti dan tanggal.</p>
        </div>

        <form action="{{ route('karyawan.cuti.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="jenis_cuti_id">Jenis Cuti</label>
                <select name="jenis_cuti_id" id="jenis_cuti_id">
                    <option value="">Semua Jenis Cuti</option>
                    @foreach($jenisCutis as $jenis)
                        <option value="{{ $jenis->id }}" {{ request('jenis_cuti_id') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="tanggal_dari">Dari Tanggal</label>
                <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}">
            </div>

            <div class="filter-group">
                <label for="tanggal_sampai">Sampai Tanggal</label>
                <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
            </div>

            <div class="filter-buttons">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('karyawan.cuti.index') }}" class="btn-reset">Reset</a>
            </div>
        </form>
    </div>

    @if(request('jenis_cuti_id') || request('tanggal_dari') || request('tanggal_sampai'))
        <div class="filter-result">
            Menampilkan <strong>{{ $pengajuanCuti->count() }}</strong> data pengajuan cuti berdasarkan filter.
        </div>
    @endif

    <div class="table-card">
        <div class="table-wrapper">
            <table class="cuti-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanCuti as $index => $cuti)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="jenis-cuti">{{ $cuti->jenisCuti->nama ?? '-' }}</td>
                            <td class="date-text">
                                {{ $cuti->tanggal_mulai?->format('d/m/Y') }}
                                <span class="date-separator">s/d</span>
                                {{ $cuti->tanggal_selesai?->format('d/m/Y') }}
                            </td>
                            <td>{{ $cuti->durasi }} Hari</td>
                            <td>
                                <div class="reason" title="{{ $cuti->alasan }}">
                                    {{ $cuti->alasan }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = strtolower(trim($cuti->status));
                                @endphp

                                @if($status === 'menunggu')
                                    <span class="status status-menunggu">Menunggu</span>
                                @elseif($status === 'disetujui')
                                    <span class="status status-disetujui">Disetujui</span>
                                @elseif($status === 'ditolak')
                                    <span class="status status-ditolak">Ditolak</span>
                                @else
                                    <span class="status status-lain">{{ $cuti->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 01.707.293l5.414 5.414a2 2 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>

                                    @if(request('jenis_cuti_id') || request('tanggal_dari') || request('tanggal_sampai'))
                                        <p class="empty-title">Data tidak ditemukan</p>
                                        <p class="empty-description">Tidak ada riwayat cuti yang sesuai dengan filter yang dipilih.</p>
                                    @else
                                        <p class="empty-title">Belum ada pengajuan cuti</p>
                                        <p class="empty-description">Silakan ajukan cuti jika Anda membutuhkan.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection