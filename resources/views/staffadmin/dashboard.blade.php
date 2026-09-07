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
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $total_selesai }}</h3>
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
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $karyawan_cuti }}</h3>
        </div>

        <!-- Card 3: Rata-rata Durasi -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-indigo-50 text-indigo-500 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 font-medium">Rata-rata Durasi Cuti</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $rata_durasi }} <span class="text-base font-normal text-gray-500">Hari</span></h3>
        </div>

    </div>

    <!-- Area Chart (Statik Mockup CSS) -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-lg font-bold text-gray-800">Tren Cuti 6 Bulan Terakhir</h2>
            <a href="#" class="text-sm font-semibold text-blue-700 hover:underline">Lihat Detail &gt;</a>
        </div>
        
        <!-- CSS Grid untuk Diagram Batang -->
        <div class="h-64 flex items-end justify-between gap-6 relative px-2">
            <div class="absolute inset-0 flex flex-col justify-between border-b border-gray-200">
                <div class="border-t border-dashed border-gray-200 w-full"></div>
                <div class="border-t border-dashed border-gray-200 w-full"></div>
                <div class="border-t border-dashed border-gray-200 w-full"></div>
            </div>
            
            <!-- Bar Bulan -->
            <div class="w-full bg-[#0a5c9e] h-[50%] rounded-t-sm z-10 relative"><span class="absolute -bottom-6 w-full text-center text-xs text-gray-500">Okt</span></div>
            <div class="w-full bg-[#3983be] h-[35%] rounded-t-sm z-10 relative"><span class="absolute -bottom-6 w-full text-center text-xs text-gray-500">Nov</span></div>
            <div class="w-full bg-[#0a5c9e] h-[85%] rounded-t-sm z-10 relative"><span class="absolute -bottom-6 w-full text-center text-xs text-gray-500">Des</span></div>
            <div class="w-full bg-[#3983be] h-[45%] rounded-t-sm z-10 relative"><span class="absolute -bottom-6 w-full text-center text-xs text-gray-500">Jan</span></div>
            <div class="w-full bg-[#75a6c8] h-[30%] rounded-t-sm z-10 relative"><span class="absolute -bottom-6 w-full text-center text-xs text-gray-500">Feb</span></div>
            <div class="w-full bg-[#053d6e] h-[65%] rounded-t-sm z-10 relative">
                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-[10px] py-1 px-2 rounded">64 Cuti</div>
                <span class="absolute -bottom-6 w-full text-center text-xs font-bold text-gray-900">Mar</span>
            </div>
        </div>
    </div>
</div>
@endsection