@extends('layouts.staffadmin')

@section('title', 'Rekap Cuti Karyawan - SICUTI')

@section('content')
    
    <!-- HEADER & FILTER -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Rekap Cuti</h2>
            <p class="text-sm text-gray-400 mt-0.5">Laporan Bulanan/Tahunan Karyawan</p>
        </div>

        <div class="flex items-center gap-3">
            <select class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-4 py-2.5 focus:outline-none">
                <option>Tahun 2026</option>
            </select>
            <select class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg px-4 py-2.5 focus:outline-none">
                <option>Semua Departemen</option>
            </select>
            <a href="#" class="bg-[#0A2647] hover:bg-blue-900 text-white text-sm font-medium px-4 py-2.5 rounded-lg flex items-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                        <th class="px-6 py-4">Nama Karyawan</th>
                        <th class="px-6 py-4">Departemen</th>
                        <th class="px-6 py-4">Jatah Cuti</th>
                        <th class="px-6 py-4">Cuti Diambil</th>
                        <th class="px-6 py-4">Sisa Kuota</th>
                        <th class="px-6 py-4">Status Kuota</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($karyawans as $row)
                        @php
                            $sisa = $row->sisaCuti->sisa ?? 0;
                            $status = $sisa <= 3 ? 'Kritis' : 'Aman';
                            $statusClass = $status === 'Aman' ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600';
                            
                            $words = explode(' ', $row->name ?? 'Karyawan');
                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-[#0A2647] font-bold flex items-center justify-center text-sm shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $row->nama ?? $row->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $row->nik ?? 'EMP-000' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $row->departemen ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $row->sisaCuti->jatah ?? 12 }}</td>
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $row->sisaCuti->terpakai ?? 0 }}</td>
                            <td class="px-6 py-4 font-bold {{ $sisa <= 3 ? 'text-red-500' : 'text-blue-600' }}">
                                {{ $sisa }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="#" class="text-blue-600 hover:text-blue-800 inline-block">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-gray-500">Belum ada data rekap cuti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan data dari database</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 text-gray-400">&lt;</button>
                <button class="px-3 py-1 rounded bg-[#0A2647] text-white font-medium">1</button>
                <button class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 text-gray-600">2</button>
                <button class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 text-gray-600">3</button>
                <span class="px-2 text-gray-400">...</span>
                <button class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 text-gray-600">&gt;</button>
            </div>
        </div>
    </div>

@endsection