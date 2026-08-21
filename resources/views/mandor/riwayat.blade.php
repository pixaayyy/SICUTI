@extends('layouts.mandor')

@section('title', 'Riwayat Persetujuan - SICUTI')

@section('content')
<style>
    /* Header Halaman */
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6B7280;
        margin: 0 0 24px 0;
    }
    
    /* Container Utama */
    .card-container {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #F3F4F6;
        padding: 24px;
    }

    /* Section Filter */
    .filter-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-end;
        margin-bottom: 24px;
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
        color: #374151;
    }

    .filter-group select {
        padding: 10px 12px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 14px;
        color: #111827;
        background-color: #ffffff;
        outline: none;
        width: 100%;
    }

    .filter-group select:focus {
        border-color: #0B2447;
    }

    .btn-filter {
        background-color: #0B2447;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        height: 42px;
    }

    .btn-filter:hover {
        background-color: #1a3a6c;
    }

    /* Section Tabel */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        background-color: #F9FAFB;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        border-bottom: 1px solid #E5E7EB;
    }

    td {
        padding: 16px;
        font-size: 13px;
        color: #111827;
        border-bottom: 1px solid #E5E7EB;
        vertical-align: middle;
    }
    
    /* Badge Status */
    .badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-disetujui {
        background-color: #ECFDF5;
        color: #059669;
        border: 1px solid #A7F3D0;
    }

    .badge-ditolak {
        background-color: #FEF2F2;
        color: #DC2626;
        border: 1px solid #FECACA;
    }

    .badge-default {
        background-color: #F3F4F6;
        color: #374151;
    }

    /* Section Paginasi */
    .pagination-wrapper {
        margin-top: 24px;
    }

    .pagination-wrapper nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-wrapper p {
        font-size: 13px;
        color: #6B7280;
        margin: 0;
    }
</style>

<div>
    <h1 class="page-title">Riwayat Persetujuan</h1>
    <p class="page-subtitle">Riwayat keputusan atas pengajuan cuti oleh Anda</p>

    <div class="card-container">
        <!-- Form Filter -->
        <form method="GET" action="{{ route('mandor.riwayat') }}">
            <div class="filter-wrapper">
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="">Semua</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="jenis_cuti">Jenis Cuti</label>
                    <select name="jenis_cuti" id="jenis_cuti">
                        <option value="">Semua</option>
                        <option value="Tahunan" {{ request('jenis_cuti') == 'Tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                        <option value="Sakit" {{ request('jenis_cuti') == 'Sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                        <option value="Pribadi" {{ request('jenis_cuti') == 'Pribadi' ? 'selected' : '' }}>Cuti Pribadi</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="periode">Periode</label>
                    <select name="periode" id="periode">
                        <option value="">Semua Waktu</option>
                        <option value="08-2026" {{ request('periode') == '08-2026' ? 'selected' : '' }}>Agustus 2026</option>
                        <option value="07-2026" {{ request('periode') == '07-2026' ? 'selected' : '' }}>Juli 2026</option>
                        <option value="06-2026" {{ request('periode') == '06-2026' ? 'selected' : '' }}>Juni 2026</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>

        <!-- Tabel Data Dinamis -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama</th>
                        <th width="15%">Jenis Cuti</th>
                        <th width="15%">Tanggal Mulai</th>
                        <th width="10%">Lama</th>
                        <th width="15%">Keputusan</th>
                        <th width="20%">Tanggal Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $item)
                        <tr>
                            <td>{{ $riwayat->firstItem() + $index }}</td>
                            <td style="font-weight: 500;">{{ $item->karyawan->user->name ?? '-' }}</td>
                            <td>{{ $item->jenisCuti->nama ?? '-' }}</td>
                            <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->durasi ?? '-' }} Hari</td>
                            <td>
                                @if($item->status == 'disetujui')
                                    <span class="badge badge-disetujui">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="badge badge-ditolak">Ditolak</span>
                                @else
                                    <span class="badge badge-default">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 32px 16px; color: #6B7280; font-style: italic;">
                                Belum ada riwayat persetujuan cuti.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Laravel -->
        <div class="pagination-wrapper">
            {{ $riwayat->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection