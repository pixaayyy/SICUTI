@extends('layouts.mandor')

@section('title', 'Detail Pengajuan Cuti - SICUTI')

@section('content')
<style>
    .detail-container { 
        display: grid; 
        grid-template-columns: 2fr 1fr; 
        gap: 24px; 
    }
    @media (max-width: 1024px) { 
        .detail-container { 
        grid-template-columns: 1fr; 
        } 
    }
    .card-detail { 
        background-color: #ffffff; 
        border-radius: 12px; 
        padding: 24px; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.05); 
        border: 1px solid #F3F4F6; 
        margin-bottom: 24px; 
    }
    .top-header { 
        display: flex; 
        align-items: center; 
        gap: 16px; 
        margin-bottom: 24px; 
    }
    .back-btn { 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        width: 36px; 
        height: 36px; 
        border-radius: 8px; 
        border: 1px solid #E5E7EB; 
        background: #ffffff; 
        color: #374151; 
        text-decoration: none; 
    }
    .back-btn:hover { 
        background-color: #F9FAFB; 
    }
    .section-title { 
        font-size: 15px; 
        font-weight: 600; 
        color: #111827; 
        margin-bottom: 16px; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
    }
    .info-grid { 
        display: grid; 
        grid-template-columns: auto 1fr; 
        gap: 20px; 
        align-items: center; 
    }
    .emp-photo { 
        width: 64px; 
        height: 64px; 
        border-radius: 50%; 
        object-fit: cover; 
        border: 1px solid #E5E7EB; 
    }
    .emp-details { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 16px; 
    }
    .emp-item label { 
        font-size: 11px; 
        color: #6B7280; 
        text-transform: uppercase; 
        font-weight: 600; 
        display: block; 
        margin-bottom: 2px; 
    }
    .emp-item span { 
        font-size: 14px; 
        font-weight: 600; 
        color: #1F2937; 
    }
    .cuti-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 16px; 
        margin-bottom: 20px; 
    }
    .sub-box { 
        background-color: #F9FAFB; 
        border: 1px solid #E5E7EB; 
        border-radius: 8px; 
        padding: 16px; 
    }
    .sub-box label { 
        font-size: 11px; 
        color: #6B7280; 
        text-transform: uppercase; 
        font-weight: 600; 
        display: block; 
        margin-bottom: 4px; 
    }
    .sub-box span { 
        font-size: 14px; 
        font-weight: 600; 
        color: #111827; 
    }
    .date-info-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 16px; 
        margin-bottom: 20px; 
    }
    .reason-box { 
        background-color: #F9FAFB; 
        border: 1px solid #E5E7EB; 
        border-radius: 8px; 
        padding: 16px; 
        font-size: 13px; 
        color: #4B5563; 
        line-height: 1.5; 
        margin-bottom: 20px;
    }
    .proof-box {
        background-color: #F9FAFB; 
        border: 1px solid #E5E7EB; 
        border-radius: 8px; 
        padding: 16px; 
    }
    .proof-preview {
        max-width: 100%;
        max-height: 250px;
        border-radius: 6px;
        border: 1px solid #E5E7EB;
        object-fit: contain;
        display: block;
        margin-top: 8px;
    }
    .timeline-item { 
        display: flex; 
        gap: 14px; 
        position: relative; 
        padding-bottom: 20px; 
    }
    .timeline-item:not(:last-child):before { 
        content: ''; 
        position: absolute; 
        left: 11px; 
        top: 24px; 
        width: 2px; 
        height: calc(100% - 4px); 
        background-color: #E5E7EB; 
    }
    .timeline-icon { 
        width: 24px; 
        height: 24px; 
        border-radius: 50%; 
        background-color: #0B2447; 
        color: white; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 11px; 
        flex-shrink: 0; 
    }
    .timeline-content h4 { 
        font-size: 13px; 
        font-weight: 600; 
        color: #111827; 
        margin: 0 0 2px 0; 
    }
    .timeline-content p { 
        font-size: 12px; 
        color: #6B7280; 
        margin: 0; 
    }
    .timeline-note { 
        background-color: #F3F4F6; 
        border-radius: 6px; 
        padding: 8px 12px; 
        font-size: 12px; 
        color: #4B5563; 
        margin-top: 6px; 
    }
    .btn-approve { 
        width: 100%; 
        background-color: #0B2447; 
        color: white; 
        border: none; 
        border-radius: 8px; 
        padding: 12px; 
        font-weight: 600; 
        font-size: 14px; 
        cursor: pointer; 
        margin-bottom: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 8px; 
    }
    .btn-approve:hover { 
        background-color: #1a3a6c; 
    }
    .btn-reject { 
        width: 100%; 
        background-color: #ffffff; 
        color: #DC2626; 
        border: 1px solid #DC2626; 
        border-radius: 8px; 
        padding: 12px; 
        font-weight: 600; 
        font-size: 14px; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 8px; 
    }
    .btn-reject:hover { 
        background-color: #FEF2F2; 
    }
    .badge-status { 
        padding: 6px 12px; 
        border-radius: 20px; 
        font-size: 12px; 
        font-weight: 600; 
        background-color: #F3F4F6; 
        color: #4B5563; 
    }
    .reject-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .reject-modal.show {
        display: flex;
    }

    .reject-modal-content {
        width: 100%;
        max-width: 500px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: rejectModalShow 0.2s ease-out;
    }

    @keyframes rejectModalShow {
        from {
            opacity: 0;
            transform: translateY(-15px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .reject-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 20px 22px;
        border-bottom: 1px solid #E5E7EB;
    }

    .reject-modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .reject-modal-header p {
        margin: 5px 0 0;
        font-size: 13px;
        color: #6B7280;
    }

    .reject-close {
        border: none;
        background: transparent;
        font-size: 27px;
        color: #6B7280;
        cursor: pointer;
        line-height: 1;
    }

    .reject-close:hover {
        color: #111827;
    }

    .reject-modal-body {
        padding: 22px;
    }

    .reject-modal-body label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .reject-modal-body label span {
        color: #DC2626;
    }

    .reject-modal-body textarea {
        width: 100%;
        min-height: 120px;
        padding: 12px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        resize: vertical;
        font-family: inherit;
        font-size: 13px;
        color: #111827;
        outline: none;
        box-sizing: border-box;
    }

    .reject-modal-body textarea:focus {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
    }

    .reject-modal-body small {
        display: block;
        margin-top: 7px;
        font-size: 11px;
        color: #9CA3AF;
    }

    .reject-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 22px;
        background: #F9FAFB;
        border-top: 1px solid #E5E7EB;
    }

    .btn-cancel-reject {
        padding: 10px 18px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-cancel-reject:hover {
        background: #F3F4F6;
    }

    .btn-confirm-reject {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        background: #DC2626;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirm-reject:hover {
        background: #B91C1C;
    }
</style>

<div class="top-header">
    <a href="{{ route('mandor.pengajuan.index') }}" class="back-btn">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #111827; margin: 0;">Detail Pengajuan Cuti</h1>
        <p style="font-size: 13px; color: #6B7280; margin: 2px 0 0 0;">ID: REQ-{{ str_pad($detail->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div style="margin-left: auto;">
        <span class="badge-status">{{ ucfirst($detail->status) }}</span>
    </div>
</div>

<div class="detail-container">
    <div>
        <div class="card-detail">
            <div class="section-title">Informasi Karyawan</div>
            <div class="info-grid">
                <div>
                    <div class="emp-photo" style="display:flex; align-items:center; justify-content:center; background:#0B2447; font-weight:bold; color:white; font-size: 20px;">
                        {{ strtoupper(substr($detail->karyawan->user->name ?? 'K', 0, 1)) }}
                    </div>
                </div>
                <div class="emp-details">
                    <div class="emp-item">
                        <label>Nama Lengkap</label>
                        <span>{{ $detail->karyawan->user->name ?? '-' }}</span>
                    </div>
                    <div class="emp-item">
                        <label>ID Karyawan</label>
                        <span>EMP-{{ str_pad($detail->karyawan->id ?? 0, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="emp-item">
                        <label>Posisi</label>
                        <span>{{ $detail->karyawan->posisi ?? '-' }}</span>
                    </div>
                    <div class="emp-item">
                        <label>Departemen</label>
                        <span>{{ $detail->karyawan->departemen ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-detail">
            <div class="section-title">Detail Cuti</div>
            <div class="cuti-grid">
                <div class="sub-box">
                    <label>Jenis Cuti</label>
                    <span>{{ $detail->jenisCuti->nama ?? '-' }}</span>
                </div>
                <div class="sub-box">
                    <label>Sisa Kuota Cuti</label>
                    <span>{{ $detail->karyawan->sisa_cuti ?? '-' }} Hari</span>
                </div>
            </div>

            <div class="date-info-grid">
                <div class="sub-box">
                    <label>Tanggal Mulai</label>
                    <span>{{ \Carbon\Carbon::parse($detail->tanggal_mulai)->format('d M Y') }}</span>
                </div>
                <div class="sub-box">
                    <label>Tanggal Selesai</label>
                    <span>{{ \Carbon\Carbon::parse($detail->tanggal_selesai)->format('d M Y') }}</span>
                </div>
                <div class="sub-box">
                    <label>Total Durasi</label>
                    <span style="color: #2563EB;">{{ $detail->durasi }} Hari Kerja</span>
                </div>
            </div>

            <div style="margin-bottom: 8px;"><label style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 600;">Alasan Pengajuan</label></div>
            <div class="reason-box">
                {{ $detail->alasan ?? 'Tidak ada catatan alasan.' }}
            </div>

            {{-- Bagian Bukti Pendukung / Surat Sakit --}}
            <div style="margin-bottom: 8px;">
                <label style="font-size: 11px; color: #6B7280; text-transform: uppercase; font-weight: 600;">Bukti Pendukung / Surat Sakit</label>
            </div>
            <div class="proof-box">
                @if(!empty($detail->data_pendukung))
                    @php
                        $filePath = $detail->data_pendukung;
                        
                        // Bersihkan awalan 'public/' jika tersimpan dengan format tersebut di database
                        if (Str::startsWith($filePath, 'public/')) {
                            $filePath = Str::replaceFirst('public/', '', $filePath);
                        }
                        
                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                            <img src="{{ asset('storage/' . $filePath) }}" alt="Bukti Cuti" class="proof-preview">
                        </a>
                        <p style="font-size: 11px; color: #6B7280; margin-top: 6px;">* Klik gambar untuk memperbesar</p>
                    @elseif(strtolower($extension) == 'pdf')
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 13px; color: #374151; font-weight: 500;">Dokumen Surat Sakit (PDF)</span>
                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank" style="background-color: #0B2447; color: white; padding: 8px 14px; border-radius: 6px; font-size: 12px; text-decoration: none; font-weight: 600;">Buka / Unduh PDF</a>
                        </div>
                    @else
                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank" style="font-size: 13px; color: #2563EB; text-decoration: underline;">Unduh Berkas Pendukung</a>
                    @endif
                @else
                    <span style="font-size: 13px; color: #6B7280; font-style: italic;">Tidak ada bukti pendukung yang diunggah.</span>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="card-detail">
            <div class="section-title">Timeline Persetujuan</div>
            <div class="timeline-item">
                <div class="timeline-icon">✓</div>
                <div class="timeline-content">
                    <h4>Pengajuan Dibuat</h4>
                    <p>{{ $detail->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-icon">✓</div>
                <div class="timeline-content">
                    <h4>Persetujuan Mandor</h4>
                    <p>{{ $detail->updated_at->format('d M Y, H:i') }} WIB</p>
                    <div class="timeline-note">"Status: {{ ucfirst($detail->status) }}"</div>
                </div>
            </div>
        </div>

        @if($detail->status == 'menunggu')
        <div class="card-detail">
            <p style="font-size: 13px; color: #4B5563; margin-bottom: 16px;">Silakan berikan keputusan untuk pengajuan ini.</p>
            
            <form action="{{ route('mandor.pengajuan.setujui', $detail->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-approve">✓ SETUJUI PENGAJUAN</button>
            </form>

            <form action="{{ route('mandor.pengajuan.tolak', $detail->id) }}"
                method="POST"
                style="margin-top: 10px;"
                id="rejectForm">
                @csrf

                <button type="button"
                        class="btn-reject"
                        onclick="openRejectModal()">
                    ✕ TOLAK PENGAJUAN
                </button>

                <!-- MODAL ALASAN PENOLAKAN -->
                <div id="rejectModal" class="reject-modal">
                    <div class="reject-modal-content">

                        <div class="reject-modal-header">
                            <div>
                                <h3>Alasan Penolakan</h3>
                                <p>Berikan alasan mengapa pengajuan cuti ini ditolak.</p>
                            </div>

                            <button type="button"
                                    class="reject-close"
                                    onclick="closeRejectModal()">
                                &times;
                            </button>
                        </div>

                        <div class="reject-modal-body">

                            <label for="catatan">
                                Alasan Penolakan <span>*</span>
                            </label>

                            <textarea
                                name="catatan"
                                id="catatan"
                                rows="5"
                                placeholder="Contoh: Pengajuan cuti ditolak karena kebutuhan operasional tim..."
                                required></textarea>

                            <small>
                                Alasan ini akan dikirimkan kepada karyawan.
                            </small>

                        </div>

                        <div class="reject-modal-footer">
                            <button type="button"
                                    class="btn-cancel-reject"
                                    onclick="closeRejectModal()">
                                Batal
                            </button>

                            <button type="submit"
                                    class="btn-confirm-reject">
                                ✕ Tolak Pengajuan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

<script>
    function openRejectModal() {
        const modal = document.getElementById('rejectModal');
        const textarea = document.getElementById('catatan');

        modal.classList.add('show');

        setTimeout(() => {
            textarea.focus();
        }, 100);
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('show');
    }

    // Tutup modal jika klik area luar popup
    document.getElementById('rejectModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeRejectModal();
        }
    });

    // Tutup dengan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeRejectModal();
        }
    });
</script>
@endsection