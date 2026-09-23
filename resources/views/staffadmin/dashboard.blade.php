@extends('layouts.staffadmin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen font-sans">
    
    <!-- Header Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Ringkasan Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau metrik utama pengajuan cuti karyawan hari ini.</p>
    </div>

    <!-- Metrik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Card 1: Pengajuan Selesai -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-1 rounded-full">+12% dari bln lalu</span>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Pengajuan Selesai</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $total_selesai ?? 0 }}</h3>
        </div>

        <!-- Card 2: Karyawan Cuti -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-gray-50 text-gray-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Bulan ini</span>
            </div>
            <p class="text-sm text-gray-500 font-medium">Total Karyawan Cuti</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $karyawan_cuti ?? 0 }}</h3>
        </div>

        <!-- Card 3: Rata-rata Durasi -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-indigo-50 text-indigo-500 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Rata-rata Durasi Cuti</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $rata_durasi ?? 0 }} <span class="text-base font-normal text-gray-500">Hari</span></h3>
        </div>

    </div>

    <!-- Section Grafik Tren Cuti 6 Bulan Terakhir -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Tren Cuti 6 Bulan Terakhir</h2>
            <!-- Bagian href Lihat Detail dihapus dari sini -->
        </div>
        <div class="relative w-full h-80">
            <canvas id="trenCutiChart"></canvas>
        </div>
    </div>

</div>

<!-- Script Chart.js Dinamis dari Database -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('trenCutiChart').getContext('2d');
        
        const labels = {!! json_encode($chartLabels ?? ['Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar']) !!};
        const dataValues = {!! json_encode($chartData ?? [0, 0, 0, 0, 0, 0]) !!};
        
        const trenCutiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Cuti',
                    data: dataValues,
                    backgroundColor: function(context) {
                        const index = context.dataIndex;
                        const isLast = index === context.dataset.data.length - 1;
                        return isLast ? '#0a5c9e' : '#60a5fa';
                    },
                    borderRadius: 4,
                    barThickness: 'flex',
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + ' Cuti';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [4, 4],
                            color: '#e5e7eb'
                        },
                        ticks: {
                            font: {
                                family: 'Figtree'
                            },
                            precision: 0 
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Figtree'
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection