@extends('layouts.mandor')

@section('title', 'Pengajuan Cuti - SICUTI')

@section('content')
<style>
    .main-wrapper {
        width: 100%;
    }
    
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        border: 1px solid #F3F4F6;
    }

    .page-header { 
        margin-bottom: 24px; 
    }
    .page-header h1 { 
        font-size: 24px; 
        font-weight: 700; 
        margin: 0 0 8px 0; 
        color: #111827; 
    }
    .page-header p { 
        margin: 0; 
        color: #6B7280; 
        font-size: 14px; 
    }

    .filter-section {
        display: flex;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
    }
    .form-group { 
        display: flex; 
        flex-direction: column; 
        gap: 8px; 
        flex: 1; 
        min-width: 200px; 
    }
    .form-group label { 
        font-size: 12px; 
        font-weight: 600; 
        color: #4B5563; 
    }
    .form-control { 
        padding: 10px 16px; 
        border: 1px solid #D1D5DB; 
        border-radius: 8px; 
        font-size: 14px; 
        outline: none; 
        background-color: #ffffff; 
    }
    .form-control:focus { 
        border-color: #0B2447; 
    }
    
    .btn-filter {
        background-color: #0B2447;
        color: white;
        padding: 10px 32px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        height: 42px;
    }
    .btn-filter:hover { 
        background-color: #1a3a6c; 
    }

    .btn-reset {
        background-color: #E5E7EB;
        color: #374151;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        height: 42px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }
    .btn-reset:hover {
        background-color: #D1D5DB;
    }

    .table-title { 
        font-size: 16px; 
        font-weight: 600; 
        margin-bottom: 20px; 
        color: #111827; 
    }
    .table-responsive { 
        overflow-x: auto; 
    }
    .custom-table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    .custom-table th {
        background-color: #ffffff;
        color: #6B7280;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #E5E7EB;
    }
    .custom-table td {
        padding: 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #F9FAFB;
        vertical-align: middle;
    }
    .custom-table tr:hover { 
        background-color: #F9FAFB; 
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        min-width: 70px;
    }
    .badge-menunggu { background-color: #F3F4F6; color: #4B5563; }
    .badge-disetujui { background-color: #EEF2FF; color: #4338CA; }
    .badge-ditolak { background-color: #FEF2F2; color: #DC2626; }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background-color: #0B2447;
        color: white;
        border-radius: 6px;
        text-decoration: none;
    }
    .btn-action:hover { 
        background-color: #1a3a6c; 
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="main-wrapper">
    <!-- Header Halaman -->
    <div class="page-header">
        <h1>Pengajuan Cuti</h1>
        <p>Daftar semua pengajuan cuti anggota tim Anda</p>
    </div>

    <!-- Card Filter -->
    <div class="card">
        <form action="{{ route('mandor.pengajuan.index') }}" method="GET" class="filter-section">
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <!-- Filter Jenis Cuti (Diperbaiki menggunakan name="jenis_cuti") -->
            <select name="jenis_cuti" class="form-control">
                <option value="">Semua Jenis Cuti</option>
                <option value="1" {{ request('jenis_cuti') == '1' ? 'selected' : '' }}>Cuti Tahunan</option>
                <option value="2" {{ request('jenis_cuti') == '2' ? 'selected' : '' }}>Cuti Sakit</option>
                <option value="3" {{ request('jenis_cuti') == '3' ? 'selected' : '' }}>Cuti Khusus</option>
            </select>

            <!-- Filter Tanggal Mulai (Tanpa JavaScript, murni HTML date) -->
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">

            <span style="align-self: center;">s/d</span>

            <!-- Filter Tanggal Selesai -->
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-filter">Filter</button>
                <a href="{{ route('mandor.pengajuan.index') }}" class="btn-reset" title="Reset Filter">Reset</a>
            </div>
        </form>
    </div>

    <!-- Card Table -->
    <div class="card">
        <div class="table-title">Daftar Pengajuan Cuti</div>
        
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>JENIS CUTI</th>
                        <th>MULAI</th>
                        <th>SELESAI</th>
                        <th>LAMA</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="font-weight: 500;">{{ $data->karyawan->user->name ?? '-' }}</td>
                            <td>{{ $data->jenisCuti->nama ?? '-' }}</td> 
                            <td>{{ $data->tanggal_mulai->format('d/m/Y') }}</td>
                            <td>{{ $data->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>{{ $data->durasi }} Hari</td>
                            <td>
                                @if($data->status == 'menunggu')
                                    <span class="badge badge-menunggu">Menunggu</span>
                                @elseif($data->status == 'disetujui')
                                    <span class="badge badge-disetujui">Disetujui</span>
                                @elseif($data->status == 'ditolak')
                                    <span class="badge badge-ditolak">Ditolak</span>
                                @endif
                            </td>
                            <td>
                            <a href="{{ route('mandor.pengajuan.show', $data->id) }}" class="btn-action" title="Lihat Detail">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 24px; color: #6B7280;">
                                Belum ada data pengajuan cuti.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection