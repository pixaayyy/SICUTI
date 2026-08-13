<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SICUTI - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 flex h-screen overflow-hidden">
    
    <!-- SIDEBAR EXTERNAL -->
    <aside class="w-64 bg-[#0b3c7c] text-white flex flex-col shadow-lg z-20">
        <div class="p-6 border-b border-blue-800">
            <h1 class="text-2xl font-bold tracking-wide">SICUTI</h1>
            <p class="text-xs text-blue-200 mt-1">PT Trisaka Kopkarsentra Utama</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <!-- Menu Aktif (Contoh: Ajukan Cuti) -->
            <a href="{{ route('karyawan.cuti.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white text-[#0b3c7c] font-bold shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Cuti
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Status Pengajuan
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Cuti
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- TOPBAR EXTERNAL -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shadow-sm z-10">
            <div></div> <!-- Spacer -->
            <div class="flex items-center gap-6">
                <!-- Ikon Notifikasi -->
                <button class="text-gray-400 hover:text-gray-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                <!-- Profil User -->
                <div class="flex items-center gap-3 border-l pl-6 border-gray-200">
                    <div class="h-9 w-9 rounded-full bg-gray-300 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=0D8ABC&color=fff" alt="Profile">
                    </div>
                    <div class="text-sm">
                        <p class="font-bold text-gray-700 leading-none">{{ Auth::user()->name ?? 'User Name' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Karyawan</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- KONTEN DINAMIS (Akan diisi oleh view masing-masing) -->
        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            @yield('content')
        </main>
    </div>

</body>
</html>