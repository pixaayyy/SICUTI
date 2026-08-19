@extends('layouts.mandor')

@section('content')

<style>
    /* ==========================================
       DASHBOARD
       ========================================== */

    .dashboard-header {
        margin-bottom: 24px;
    }

    .dashboard-header h2 {
        font-size: 24px;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .dashboard-header p {
        color: #6b7280;
        font-size: 14px;
    }


    /* ==========================================
       CARDS
       ========================================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #f3f4f6;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-box.orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .icon-box.green {
        background: #f0fdf4;
        color: #16a34a;
    }

    .icon-box.red {
        background: #fef2f2;
        color: #dc2626;
    }

    .icon-box.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .badge-orange {
        background: #ffedd5;
        color: #c2410c;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 600;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        margin-top: 4px;
    }


    /* ==========================================
       TABLE
       ========================================== */

    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #f3f4f6;
        margin-bottom: 24px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-header h3 {
        font-size: 16px;
        color: #1f2937;
    }

    .table-header p {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    th {
        text-align: left;
        padding: 12px 8px;
        color: #6b7280;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
        font-size: 11px;
        text-transform: uppercase;
    }

    td {
        padding: 14px 8px;
        border-bottom: 1px solid #f3f4f6;
        color: #1f2937;
        vertical-align: middle;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-menunggu {
        background-color: #fef08a;
        color: #854d0e;
    }

    .btn-detail {
        background-color: #0d3b82;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background-color: #082a5c;
    }


    /* ==========================================
       BOTTOM GRID
       ========================================== */

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }

    .chart-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #f3f4f6;
    }

    .chart-container {
        position: relative;
        height: 200px;
        width: 100%;
        margin-top: 16px;
    }

    .info-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #f3f4f6;
    }

    .info-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        gap: 16px;
        margin-top: 16px;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: #e0e7ff;
        color: #4f46e5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-text h4 {
        font-size: 14px;
        margin-bottom: 4px;
        color: #1f2937;
    }

    .info-text p {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
    }


    /* ==========================================
       MODAL
       ========================================== */

    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 12px;
        width: 500px;
        max-width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
        position: relative;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
        from {
            transform: scale(0.95);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        cursor: pointer;
        color: #6b7280;
        font-size: 24px;
        z-index: 5;
    }

    .modal-close:hover {
        color: #111827;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #0d3b82;
        margin-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 12px;
        padding-right: 30px;
    }

    .modal-row {
        margin-bottom: 14px;
    }

    .modal-label {
        font-size: 11px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        display: block;
        margin-bottom: 4px;
    }

    .modal-value {
        font-size: 14px;
        color: #111827;
        font-weight: 500;
        line-height: 1.5;
    }


    /* ==========================================
       DOKUMEN PENDUKUNG
       ========================================== */

    .document-section {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .document-title {
        font-size: 13px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .document-empty {
        padding: 14px;
        background: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        text-align: center;
        color: #9ca3af;
        font-size: 12px;
    }

    .document-preview {
        margin-top: 10px;
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        background: #f9fafb;
    }

    .document-preview img {
        display: block;
        width: 100%;
        max-height: 300px;
        object-fit: contain;
        background: #f3f4f6;
    }

    .document-preview iframe {
        display: block;
        width: 100%;
        height: 300px;
        border: none;
    }

    .document-actions {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-document {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 7px;
        background: #0d3b82;
        color: white;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        border: none;
        cursor: pointer;
    }

    .btn-document:hover {
        background: #082a5c;
    }

    .btn-document.secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-document.secondary:hover {
        background: #e5e7eb;
    }


    /* ==========================================
       RESPONSIVE
       ========================================== */

    @media (max-width: 1000px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .modal-content {
            width: 100%;
        }
    }
</style>


<!-- ==========================================
     HEADER
     ========================================== -->

<div class="dashboard-header">
    <h2>Dashboard Mandor</h2>

    <p>
        Selamat datang kembali,
        {{ Auth::user()->name }}
    </p>
</div>


<!-- ==========================================
     4 CARDS
     ========================================== -->

<div class="stats-grid">

    <!-- Menunggu -->
    <div class="stat-card">

        <div class="stat-header">

            <div class="icon-box orange">

                <svg width="20"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>

                </svg>

            </div>

            <span class="badge-orange">
                Perlu tindakan
            </span>

        </div>

        <div class="stat-value">
            {{ $menunggu }}
        </div>

        <div class="stat-label">
            Menunggu Persetujuan
        </div>

    </div>


    <!-- Disetujui -->
    <div class="stat-card">

        <div class="stat-header">

            <div class="icon-box green">

                <svg width="20"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7">
                    </path>

                </svg>

            </div>

        </div>

        <div class="stat-value">
            {{ $disetujuiBulanIni }}
        </div>

        <div class="stat-label">
            Pengajuan Disetujui (Bulan Ini)
        </div>

    </div>


    <!-- Ditolak -->
    <div class="stat-card">

        <div class="stat-header">

            <div class="icon-box red">

                <svg width="20"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12">
                    </path>

                </svg>

            </div>

        </div>

        <div class="stat-value">
            {{ $ditolakTotal }}
        </div>

        <div class="stat-label">
            Pengajuan Ditolak (Total)
        </div>

    </div>


    <!-- Anggota -->
    <div class="stat-card">

        <div class="stat-header">

            <div class="icon-box blue">

                <svg width="20"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>

                </svg>

            </div>

        </div>

        <div class="stat-value">
            {{ $totalAnggota }}
        </div>

        <div class="stat-label">
            Total Anggota Tim
        </div>

    </div>

</div>


<!-- ==========================================
     TABEL PENGAJUAN
     ========================================== -->

<div class="table-card">

    <div class="table-header">

        <div>

            <h3>
                Pengajuan Cuti Terbaru
            </h3>

            <p>
                (Menunggu Persetujuan)
            </p>

        </div>

    </div>


    <table>

        <thead>

            <tr>

                <th>
                    Nama
                </th>

                <th>
                    Jabatan
                </th>

                <th>
                    Jenis Cuti
                </th>

                <th>
                    Tgl Pengajuan
                </th>

                <th>
                    Status
                </th>

                <th>
                    Aksi
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($pengajuanTerbaru as $cuti)

            <tr>

                <!-- Nama -->
                <td>
                    {{ $cuti->karyawan->user->name ?? 'Anonim' }}
                </td>


                <!-- Jabatan -->
                <td>
                    {{ $cuti->karyawan->jabatan ?? '-' }}
                </td>


                <!-- Jenis Cuti -->
                <td>
                    {{ $cuti->jenisCuti->nama ?? '-' }}
                </td>


                <!-- Tanggal Pengajuan -->
                <td>
                    {{ \Carbon\Carbon::parse($cuti->created_at)->translatedFormat('d M Y') }}
                </td>


                <!-- Status -->
                <td>

                    <span class="status-badge status-menunggu">
                        {{ $cuti->status ?? 'Menunggu' }}
                    </span>

                </td>


                <!-- Detail -->
                <td>

                    <button
                        type="button"
                        class="btn-detail"

                        onclick="openModal(
                            @js($cuti->karyawan->user->name ?? 'Anonim'),
                            @js($cuti->jenisCuti->nama ?? '-'),
                            @js(
                                \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M Y')
                                . ' - ' .
                                \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y')
                            ),
                            @js($cuti->alasan ?? ''),
                          @js(
                            $cuti->data_pendukung
                                ? asset('storage/' . $cuti->data_pendukung)
                                : ''
                        ),
                            @js($cuti->data_pendukung ?? '')
                        )">

                        Detail

                    </button>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    style="text-align:center; color:#9ca3af;">

                    Tidak ada pengajuan cuti baru.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>


<!-- ==========================================
     BOTTOM SECTION
     ========================================== -->

<div class="bottom-grid">

    <!-- Chart -->
    <div class="chart-card">

        <h3 style="font-size:16px; color:#1f2937; margin-bottom:10px;">
            Grafik Pengajuan Bulan Ini
        </h3>

        <div class="chart-container">

            <canvas id="pieChart"></canvas>

        </div>

    </div>


    <!-- Informasi -->
    <div class="info-card">

        <h3 style="font-size:16px; color:#1f2937;">
            Informasi
        </h3>

        <div class="info-box">

            <div class="info-icon">

                <svg width="24"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                    </path>

                </svg>

            </div>

            <div class="info-text">

                <h4>
                    Perhatian untuk Mandor
                </h4>

                <p>
                    Pastikan setiap pengajuan cuti ditindaklanjuti
                    secepatnya agar proses berjalan lancar.
                    Cek jadwal proyek sebelum menyetujui cuti
                    anggota tim untuk menghindari kekurangan
                    tenaga kerja lapangan.
                </p>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================
     MODAL DETAIL
     ========================================== -->

<div id="detailModal"
     class="modal">

    <div class="modal-content">

        <!-- Close -->
        <span class="modal-close"
              onclick="closeModal()">
            &times;
        </span>


        <h3 class="modal-title">
            Detail Pengajuan Cuti
        </h3>


        <!-- Nama -->
        <div class="modal-row">

            <span class="modal-label">
                Nama Karyawan
            </span>

            <div class="modal-value"
                 id="mod-nama">
            </div>

        </div>


        <!-- Jenis -->
        <div class="modal-row">

            <span class="modal-label">
                Jenis Cuti
            </span>

            <div class="modal-value"
                 id="mod-jenis">
            </div>

        </div>


        <!-- Tanggal -->
        <div class="modal-row">

            <span class="modal-label">
                Tanggal Pelaksanaan
            </span>

            <div class="modal-value"
                 id="mod-tanggal">
            </div>

        </div>


        <!-- Alasan -->
        <div class="modal-row">

            <span class="modal-label">
                Alasan Cuti
            </span>

            <div class="modal-value"
                 id="mod-alasan">
            </div>

        </div>


        <!-- ==========================================
             DOKUMEN PENDUKUNG
             ========================================== -->

        <div class="document-section">

            <div class="document-title">
                Dokumen Pendukung
            </div>


            <!-- Jika tidak ada dokumen -->
            <div id="documentEmpty"
                 class="document-empty">

                Tidak ada dokumen pendukung yang diunggah.

            </div>


            <!-- Preview dokumen -->
            <div id="documentPreview"
                 class="document-preview"
                 style="display:none;">

                <!-- Image -->
                <img id="documentImage"
                     src=""
                     alt="Dokumen Pendukung"
                     style="display:none;">


                <!-- PDF -->
                <iframe id="documentPdf"
                        src=""
                        style="display:none;">
                </iframe>

            </div>


            <!-- Tombol -->
            <div id="documentActions"
                 class="document-actions"
                 style="display:none;">

                <a id="documentOpen"
                   href="#"
                   target="_blank"
                   class="btn-document">

                    <svg width="16"
                         height="16"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4">
                        </path>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M14 4h6m0 0v6m0-6L10 14">
                        </path>

                    </svg>

                    Buka Dokumen

                </a>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================
     SCRIPTS
     ========================================== -->

<script>

    /* ==========================================
       MODAL DETAIL
       ========================================== */

    const modal = document.getElementById("detailModal");


    function openModal(
        nama,
        jenis,
        tanggal,
        alasan,
        documentUrl,
        documentPath
    ) {

        /*
        |--------------------------------------------------------------------------
        | Isi data utama
        |--------------------------------------------------------------------------
        */

        document.getElementById("mod-nama").innerText =
            nama || "Anonim";

        document.getElementById("mod-jenis").innerText =
            jenis || "-";

        document.getElementById("mod-tanggal").innerText =
            tanggal || "-";

        document.getElementById("mod-alasan").innerText =
            alasan || "Tidak ada alasan yang dicantumkan.";


        /*
        |--------------------------------------------------------------------------
        | Element dokumen
        |--------------------------------------------------------------------------
        */

        const documentEmpty =
            document.getElementById("documentEmpty");

        const documentPreview =
            document.getElementById("documentPreview");

        const documentImage =
            document.getElementById("documentImage");

        const documentPdf =
            document.getElementById("documentPdf");

        const documentActions =
            document.getElementById("documentActions");

        const documentOpen =
            document.getElementById("documentOpen");


        /*
        |--------------------------------------------------------------------------
        | Reset tampilan dokumen
        |--------------------------------------------------------------------------
        */

        documentEmpty.style.display = "none";

        documentPreview.style.display = "none";

        documentImage.style.display = "none";

        documentPdf.style.display = "none";

        documentActions.style.display = "none";

        documentImage.src = "";

        documentPdf.src = "";

        documentOpen.href = "#";


        /*
        |--------------------------------------------------------------------------
        | Jika tidak ada dokumen
        |--------------------------------------------------------------------------
        */

        if (!documentUrl) {

            documentEmpty.style.display = "block";

        }


        /*
        |--------------------------------------------------------------------------
        | Jika ada dokumen
        |--------------------------------------------------------------------------
        */

        else {

            documentPreview.style.display = "block";

            documentActions.style.display = "flex";

            documentOpen.href = documentUrl;


            /*
            |--------------------------------------------------------------------------
            | Ambil ekstensi file
            |--------------------------------------------------------------------------
            */

            const extension =
                documentPath
                    .split('.')
                    .pop()
                    .toLowerCase();


            /*
            |--------------------------------------------------------------------------
            | Preview gambar
            |--------------------------------------------------------------------------
            */

            if (
                extension === "jpg" ||
                extension === "jpeg" ||
                extension === "png"
            ) {

                documentImage.src = documentUrl;

                documentImage.style.display = "block";

            }


            /*
            |--------------------------------------------------------------------------
            | Preview PDF
            |--------------------------------------------------------------------------
            */

            else if (extension === "pdf") {

                documentPdf.src = documentUrl;

                documentPdf.style.display = "block";

            }


            /*
            |--------------------------------------------------------------------------
            | File lain
            |--------------------------------------------------------------------------
            */

            else {

                documentEmpty.innerText =
                    "Dokumen tersedia, tetapi tidak dapat ditampilkan sebagai preview.";

                documentEmpty.style.display = "block";

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Tampilkan modal
        |--------------------------------------------------------------------------
        */

        modal.style.display = "flex";

    }


    function closeModal() {

        modal.style.display = "none";

        /*
        |--------------------------------------------------------------------------
        | Hentikan PDF ketika modal ditutup
        |--------------------------------------------------------------------------
        */

        document.getElementById("documentPdf").src = "";

    }


    /*
    |--------------------------------------------------------------------------
    | Klik di luar modal
    |--------------------------------------------------------------------------
    */

    window.addEventListener("click", function(event) {

        if (event.target === modal) {

            closeModal();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | ESC untuk menutup modal
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", function(event) {

        if (event.key === "Escape") {

            closeModal();

        }

    });


    /* ==========================================
       CHART JS
       ========================================== */

    const ctx =
        document.getElementById('pieChart').getContext('2d');


    const pieChart =
        new Chart(ctx, {

            type: 'doughnut',

            data: {

                labels: [
                    'Disetujui',
                    'Ditolak',
                    'Menunggu'
                ],

                datasets: [{

                    data: [
                        {{ $grafik['disetujui'] }},
                        {{ $grafik['ditolak'] }},
                        {{ $grafik['menunggu'] }}
                    ],

                    backgroundColor: [
                        '#16a34a',
                        '#dc2626',
                        '#eab308'
                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '70%',

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            boxWidth: 8

                        }

                    }

                }

            }

        });

</script>

@endsection