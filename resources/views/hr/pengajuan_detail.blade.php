@extends('layouts.hr')
@section('title', 'Detail Pengajuan Cuti')

@section('content')
<style>
    /* Header Area */
    .header-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .breadcrumb-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .back-link {
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .back-link:hover { color: #111827; }
    .divider { color: #d1d5db; }
    .page-title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
    }
    
    /* Top Badge */
    .status-badge-top {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
    }
    .dot { width: 8px; height: 8px; border-radius: 50%; }
    .dot-blue { background-color: #3b82f6; }

    /* Layout Grid */
    .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    /* Cards Setup */
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        margin-bottom: 24px;
    }

    /* Karyawan Profile */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }
    .profile-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-name { margin: 0 0 4px 0; font-size: 18px; font-weight: 600; color: #111827; }
    .profile-job { margin: 0; font-size: 13px; color: #6b7280; }
    
    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .stat-item label { display: block; font-size: 12px; color: #6b7280; margin-bottom: 4px; }
    .stat-item p { margin: 0; font-size: 14px; font-weight: 500; color: #111827; }
    .text-blue { color: #2563eb !important; }

    /* Informasi Pengajuan */
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin: 0 0 16px 0;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .info-item label { display: block; font-size: 12px; color: #6b7280; margin-bottom: 4px; }
    .info-item p { margin: 0; font-size: 14px; font-weight: 500; color: #111827; }
    
    /* Date Box */
    .date-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f9fafb;
        border-radius: 8px;
        padding: 16px 24px;
        margin-bottom: 20px;
    }
    .date-column { text-align: center; }
    .date-label { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
    .date-value { font-size: 15px; font-weight: 600; color: #111827; margin: 0; }
    .date-arrow { color: #9ca3af; }

    /* Reason & Attachment Box */
    .grey-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        font-size: 13px;
        color: #374151;
        line-height: 1.5;
        margin-bottom: 20px;
    }
    .attachment-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 16px;
    }
    .attachment-info { display: flex; align-items: center; gap: 12px; }
    .attachment-icon { color: #ef4444; }
    .attachment-name { font-size: 13px; font-weight: 500; color: #111827; margin: 0; }
    .attachment-size { font-size: 11px; color: #6b7280; margin: 0; }
    .btn-download { color: #6b7280; text-decoration: none; }
    .btn-download:hover { color: #111827; }

    /* Right Sidebar (Action & Timeline) */
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; color: #6b7280; margin-bottom: 8px; }
    .form-control {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px;
        font-size: 13px;
        font-family: inherit;
        resize: vertical;
        min-height: 80px;
        outline: none;
    }
    .form-control:focus { border-color: #2563eb; }

    .btn {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        margin-bottom: 12px;
    }
    .btn-approve { background-color: #0b3b84; color: #ffffff; }
    .btn-approve:hover { background-color: #082b61; }
    .btn-reject { background-color: #f3f4f6; color: #ef4444; border: 1px solid #e5e7eb; }
    .btn-reject:hover { background-color: #fef2f2; }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 20px;
        margin-top: 20px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 5px;
        top: 6px;
        bottom: 0;
        width: 2px;
        background-color: #e5e7eb;
    }
    .timeline-item { position: relative; margin-bottom: 24px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-dot {
        position: absolute;
        left: -20px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #e5e7eb;
        border: 2px solid #ffffff;
    }
    .timeline-dot.active { background-color: #0b3b84; }
    .timeline-content h4 { margin: 0 0 4px 0; font-size: 13px; font-weight: 600; color: #111827; }
    .timeline-content p { margin: 0; font-size: 12px; color: #6b7280; }
</style>

<!-- Tambahkan Alert Flash Message di sini -->
    @if(session('error'))
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
            ⚠️ {{ session('error') }}
        </div>
    @endif
<!-- Header Area -->
<div class="header-area">
    <div class="breadcrumb-title">
        <a href="{{ route('hr.persetujuan') }}" class="back-link">
            &larr; Kembali ke Daftar
        </a>
        <span class="divider">|</span>
        <h2 class="page-title">Detail Pengajuan Cuti</h2>
    </div>
    <div class="status-badge-top">
        <div class="dot {{ in_array($pengajuan->status, ['menunggu', 'menunggu_supervisor']) ? 'dot-blue' : '' }}" style="{{ $pengajuan->status == 'disetujui' ? 'background-color: #10b981;' : ($pengajuan->status == 'ditolak' ? 'background-color: #ef4444;' : '') }}"></div>
        {{ ucfirst($pengajuan->status) }}
    </div>
</div>

<div class="main-grid">
    <!-- Kolom Kiri -->
    <div class="left-column">
        <!-- Kartu Profil -->
        <div class="card">
            <div class="profile-header">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($pengajuan->karyawan->user->name ?? 'U') }}&background=random" class="profile-avatar">
                <div>
                    <h3 class="profile-name">{{ $pengajuan->karyawan->user->name ?? '-' }}</h3>
                    <p class="profile-job">{{ $pengajuan->karyawan->jabatan ?? 'Staff' }}</p>
                </div>
            </div>
            <div class="profile-stats">
                <div class="stat-item">
                    <label>NIK</label>
                    <p>{{ $pengajuan->karyawan->nik ?? 'EMP-' . str_pad($pengajuan->karyawan_id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="stat-item">
                    <label>Departemen</label>
                    <p>{{ $pengajuan->karyawan->departemen ?? '-' }}</p>
                </div>
                <div class="stat-item">
                    <label>Sisa Cuti</label>
                    <p class="text-blue">{{ $pengajuan->karyawan->sisa_cuti ?? 12 }} Hari</p>
                </div>
                <div class="stat-item">
                    <label>Tanggal Bergabung</label>
                    <p>{{ $pengajuan->karyawan->tanggal_bergabung ? \Carbon\Carbon::parse($pengajuan->karyawan->tanggal_bergabung)->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Kartu Informasi Pengajuan -->
        <div class="card">
            <h3 class="section-title">Informasi Pengajuan</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Jenis Cuti</label>
                    <p>{{ $pengajuan->jenisCuti->nama ?? '-' }}</p>
                </div>
                <div class="info-item">
                    <label>Durasi</label>
                    <p>{{ $pengajuan->durasi }} Hari</p>
                </div>
            </div>

            <!-- Tanggal Box -->
            <div class="date-box">
                <div class="date-column">
                    <div class="date-label">Tanggal Mulai</div>
                    <div class="date-value">{{ $pengajuan->tanggal_mulai ? $pengajuan->tanggal_mulai->format('d M Y') : '-' }}</div>
                </div>
                <div class="date-arrow">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
                <div class="date-column">
                    <div class="date-label">Tanggal Selesai</div>
                    <div class="date-value">{{ $pengajuan->tanggal_selesai ? $pengajuan->tanggal_selesai->format('d M Y') : '-' }}</div>
                </div>
            </div>

            <!-- Alasan -->
            <div class="info-item">
                <label>Alasan</label>
                <div class="grey-box">
                    {{ $pengajuan->alasan ?? 'Tidak ada alasan yang dilampirkan.' }}
                </div>
            </div>

            <!-- Lampiran (Muncul jika ada) -->
            @if($pengajuan->data_pendukung)
            <div class="info-item">
                <label>Lampiran</label>
                <div class="attachment-box">
                    <div class="attachment-info">
                        <svg class="attachment-icon" width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        <div>
                            <p class="attachment-name">Dokumen_Pendukung.pdf</p>
                            <p class="attachment-size">Lihat Lampiran</p>
                        </div>
                    </div>
                    <a href="{{ route('hr.pengajuan.download', $pengajuan->id) }}" class="btn-download">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="right-column">
        <!-- Kartu Aksi -->
        <div class="card" style="border-top: 4px solid #0b3b84;">
            <h3 class="section-title">Tindakan Peninjauan</h3>
            
            <!-- Form Proses Persetujuan -->
            <form action="{{ route('hr.pengajuan.proses', $pengajuan->id) }}" method="POST">
                @csrf
                <!-- Catatan Opsional -->
                <div class="form-group">
                    <label>Komentar HR (Opsional)</label>
                    <textarea name="catatan" class="form-control" placeholder="Tambah catatan..."></textarea>
                </div>

                <!-- Tombol -->
                @if(in_array($pengajuan->status, ['menunggu', 'menunggu_supervisor']))
                    <button type="submit" name="action" value="setujui" class="btn btn-approve">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Setujui Pengajuan
                    </button>
                    <button type="submit" name="action" value="tolak" class="btn btn-reject">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tolak Pengajuan
                    </button>
                @else
                    <div style="text-align: center; font-size: 13px; color: #6b7280; padding: 12px; background-color: #f9fafb; border-radius: 8px;">
                        Pengajuan ini telah <strong>{{ $pengajuan->status }}</strong>.
                    </div>
                @endif
            </form>
        </div>

        <!-- Kartu Timeline -->
        <div class="card">
            <h3 class="section-title">Timeline Persetujuan</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-dot active"></div>
                    <div class="timeline-content">
                        <h4>Pengajuan Dibuat</h4>
                        <p>{{ $pengajuan->created_at->format('d M Y, H:i') }}<br>Diajukan oleh {{ $pengajuan->karyawan->user->name ?? 'Karyawan' }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot {{ $pengajuan->status != 'menunggu' ? 'active' : '' }}"></div>
                    <div class="timeline-content">
                        <h4>Persetujuan Akhir HR</h4>
                        <p>{{ in_array($pengajuan->status, ['disetujui', 'ditolak']) ? 'Selesai' : 'Menunggu' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection