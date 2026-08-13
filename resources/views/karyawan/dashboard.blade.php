@extends('layouts.karyawan')

@section('title', 'Dashboard Cuti - SICUTI')

@section('content')

{{-- Greeting --}}
<div class="mb-6">
    <h2 class="text-[30px] font-semibold text-gray-800 m-0">Halo, {{ $user->name }}</h2>
    <p class="text-[14px] text-gray-500 mt-1">
        {{ $karyawan->jabatan ?? '-' }}
        |
        {{ $karyawan->departemen ?? '-' }}
    </p>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    {{-- Sisa Cuti --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 h-[140px] shadow-sm flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-50 text-[#0D3B82]">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full">Tersedia</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 mb-0.5">Sisa Cuti Tahunan</p>
            <span class="text-[30px] font-bold text-gray-900">
                {{ $sisaCutiHari }}
            </span>
            <span class="text-sm text-gray-500">Hari</span>
        </div>
    </div>

    {{-- Cuti Terpakai --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 h-[140px] shadow-sm flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-50 text-[#0D3B82]">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <div>
            <p class="text-sm text-gray-500 mb-0.5">Cuti Terpakai</p>
            <span class="text-[30px] font-bold text-gray-900">
                {{ $cutiTerpakai }}
            </span>
            <span class="text-sm text-gray-500">Hari</span>
        </div>
    </div>

    {{-- Cuti Ditolak --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 h-[140px] shadow-sm flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-red-50 text-red-600">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div>
            <p class="text-sm text-gray-500 mb-0.5">Cuti Ditolak</p>
            <span class="text-[30px] font-bold text-gray-900">
                {{ $cutiDitolak }}
            </span>
            <span class="text-sm text-gray-500">Pengajuan</span>
        </div>
    </div>

    {{-- Tahun --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 h-[140px] shadow-sm flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 text-gray-600">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div>
            <p class="text-sm text-gray-500 mb-0.5">Cuti Tahun Ini</p>
            <span class="text-[30px] font-bold text-gray-900">
                {{ $tahun }}
            </span>
        </div>
    </div>

</div>

{{-- Pengajuan Terbaru --}}
<div class="mt-6 bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
    
    <div class="flex justify-between items-center px-6 py-4 border-b border-slate-50">
        <h3 class="text-lg font-semibold text-gray-900 m-0">Pengajuan Terbaru</h3>
        <a href="#" class="text-[#0D3B82] text-sm font-medium hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">Jenis Cuti</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">Durasi</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-xs font-semibold text-gray-500 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengajuanTerbaru as $pengajuan)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $pengajuan->jenisCuti->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $pengajuan->durasi }} Hari
                        </td>
                        <td class="px-6 py-3">
                            @if($pengajuan->status === 'menunggu')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                                    Menunggu Persetujuan
                                </span>
                            @elseif($pengajuan->status === 'disetujui')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600">
                                    Disetujui
                                </span>
                            @elseif($pengajuan->status === 'ditolak')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">
                                    Ditolak
                                </span>
                            @elseif($pengajuan->status === 'dibatalkan')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    Dibatalkan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="#" class="text-[#0D3B82] hover:text-blue-900 transition flex justify-center">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">
                            Belum ada pengajuan cuti.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection