@extends('layouts.staffadmin')

@section('title', 'Rekap Cuti Karyawan - SICUTI')

@section('content')
    <style>
        .rekap-content { padding: 20px 30px; font-family: 'Inter', sans-serif; color: #333; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-title h2 { font-size: 22px; font-weight: 600; margin: 0 0 5px 0; color: #0a4b8f; }
        .page-title p { font-size: 13px; color: #888; margin: 0; }
        .btn-export { background-color: #0a4b8f; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        
        .filter-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px 24px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .filter-card-header { display: flex; align-items: center; gap: 10px; font-size: 16px; font-weight: 600; color: #1e293b; padding-bottom: 14px; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; }
        .filter-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
        .filter-field { display: flex; flex-direction: column; gap: 6px; }
        .filter-field label { font-size: 12px; font-weight: 600; color: #1e293b; }
        
        .select-with-icon { position: relative; display: flex; align-items: center; }
        .select-with-icon select { width: 100%; height: 40px; padding: 0 38px 0 14px; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #334155; outline: none; appearance: none; box-sizing: border-box; }
        .select-with-icon select:focus { border-color: #0a4b8f; background-color: #ffffff; }
        .select-with-icon::after { content: ""; position: absolute; right: 14px; width: 7px; height: 7px; border-right: 2px solid #64748b; border-bottom: 2px solid #64748b; transform: rotate(45deg); pointer-events: none; margin-top: -3px; }

        .filter-actions-row { display: flex; justify-content: flex-end; align-items: center; gap: 10px; }
        .btn-filter-reset { display: inline-flex; align-items: center; justify-content: center; height: 38px; padding: 0 22px; background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: 500; color: #334155; text-decoration: none; cursor: pointer; }
        .btn-filter-submit { display: inline-flex; align-items: center; justify-content: center; height: 38px; padding: 0 22px; background-color: #072e54; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; color: #ffffff; cursor: pointer; }

        .card { background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow: hidden; border: 1px solid #e2e8f0; }
        .data-table { width: 100%; border-collapse: collapse; text-align: left; }
        .data-table th, .data-table td { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; }
        .data-table th { font-size: 13px; font-weight: 600; color: #64748b; background-color: #f8fafc; }
        .emp-cell { display: flex; align-items: center; gap: 12px; }
        .emp-avatar { width: 36px; height: 36px; background-color: #e0f2fe; color: #0a4b8f; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 13px; font-weight: 600; }
        .emp-name { font-weight: 500; color: #1e293b; }
        .emp-id { font-size: 12px; color: #64748b; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-aman { background-color: #e0f2fe; color: #0369a1; }
        .badge-kritis { background-color: #fef3c7; color: #b45309; }
        .badge-habis { background-color: #fee2e2; color: #b91c1c; }
        .pagination-area { display: flex; justify-content: space-between; align-items: center; padding: 20px; font-size: 13px; color: #64748b; }

        /* Style Baris Detail dengan Nuansa Merah Lembut */
        .detail-row-container { background-color: #fef2f2; display: none; border-left: 4px solid #ef4444; }
        .detail-table-wrapper { padding: 15px 30px; }
        .sub-table { width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden; border: 1px solid #fca5a5; }
        .sub-table th, .sub-table td { padding: 10px 15px; font-size: 12px; border-bottom: 1px solid #fee2e2; text-align: left; }
        .sub-table th { background: #fee2e2; color: #991b1b; font-weight: 600; }
    </style>

    <div class="rekap-content">
        <div class="page-header">
            <div class="page-title">
                <h2>Rekap Cuti</h2>
                <p>Laporan Bulanan/Tahunan Karyawan</p>
            </div>
            <div>
                <a href="{{ route('staffadmin.rekapcuti.export', request()->all()) }}" class="btn-export">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                    Export CSV
                </a>
            </div>
        </div>

        <div class="filter-card">
            <div class="filter-card-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0a4b8f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                <span>Filter Laporan</span>
            </div>
            
            <form action="{{ route('staffadmin.rekapcuti') }}" method="GET">
                <div class="filter-row">
                    <div class="filter-field">
                        <label>Bulan Rekap</label>
                        <div class="select-with-icon">
                            <select name="bulan">
                                <option value="">Semua Bulan</option>
                                @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $key => $val)
                                    <option value="{{ $key }}" {{ ($bulan ?? '') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-field">
                        <label>Jenis Cuti</label>
                        <div class="select-with-icon">
                            <select name="jenis_cuti">
                                <option value="">Semua Jenis</option>
                                @foreach($listJenisCuti as $jc)
                                    <option value="{{ $jc->id }}" {{ ($jenisCutiId ?? '') == $jc->id ? 'selected' : '' }}>
                                        {{ $jc->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-field">
                        <label>Departemen</label>
                        <div class="select-with-icon">
                            <select name="departemen">
                                <option value="">Semua Departemen</option>
                                @foreach($departemens as $dept)
                                    <option value="{{ $dept }}" {{ ($departemen ?? '') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-field">
                        <label>Status</label>
                        <div class="select-with-icon">
                            <select name="status">
                                <option value="">Semua Status</option>
                                <option value="Aman" {{ ($status ?? '') == 'Aman' ? 'selected' : '' }}>Aman</option>
                                <option value="Kritis" {{ ($status ?? '') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                                <option value="Habis" {{ ($status ?? '') == 'Habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="filter-actions-row">
                    <a href="{{ route('staffadmin.rekapcuti') }}" class="btn-filter-reset">Reset</a>
                    <button type="submit" class="btn-filter-submit">Terapkan Filter</button>
                </div>
            </form>
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
                        $sisaCuti = $row->sisaCuti?->first() ?? $row->sisaCuti;
                        $jatahCuti = $sisaCuti?->jatah ?? 12;
                        $cutiDiambil = $sisaCuti?->terpakai ?? $row->pengajuanCuti->sum('durasi');
                        $sisa = $sisaCuti?->sisa ?? ($jatahCuti - $cutiDiambil);

                        if ($sisa <= 0) {
                            $statusText = 'Habis';
                            $statusClass = 'badge-habis';
                        } elseif ($sisa <= 3) {
                            $statusText = 'Kritis';
                            $statusClass = 'badge-kritis';
                        } else {
                            $statusText = 'Aman';
                            $statusClass = 'badge-aman';
                        }

                        $nama = $row->user->name ?? $row->nama ?? $row->name ?? 'Karyawan';
                        $words = preg_split('/\s+/', trim($nama));
                        $initials = strtoupper(substr($words[0] ?? 'K', 0, 1) . substr($words[1] ?? '', 0, 1));
                    @endphp
                    <tr>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar">{{ $initials }}</div>
                                <div>
                                    <div class="emp-name">{{ $nama }}</div>
                                    <div class="emp-id">{{ $row->nik ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $row->departemen ?? '-' }}</td>
                        <td style="text-align: center;">{{ $jatahCuti }}</td>
                        <td style="text-align: center;">{{ $cutiDiambil }}</td>
                        <td style="text-align: center; font-weight: 600;">{{ $sisa }}</td>
                        <td style="text-align: center;">
                            <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td style="text-align: center;">
                            {{-- Simpan ID di data-id agar tidak error di editor --}}
                            <button type="button" class="btn-toggle-detail" data-id="{{ $row->id }}" style="color: #0a4b8f; background: none; border: none; cursor: pointer;" title="Lihat/Sembunyikan Detail Cuti">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5S17 4.5 12 4.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            </button>
                        </td>
                    </tr>

                    {{-- Baris Detail Cuti (Tampil di bawah baris utama saat diklik) --}}
                    <tr id="detail-row-{{ $row->id }}" class="detail-row-container">
                        <td colspan="7">
                            <div class="detail-table-wrapper">
                                @if($row->pengajuanCuti->count() > 0)
                                    <table class="sub-table">
                                        <thead>
                                            <tr>
                                                <th>Jenis Cuti</th>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($row->pengajuanCuti as $cuti)
                                            <tr>
                                                <td>{{ $cuti->jenisCuti->nama ?? '-' }}</td>
                                                <td>{{ $cuti->tanggal_mulai ? $cuti->tanggal_mulai->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $cuti->tanggal_selesai ? $cuti->tanggal_selesai->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $cuti->durasi }} Hari</td>
                                                <td>{{ ucfirst($cuti->status) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div style="text-align: center; color: #991b1b; padding: 10px; font-size: 12px; font-weight: 500;">
                                        Tidak ada riwayat cuti yang tercatat pada periode ini.
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #64748b;">Belum ada data karyawan yang sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-area">
                <div>Menampilkan {{ $karyawans->firstItem() ?? 0 }} - {{ $karyawans->lastItem() ?? 0 }} dari {{ $karyawans->total() ?? 0 }} data</div>
                <div>{{ $karyawans->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btn-toggle-detail');
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const row = document.getElementById('detail-row-' + id);
                    if (row) {
                        if (row.style.display === 'table-row') {
                            row.style.display = 'none';
                        } else {
                            row.style.display = 'table-row';
                        }
                    }
                });
            });
        });
    </script>
@endsection