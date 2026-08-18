@extends('layouts.karyawan')

@section('title', 'Status Pengajuan Cuti')

@section('content')

<style>
    .page-header {
        margin-bottom: 25px;
    }

    .page-header h2 {
        margin: 0;
        color: #1f2937;
        font-size: 26px;
        font-weight: 700;
    }

    .page-header p {
        margin-top: 6px;
        color: #6b7280;
        font-size: 14px;
    }

    .status-card {
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 22px;
        margin-bottom: 18px;
    }

    .status-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .status-card-header h3 {
        margin: 0;
        color: #1f2937;
        font-size: 17px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-menunggu {
        background: #fff7ed;
        color: #c2410c;
    }

    .status-disetujui {
        background: #ecfdf5;
        color: #047857;
    }

    .status-ditolak {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-detail {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .detail-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 14px;
    }

    .detail-label {
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #1f2937;
        font-size: 14px;
        font-weight: 600;
    }

    .empty-data {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 50px 20px;
        text-align: center;
        color: #6b7280;
    }

    .empty-data h3 {
        margin-bottom: 8px;
        color: #374151;
        font-size: 17px;
    }

    @media (max-width: 700px) {
        .status-detail {
            grid-template-columns: 1fr;
        }

        .status-card-header {
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
        }
    }
</style>

<div class="page-header">
    <h2>Status Pengajuan Cuti</h2>
    <p>Pantau status pengajuan cuti yang telah Anda ajukan.</p>
</div>

@if($pengajuanCuti->count() > 0)
    @foreach($pengajuanCuti as $cuti)
        <div class="status-card">
            <div class="status-card-header">
                <h3>{{ $cuti->jenisCuti->nama ?? 'Jenis Cuti' }}</h3>

                @if($cuti->status == 'Menunggu')
                    <span class="status-badge status-menunggu">Menunggu</span>
                @elseif($cuti->status == 'Disetujui')
                    <span class="status-badge status-disetujui">Disetujui</span>
                @elseif($cuti->status == 'Ditolak')
                    <span class="status-badge status-ditolak">Ditolak</span>
                @else
                    <span class="status-badge">{{ $cuti->status }}</span>
                @endif
            </div>

            <div class="status-detail">
                <div class="detail-item">
                    <div class="detail-label">Tanggal Mulai</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Tanggal Selesai</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Durasi</div>
                    <div class="detail-value">{{ $cuti->durasi }} Hari</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Alasan</div>
                    <div class="detail-value">{{ $cuti->alasan }}</div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="empty-data">
        <h3>Belum Ada Pengajuan</h3>
        <p>Anda belum memiliki pengajuan cuti.</p>
    </div>
@endif

@endsection