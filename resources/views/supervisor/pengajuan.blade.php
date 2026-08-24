@extends('layouts.supervisor')

@section('title', 'Antrean Persetujuan - SICUTI')

@section('content')
<style>
    /* Samakan semua font elemen dengan Layout Utama */
    select, input, button, textarea, option {
        font-family: inherit;
    }

    /* Header Halaman */
    .page-header { 
        margin-bottom: 24px; 
    }
    .page-title { 
        font-size: 24px; 
        font-weight: 700; 
        color: #111827; 
        margin: 0 0 6px 0; 
    }
    .page-subtitle { 
        font-size: 14px; 
        color: #6B7280; 
        margin: 0; 
    }

    /* Card Container */
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        border: 1px solid #E5E7EB;
        margin-bottom: 24px;
    }

    /* Section Filter */
    .filter-wrapper { 
        display: flex; 
        align-items: flex-end; 
        gap: 16px; 
        flex-wrap: wrap; 
    }
    .filter-group { 
        display: flex; 
        flex-direction: column; 
        gap: 6px; 
        flex: 1; 
        min-width: 200px; 
    }
    .filter-group label { 
        font-size: 12px; 
        font-weight: 600; 
        color: #4B5563; 
    }
    
    .form-control {
        padding: 10px 14px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 14px;
        color: #1F2937;
        background-color: #FAFAFA;
        outline: none;
        width: 100%;
        box-sizing: border-box;
        font-family: inherit;
    }
    .form-control:focus { 
        border-color: #0B2447; 
        background-color: #ffffff; 
    }

    /* Group Tombol Filter & Reset */
    .button-group { 
        display: flex; 
        gap: 10px; 
        align-items: center; 
    }
    .btn-filter {
        background-color: #0B2447;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        height: 40px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
        font-family: inherit;
    }
    .btn-filter:hover { 
        background-color: #1a3a6c; 
    }
    
    .btn-reset {
        background-color: #F3F4F6;
        color: #374151;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        height: 40px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        transition: background-color 0.2s;
        font-family: inherit;
    }
    .btn-reset:hover { 
        background-color: #E5E7EB; 
    }

    /* Tabel Custom */
    .table-responsive { 
        width: 100%; 
        overflow-x: auto; 
    }
    .custom-table { 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0; 
        text-align: left; 
    }
    .custom-table th {
        background-color: #F9FAFB;
        color: #6B7280;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 16px;
        border-bottom: 1px solid #E5E7EB;
    }
    .custom-table td {
        padding: 16px;
        font-size: 13px;
        color: #1F2937;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }

    /* Styling Isi Tabel */
    .id-pengajuan { 
        color: #0B2447; 
        font-weight: 700; 
        text-decoration: none; 
    }
    .user-profile { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
    }
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #2563EB;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .user-info .name { 
        font-weight: 700; 
        color: #111827; 
        margin-bottom: 2px; 
    }
    .user-info .role { 
        font-size: 11px; 
        color: #6B7280; 
    }

    .duration-main { 
        font-weight: 700; 
        color: #111827; 
    }
    .duration-sub { 
        font-size: 11px; 
        color: #6B7280; 
    }
    
    .badge-supervisor {
        background-color: #D1E9FF;
        color: #1E40AF;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-supervisor::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #1E40AF;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        background-color: #ffffff;
        color: #374151;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
        font-family: inherit;
    }
    .btn-detail:hover { 
        background-color: #F3F4F6; 
    }

    /* Footer & Paginasi */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #E5E7EB;
        font-size: 13px;
        color: #6B7280;
    }
</style>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <!-- Pembungkus Judul & Subtitle -->
    <div>
        <h1 class="page-title">Antrean Persetujuan</h1>
        <p class="page-subtitle">Daftar pengajuan cuti yang telah disetujui Mandor dan menunggu keputusan Anda.</p>
    </div>

    <!-- Tombol di Sebelah Kanan -->
    <a href="{{ route('supervisor.pengajuan.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background-color: #0B2447; color: #ffffff; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.1); whitespace: nowrap;">
        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Ajukan Cuti
    </a>
</div>

<!-- Card Filter -->
<div class="card">
    <form method="GET" action="{{ route('supervisor.pengajuan.index') }}" class="filter-wrapper">
        
        <!-- Filter Periode Pengajuan -->
        <div class="filter-group">
            <label for="periode">Periode Pengajuan</label>
            <select name="periode" id="periode" class="form-control">
                <option value="">Semua Bulan</option>
                @foreach($listPeriode as $periode)
                    <option value="{{ $periode->value }}" {{ request('periode') == $periode->value ? 'selected' : '' }}>
                        {{ $periode->label }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Jenis Cuti -->
        <div class="filter-group">
            <label for="jenis_cuti">Jenis Cuti</label>
            <select name="jenis_cuti" id="jenis_cuti" class="form-control">
                <option value="">Semua Jenis</option>
                @foreach($listJenisCuti as $jenis)
                    <option value="{{ $jenis->id }}" {{ request('jenis_cuti') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Group Tombol Filter & Reset -->
        <div class="button-group">
            <button type="submit" class="btn-filter">
                Filter
            </button>
            <a href="{{ route('supervisor.pengajuan.index') }}" class="btn-reset">Reset</a>
        </div>
    </form>
</div>

<!-- Card Tabel Data -->
<div class="card">
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th width="15%">ID PENGAJUAN</th>
                    <th width="25%">NAMA KARYAWAN</th>
                    <th width="15%">TGL. ACC MANDOR</th>
                    <th width="15%">JENIS CUTI</th>
                    <th width="12%">DURASI</th>
                    <th width="13%">STATUS</th>
                    <th width="10%" style="text-align: right;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $item)
                    <tr>
                        <td>
                            <a href="{{ route('supervisor.pengajuan.show', $item->id) }}" class="id-pengajuan">
                                #CT-{{ $item->created_at ? $item->created_at->format('Y') : date('Y') }}-{{ sprintf('%04d', $item->id) }}
                            </a>
                        </td>
                        <td>
                            <div class="user-profile">
                                @php
                                    $nama = $item->karyawan->user->name ?? 'User';
                                    $words = explode(' ', trim($nama));
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                @endphp
                                <div class="avatar-circle">{{ $initials }}</div>
                                <div class="user-info">
                                    <div class="name">{{ $nama }}</div>
                                    <div class="role">{{ $item->karyawan->jabatan ?? 'Karyawan' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d M Y') : '-' }}</td>
                        <td>{{ $item->jenisCuti->nama ?? '-' }}</td>
                        <td>
                            <div class="duration-main">{{ $item->durasi }} Hari</div>
                            <div class="duration-sub">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <span class="badge-supervisor">Menunggu Supervisor</span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('supervisor.pengajuan.show', $item->id) }}" class="btn-detail">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 32px; color: #6B7280; font-style: italic;">
                            Belum ada antrean pengajuan cuti.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi Laravel -->
    @if($pengajuan->hasPages())
        <div class="table-footer">
            <div>
                Menampilkan {{ $pengajuan->firstItem() ?? 0 }} - {{ $pengajuan->lastItem() ?? 0 }} dari {{ $pengajuan->total() ?? 0 }} pengajuan
            </div>
            <div>
                {{ $pengajuan->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>
@endsection