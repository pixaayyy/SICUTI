<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SICUTI')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-gray-900">

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="w-64 bg-[#0D3B82] text-white flex flex-col h-full shadow-lg z-10 flex-shrink-0">
            <!-- Brand Header -->
            <div class="p-6 pb-8">
                <h1 class="text-2xl font-bold tracking-wide">SICUTI</h1>
                <p class="text-xs text-blue-200 mt-1">PT Trisaka Kopkarsentra Utama</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 space-y-2">
                
                <!-- Menu Dashboard -->
                <a href="/karyawan/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('karyawan/dashboard') ? 'bg-white text-[#0D3B82] font-medium shadow-sm' : 'text-blue-100 hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Menu Ajukan Cuti -->
                <a href="/karyawan/ajukan-cuti" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('karyawan/ajukan-cuti') ? 'bg-white text-[#0D3B82] font-medium shadow-sm' : 'text-blue-100 hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajukan Cuti
                </a>

                <!-- Menu Status Pengajuan -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('karyawan/status-pengajuan') ? 'bg-white text-[#0D3B82] font-medium shadow-sm' : 'text-blue-100 hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Status Pengajuan
                </a>

                <!-- Menu Riwayat Cuti -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('karyawan/riwayat-cuti') ? 'bg-white text-[#0D3B82] font-medium shadow-sm' : 'text-blue-100 hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat Cuti
                </a>

                <!-- Menu Profil Saya -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('karyawan/profil') ? 'bg-white text-[#0D3B82] font-medium shadow-sm' : 'text-blue-100 hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>
            </nav>
        </aside>

        {{-- Main Area --}}
        <main class="flex-1 flex flex-col h-full overflow-y-auto">
            {{-- Topbar --}}
            <header class="flex justify-end items-center px-8 py-5">
                <div class="flex items-center gap-6">
                    <button class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>

                    @php
                        // Ambil data user & relasi karyawan secara aman dari sesi Auth
                        $currentUser = Auth::user();
                        $fotoKaryawan = $currentUser?->karyawan?->foto ?? null;
                    @endphp

                    <div class="flex items-center gap-3">
                        <img 
                            src="{{ $fotoKaryawan ? asset('storage/' . $fotoKaryawan) : 'https://ui-avatars.com/api/?name=' . urlencode($currentUser->name ?? 'User') . '&background=random' }}" 
                            alt="{{ $currentUser->name ?? 'User' }}" 
                            class="w-10 h-10 rounded-full object-cover border border-gray-200"
                        >
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $currentUser->name ?? 'User Name' }}</p>
                            <p class="text-xs text-gray-500">Karyawan</p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content Dynamic --}}
            <div class="px-8 pb-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>