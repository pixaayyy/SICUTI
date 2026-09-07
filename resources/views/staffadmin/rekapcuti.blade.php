@extends('layouts.staffadmin')

@section('title', 'Rekap Cuti Karyawan - SICUTI')

@section('content')
    <style>
        /* Styling khusus untuk konten rekap cuti */
        .rekap-content {
            padding: 20px 30px;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
        }

        .page-title h2 {
            font-size: 22px;
            font-weight: 600;
            margin: 0 0 5px 0;
            color: #0a4b8f; /* Primary Blue */
        }

        .page-title p {
            font-size: 13px;
            color: #888;
            margin: 0;
        }

        .header-actions form {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .filter-select {
            padding: 9px 15px;
            border: 1px solid #eaedf2;
            border-radius: 6px;
            background-color: white;
            color: #333;
            font-size: 13px;
            outline: none;
            cursor: pointer;
        }

        .btn-export {
            background-color: #0a4b8f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .data-table th, .data-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #eaedf2;
        }

        .data-table th {
            font-size: 13px;
            font-weight: 600;
            color: #888;
            background-color: #fafbfc;
        }

        .data-table td {
            font-size: 14px;
            vertical-align: middle;
        }

        .emp-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .emp-avatar {
            width: 36px;
            height: 36px;
            background-color: #e6f0fa;
            color: #0a4b8f;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            font-weight: 600;
        }

        .emp-details {
            display: flex;
            flex-direction: column;
        }

        .emp-name { font-weight: 500; color: #333; }
        .emp-id { font-size: 12px; color: #888; margin-top: 3px; }

        .text-blue { color: #0056b3; font-weight: 600; }
        .text-red { color: #dc3545; font-weight: 600; }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        .badge-aman { background-color: #e6f0fa; color: #0056b3; }
        .badge-kritis { background-color: #ffeaea; color: #dc3545; }

        .action-btn {
            color: #0a4b8f;
            background: none;
            border: none;
            cursor: pointer;
        }

        .pagination-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            font-size: 13px;
            color: #888;
        }
    </style>

    <div class="rekap-content">
        <div class="page-header">
            <div class="page-title">
                <h2>Rekap Cuti</h2>
                <p>Laporan Bulanan/Tahunan Karyawan</p>
            </div>
            <div class="header-actions">
                <!-- Form Filter Otomatis saat diubah -->
                <form action="{{ route('staffadmin.rekapcuti') }}" method="GET">
                    <select name="tahun" class="filter-select" onchange="this.form.submit()">
                        <option value="{{ now()->year }}" {{ $tahun == now()->year ? 'selected' : '' }}>Tahun {{ now()->year }}</option>
                        <option value="{{ now()->year - 1 }}" {{ $tahun == now()->year - 1 ? 'selected' : '' }}>Tahun {{ now()->year - 1 }}</option>
                    </select>
                    
                    <select name="departemen" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Departemen</option>
                        @foreach($departemens as $dept)
                            <option value="{{ $dept }}" {{ $departemen == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                    
                    <a href="#" class="btn-export">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                        Export CSV
                    </a>
                </form>
            </div>
        </div>

        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Departemen</th>
                        <th style="text-align: center;">Jatah Cuti</th>
                        <th style="text-align: center;">Cuti Diambil</th>
                        <th style="text-align: center;">Sisa Kuota</th>
                        <th style="text-align: center;">Status Kuota</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $row)
                    @php
                        // Ambil data sisa cuti
                        $sisaCuti = $row->sisaCuti->first();

                        // Jatah dan pemakaian cuti
                        $jatahCuti = $sisaCuti->jatah ?? 12;
                        $cutiDiambil = $sisaCuti->terpakai ?? 0;

                        // Sisa cuti
                        $sisa = $sisaCuti->sisa ?? ($jatahCuti - $cutiDiambil);

                        // Status
                        if ($sisa <= 0) {
                            $status = 'Habis';
                            $statusClass = 'badge-habis';
                            $numberClass = 'text-red';
                        } elseif ($sisa <= 3) {
                            $status = 'Kritis';
                            $statusClass = 'badge-kritis';
                            $numberClass = 'text-orange';
                        } else {
                            $status = 'Aman';
                            $statusClass = 'badge-aman';
                            $numberClass = 'text-blue';
                        }

                        // Nama karyawan
                        $nama = $row->user->name
                            ?? $row->nama
                            ?? $row->name
                            ?? 'Karyawan';

                        // Inisial
                        $words = preg_split('/\s+/', trim($nama));

                        $initials = strtoupper(
                            substr($words[0] ?? 'K', 0, 1) .
                            substr($words[1] ?? '', 0, 1)
                        );
                    @endphp
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar">
                                    {{ $initials }}
                                </div>

                                <div class="emp-details">
                                    <span class="emp-name">
                                        {{ $nama }}
                                    </span>

                                    <span class="emp-id">
                                        {{ $row->nik ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $row->departemen ?? '-' }}
                        </td>

                        <td style="text-align: center;">
                            {{ $jatahCuti }}
                        </td>

                        <td style="text-align: center;">
                            {{ $cutiDiambil }}
                        </td>

                        <td
                            style="text-align: center;"
                            class="{{ $numberClass }}"
                        >
                            {{ $sisa }}
                        </td>

                        <td style="text-align: center;">
                            <span class="badge {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </td>

                        <td style="text-align: center;">
                            <button
                                type="button"
                                class="action-btn"
                                title="Lihat Detail"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                >
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5S17 4.5 12 4.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">Belum ada data karyawan.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination Section -->
            <div class="pagination-area">
                <div>
                    Menampilkan {{ $karyawans->firstItem() ?? 0 }} - {{ $karyawans->lastItem() ?? 0 }} dari {{ $karyawans->total() ?? 0 }} data
                </div>
                <div>
                    {{ $karyawans->links('pagination::simple-default') }}
                </div>
            </div>
        </div>
    </div>
@endsection