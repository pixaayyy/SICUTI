@extends('layouts.mandor')

@section('title', 'Ajukan Cuti Baru - Mandor')

@section('content')

<style>
    .cuti-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 10px;
    }

    .page-header {
        margin-bottom: 30px;
        padding-bottom: 18px;
        border-bottom: 2px solid #0B2447;
    }

    .page-header h2 {
        margin: 0;
        color: #111827;
        font-size: 28px;
        font-weight: 700;
    }

    .page-header p {
        margin-top: 8px;
        color: #6B7280;
        font-size: 14px;
    }

    .alert {
        padding: 15px 18px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        color: #166534;
        background-color: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .alert-danger {
        color: #991b1b;
        background-color: #fee2e2;
        border: 1px solid #fecaca;
    }

    .alert-danger ul {
        margin: 8px 0 0 20px;
    }

    .cuti-form {
        background-color: #ffffff;
        padding: 35px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #0B2447;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 22px;
    }

    .section-title svg {
        width: 20px;
        height: 20px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background-color: #f9fafb;
        color: #333;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: #0B2447;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(11, 36, 71, 0.10);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 110px;
    }

    .form-help {
        margin-top: 6px;
        color: #888;
        font-size: 12px;
    }

    .input-error {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .special-leave {
        display: none;
        padding: 18px;
        margin-bottom: 22px;
        background-color: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
    }

    .special-leave.active {
        display: block;
    }

    .special-leave label {
        color: #0B2447;
    }

    .leave-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin-top: 10px;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .info-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .info-icon {
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #dbeafe;
        color: #0B2447;
        border-radius: 8px;
    }

    .info-icon svg {
        width: 25px;
        height: 25px;
    }

    .info-label {
        margin: 0 0 4px;
        color: #777;
        font-size: 12px;
        font-weight: 600;
    }

    .info-value {
        margin: 0;
        color: #222;
        font-size: 18px;
        font-weight: 700;
    }

    .remaining-value {
        color: #0B2447;
        text-align: right;
    }

    .upload-box {
        padding: 25px;
        text-align: center;
        border: 2px dashed #d1d5db;
        border-radius: 10px;
        transition: 0.2s;
    }

    .upload-box:hover {
        background-color: #f9fafb;
        border-color: #0B2447;
    }

    .upload-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 10px;
        color: #9ca3af;
    }

    .upload-label {
        display: inline-block;
        padding: 7px 14px;
        color: #0B2447;
        background-color: #fff;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .upload-label:hover {
        color: #1a3a6c;
    }

    .file-input {
        display: none;
    }

    .upload-text {
        color: #666;
        font-size: 13px;
    }

    .file-info {
        display: none;
        margin-top: 10px;
        color: #0B2447;
        font-size: 13px;
        font-weight: 600;
    }

    .file-info.active {
        display: block;
    }

    .note-sakit {
        display: none;
        margin-top: 10px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 600;
    }

    .note-sakit.active {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .divider {
        height: 1px;
        margin: 30px 0;
        background-color: #e5e7eb;
        border: none;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
        padding-top: 10px;
    }

    .btn-cancel {
        padding: 11px 18px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        border-radius: 7px;
    }

    .btn-cancel:hover {
        background-color: #f3f4f6;
        color: #333;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        color: white;
        background-color: #0B2447;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-submit:hover {
        background-color: #1a3a6c;
    }

    .btn-submit svg {
        width: 19px;
        height: 19px;
    }

    @media (max-width: 768px) {
        .cuti-container {
            padding: 5px;
        }

        .cuti-form {
            padding: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .leave-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .remaining-value {
            text-align: left;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-submit,
        .btn-cancel {
            text-align: center;
            justify-content: center;
        }
    }
</style>

<div class="cuti-container">
    <div class="page-header">
        <h2>Ajukan Cuti Baru (Mandor)</h2>
        <p>Silakan isi formulir di bawah ini dengan lengkap untuk mengajukan permohonan cuti Anda.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Pengajuan belum dapat dikirim.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mandor.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="cuti-form">
        @csrf

        <div class="form-section">
            <h3 class="section-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Detail Cuti
            </h3>

            <div class="form-group">
                <label for="jenis_cuti" class="form-label">
                    Jenis Cuti
                    <span class="required">*</span>
                </label>
                <select id="jenis_cuti" name="jenis_cuti_id" required class="form-control">
                    <option value="" disabled selected>Pilih jenis cuti...</option>
                    @foreach($jenisCutis as $jenis)
                        <option value="{{ $jenis->id }}" data-nama="{{ strtolower($jenis->nama) }}" {{ old('jenis_cuti_id') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama }}
                        </option>
                    @endforeach
                </select>
                <p class="form-help">Pilih kategori cuti yang sesuai dengan kebutuhan Anda.</p>
                @error('jenis_cuti_id')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div id="kolom_cuti_khusus" class="special-leave">
                <label for="catatan" class="form-label">
                    Detail Cuti Khusus
                    <span class="required">*</span>
                </label>
                <input type="text" id="catatan" name="catatan" value="{{ old('catatan') }}" placeholder="Misal: Menikah, Istri Melahirkan, Ada keluarga meninggal..." class="form-control">
                <p class="form-help">Sebutkan secara spesifik keperluan cuti khusus Anda.</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="tanggal_mulai" class="form-label">
                        Tanggal Mulai
                        <span class="required">*</span>
                    </label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="form-control">
                    @error('tanggal_mulai')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai" class="form-label">
                        Tanggal Selesai
                        <span class="required">*</span>
                    </label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="form-control">
                    @error('tanggal_selesai')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="leave-info">
                <div class="info-left">
                    <div class="info-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="info-label">Estimasi Durasi</p>
                        <p id="estimasi_durasi" class="info-value">- Hari</p>
                    </div>
                </div>
                <div>
                    <p class="info-label">Sisa Cuti Tahunan</p>
                    <p class="info-value remaining-value">{{ $sisaCuti ?? 0 }} Hari</p>
                </div>
            </div>
        </div>

        <hr class="divider">

        <div class="form-section">
            <h3 class="section-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                </svg>
                Keterangan Tambahan
            </h3>

            <div class="form-group">
                <label for="alasan" class="form-label">
                    Alasan / Keterangan
                    <span class="required">*</span>
                </label>
                <textarea id="alasan" name="alasan" rows="4" required placeholder="Jelaskan alasan pengajuan cuti secara singkat..." class="form-control">{{ old('alasan') }}</textarea>
                @error('alasan')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label id="label_dokumen" class="form-label">
                    Dokumen Pendukung (Opsional)
                </label>

                <div class="upload-box">
                    <svg class="upload-icon" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <div>
                        <label for="data_pendukung" class="upload-label">
                            Unggah File
                            <input id="data_pendukung" name="data_pendukung" type="file" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <span class="upload-text">atau pilih file dari komputer</span>
                    </div>

                    <p class="form-help">PDF, JPG, PNG maksimal 5MB</p>
                    <p id="file-name-display" class="file-info"></p>
                </div>

                <p id="note_sakit" class="note-sakit">
                    <span>⚠</span>
                    Wajib melampirkan Surat Keterangan Sakit dari Dokter!
                </p>

                @error('data_pendukung')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('mandor.pengajuan.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L5.999 12Zm0 0h7.5"/>
                </svg>
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const jenisCuti = document.getElementById('jenis_cuti');
    const kolomKhusus = document.getElementById('kolom_cuti_khusus');
    const inputKhusus = document.getElementById('catatan');
    const dokumenInput = document.getElementById('data_pendukung');
    const labelDokumen = document.getElementById('label_dokumen');
    const noteSakit = document.getElementById('note_sakit');
    const fileNameDisplay = document.getElementById('file-name-display');
    const tglMulai = document.getElementById('tanggal_mulai');
    const tglSelesai = document.getElementById('tanggal_selesai');
    const estimasiDurasi = document.getElementById('estimasi_durasi');

    dokumenInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            fileNameDisplay.textContent = 'File terpilih: ' + this.files[0].name;
            fileNameDisplay.classList.add('active');
        } else {
            fileNameDisplay.textContent = '';
            fileNameDisplay.classList.remove('active');
        }
    });

    function cekJenisCuti() {
        if (!jenisCuti.value) {
            return;
        }

        const selectedOption = jenisCuti.options[jenisCuti.selectedIndex];
        const nama = selectedOption.getAttribute('data-nama');

        if (nama && (nama.includes('khusus') || nama.includes('penting'))) {
            kolomKhusus.classList.add('active');
            inputKhusus.setAttribute('required', 'required');
        } else {
            kolomKhusus.classList.remove('active');
            inputKhusus.removeAttribute('required');
            inputKhusus.value = '';
        }

        if (nama && nama.includes('sakit')) {
            noteSakit.classList.add('active');
            labelDokumen.innerHTML = 'Dokumen Pendukung (Surat Dokter) <span class="required">*</span>';
            dokumenInput.setAttribute('required', 'required');
        } else {
            noteSakit.classList.remove('active');
            labelDokumen.textContent = 'Dokumen Pendukung (Opsional)';
            dokumenInput.removeAttribute('required');
        }
    }

    jenisCuti.addEventListener('change', cekJenisCuti);
    cekJenisCuti();

    function hitungDurasi() {
        if (tglMulai.value && tglSelesai.value) {
            const start = new Date(tglMulai.value);
            const end = new Date(tglSelesai.value);

            if (end >= start) {
                const diffTime = end.getTime() - start.getTime();
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

                estimasiDurasi.textContent = diffDays + ' Hari';
                estimasiDurasi.style.color = '#222';
            } else {
                estimasiDurasi.textContent = 'Tidak Valid';
                estimasiDurasi.style.color = '#dc2626';
            }
        } else {
            estimasiDurasi.textContent = '- Hari';
            estimasiDurasi.style.color = '#222';
        }
    }

    tglMulai.addEventListener('change', hitungDurasi);
    tglSelesai.addEventListener('change', hitungDurasi);
    hitungDurasi();
});
</script>

@endsection