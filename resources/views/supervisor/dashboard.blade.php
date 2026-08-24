@extends('layouts.supervisor')
@section('title', 'Dashboard Supervisor')

@section('content')
    <style>
        .welcome-card { 
            background: #0B2447; 
            color: white; 
            padding: 32px; 
            border-radius: 12px; 
            margin-bottom: 24px; 
        }
        .welcome-card h2 { 
            margin: 0 0 8px 0; 
            font-size: 24px; 
        }
        .welcome-card p { 
            margin: 0; 
            font-size: 14px; 
            color: #d1d5db; 
        }
        
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 24px; margin-bottom: 24px; 
        }
        .stat-card { 
            background: #fff; 
            padding: 24px; 
            border-radius: 12px; 
            border: 1px solid #e5e7eb; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
        }
        
        .bottom-grid { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 24px; 
        }
        
        .table-card, .chart-card { 
            background: #fff; 
            padding: 24px; 
            border-radius: 12px; 
            border: 1px solid #e5e7eb; 
        }
        
        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-header-flex h3 {
            margin: 0;
            font-size: 16px;
            color: #111827;
        }

        .card-header-flex a {
            font-size: 13px;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            padding: 12px 16px;
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            border-bottom: 1px solid #e5e7eb;
        }

        .custom-table td {
            padding: 16px;
            font-size: 13px;
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
        }

        .badge-jenis {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .bg-blue {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .bg-red {
            background-color: #fef2f2;
            color: #ef4444;
        }

        .btn-detail {
            padding: 6px 16px;
            border-radius: 6px;
            background-color: #f3f4f6;
            color: #111827;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-detail:hover {
            background-color: #e5e7eb;
            color: #2563eb;
        }
    </style>

    <div class="welcome-card">
        <h2>Selamat Datang kembali, {{ explode(' ', $user->name)[0] }}</h2>
        <p>Ini adalah ringkasan pengajuan cuti tim Anda. Ada beberapa pengajuan yang membutuhkan perhatian dan persetujuan Anda hari ini.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span style="font-size: 12px; color: #6b7280; font-weight: 600;">MENUNGGU PERSETUJUAN</span>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
                <span style="font-size: 32px; font-weight: bold; color: #111827;">{{ $menunggu }}</span>
                <span style="font-size: 12px; background: #eff6ff; color: #2563eb; padding: 4px 8px; border-radius: 6px; font-weight: 600;">Butuh Aksi</span>
            </div>
        </div>
        <div class="stat-card">
            <span style="font-size: 12px; color: #6b7280; font-weight: 600;">TOTAL DISETUJUI</span>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
                <span style="font-size: 32px; font-weight: bold; color: #111827;">{{ $disetujui }}</span>
                <span style="font-size: 12px; color: #6b7280;">Bulan Ini</span>
            </div>
        </div>
        <div class="stat-card">
            <span style="font-size: 12px; color: #6b7280; font-weight: 600;">TOTAL DITOLAK</span>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 16px;">
                <span style="font-size: 32px; font-weight: bold; color: #111827;">{{ $ditolak }}</span>
                <span style="font-size: 12px; color: #6b7280;">Bulan Ini</span>
            </div>
        </div>
    </div>

    <div class="bottom-grid">
        <div class="table-card">
            <div class="card-header-flex">
                <h3>Antrean Persetujuan Terbaru</h3>
                <a href="{{ route('supervisor.pengajuan.index') }}">Lihat Semua</a>
            </div>
            
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antreanTerbaru as $antrean)
                    <tr>
                        <td style="display: flex; align-items: center; gap: 12px; font-weight: 600;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($antrean->karyawan->user->name ?? 'A') }}&background=random" style="width: 32px; height: 32px; border-radius: 50%;">
                            {{ $antrean->karyawan->user->name ?? '-' }}
                        </td>
                        <td style="color: #4b5563;">{{ $antrean->karyawan->jabatan ?? '-' }}</td>
                        <td>
                            <span class="badge-jenis {{ optional($antrean->jenisCuti)->nama == 'Cuti Sakit' ? 'bg-red' : 'bg-blue' }}">
                                {{ $antrean->jenisCuti->nama ?? '-' }}
                            </span>
                        </td>
                        <td style="color: #4b5563;">{{ \Carbon\Carbon::parse($antrean->tanggal_mulai)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('supervisor.pengajuan.show', $antrean->id) }}" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #6b7280; padding: 24px;">Tidak ada antrean persetujuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="chart-card">
            <h3 style="margin: 0 0 20px 0; font-size: 16px; color: #111827;">Distribusi Jenis Cuti</h3>
            <div style="position: relative; height: 250px; width: 100%;">
                <canvas id="cutiChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('cutiChart').getContext('2d');
            const dataLabels = @json($chartLabels ?? []);
            const dataValues = @json($chartData ?? []);
            
            const totalData = dataValues.reduce((acc, curr) => acc + Number(curr), 0);
            const hasData = totalData > 0;

            const finalLabels = hasData ? dataLabels : ['Belum Ada Data'];
            const finalValues = hasData ? dataValues : [1];
            const colors = hasData 
                ? ['#0B2447', '#2563eb', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'] 
                : ['#e5e7eb'];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: finalLabels,
                    datasets: [{
                        data: finalValues,
                        backgroundColor: colors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        });
    </script>
@endsection