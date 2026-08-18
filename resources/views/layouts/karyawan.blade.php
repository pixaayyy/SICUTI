<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', 'SICUTI')
    </title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
        }

        .app-container {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            background-color: #0d3b82;
            color: #ffffff;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
            z-index: 10;
        }

        .sidebar-brand {
            padding: 28px 24px 30px;
        }

        .sidebar-brand h1 {
            margin: 0;
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .sidebar-brand p {
            margin-top: 6px;
            color: #bfdbfe;
            font-size: 11px;
            line-height: 1.5;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 16px;
            overflow-y: auto;
        }

        .sidebar-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 7px;
            color: #dbeafe;
            text-decoration: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar-menu:hover {
            background-color: rgba(255, 255, 255, 0.10);
            color: #ffffff;
        }

        .sidebar-menu.active {
            background-color: #ffffff;
            color: #0d3b82;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .sidebar-menu svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .main-area {
            flex: 1;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            min-height: 78px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 32px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar-content {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .notification-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: none;
            background-color: transparent;
            color: #9ca3af;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.2s;
        }

        .notification-button:hover {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .notification-button svg {
            width: 22px;
            height: 22px;
        }

        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
        }

        .profile-button {
            display: flex;
            align-items: center;
            gap: 11px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .profile-button:hover {
            background-color: #f3f4f6;
        }

        .user-photo {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid #e5e7eb;
            background-color: #f3f4f6;
        }

        .profile-initial {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #0d3b82;
            background-color: #dbeafe;
        }

        .user-information {
            min-width: 110px;
            text-align: left;
        }

        .user-name {
            margin: 0;
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
        }

        .user-role {
            margin-top: 3px;
            color: #6b7280;
            font-size: 12px;
        }

        .profile-arrow {
            width: 16px;
            height: 16px;
            color: #6b7280;
        }

        /* Dropdown khusus menu Logout */
        .profile-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 160px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 100;
            overflow: hidden;
        }

        .user-profile:hover .profile-dropdown,
        .user-profile:focus-within .profile-dropdown {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 16px;
            font-size: 14px;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .logout-button {
            color: #dc2626;
        }

        .logout-button:hover {
            background-color: #fee2e2;
        }

        .main-content {
            flex: 1;
            padding: 28px 32px;
            overflow-y: auto;
            background-color: #f8fafc;
        }

        .sidebar-nav::-webkit-scrollbar,
        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track,
        .main-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.25);
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 10px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                padding: 22px;
            }

            .topbar {
                padding: 15px 22px;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-brand {
                padding: 22px 10px;
                text-align: center;
            }

            .sidebar-brand h1 {
                font-size: 17px;
            }

            .sidebar-brand p {
                display: none;
            }

            .sidebar-nav {
                padding: 0 8px;
            }

            .sidebar-menu {
                justify-content: center;
                padding: 12px 8px;
            }

            .sidebar-menu span {
                display: none;
            }

            .sidebar-menu svg {
                width: 21px;
                height: 21px;
            }

            .main-content {
                padding: 18px;
            }

            .topbar {
                min-height: 68px;
                padding: 12px 18px;
            }

            .user-information {
                display: none;
            }

            .topbar-content {
                gap: 8px;
            }
        }

        /* --- AWAL CSS NOTIFIKASI --- */
        .notification-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .notification-button {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            padding: 0;
            border: none;
            background: transparent;
            color: #9ca3af;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .notification-button:hover {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .notification-button svg {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 4px;
            background-color: #ef4444; /* Merah */
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 999px;
            border: 2px solid #ffffff;
        }

        .notification-dropdown {
            display: none; /* Disembunyikan secara default */
            position: absolute;
            top: calc(100% + 8px);
            right: -60px; /* Disesuaikan agar tidak terpotong layar */
            width: 320px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 100;
            overflow: hidden;
        }

        .notification-wrapper.active .notification-dropdown {
            display: block; /* Muncul ketika class active ditambahkan lewat JS */
        }

        .notif-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-header a {
            font-size: 12px;
            color: #0b3c7c;
            text-decoration: none;
            font-weight: 500;
        }

        .unread-label {
            font-size: 12px;
            color: #0b3c7c;
            font-weight: 500;
        }

        .notif-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .notif-item {
            display: block;
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            text-decoration: none;
            color: #374151;
            transition: background-color 0.2s;
        }

        .notif-item:hover {
            background-color: #f9fafb;
        }

        .notif-item.unread {
            background-color: #eff6ff; /* Biru muda untuk yang belum dibaca */
        }

        .notif-title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .notif-desc {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.4;
        }

        .notif-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 6px;
            display: block;
        }

        .notif-empty {
            padding: 24px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h1>SICUTI</h1>
                <p>PT Trisaka Kopkarsentra Utama</p>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('karyawan.dashboard') }}" class="sidebar-menu {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('karyawan.cuti.create') }}" class="sidebar-menu {{ request()->routeIs('karyawan.cuti.create') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajukan Cuti</span>
                </a>

                <a href="{{ route('karyawan.cuti.status') }}" class="sidebar-menu {{ request()->routeIs('karyawan.cuti.status') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2V7z"/>
                    </svg>
                    <span>Status Pengajuan</span>
                </a>

                <a href="{{ route('karyawan.cuti.index') }}" class="sidebar-menu {{ request()->routeIs('karyawan.cuti.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Riwayat Cuti</span>
                </a>

                <a href="{{ route('karyawan.profil') }}" class="sidebar-menu {{ request()->routeIs('karyawan.profil') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Profil Saya</span>
                </a>
            </nav>
        </aside>

        <main class="main-area">
            <header class="topbar">
                <div class="topbar-content">
                   {{-- NOTIFIKASI --}}
                    <div class="notification-wrapper" id="notif-wrapper">
                        @php
                            $riwayatCuti = collect();
                            $unreadCount = 0;

                            if (Auth::check() && Auth::user()->karyawan) {
                                $riwayatCuti = \App\Models\PengajuanCuti::where('karyawan_id', Auth::user()->karyawan->id)
                                    ->orderBy('updated_at', 'desc')
                                    ->take(5)
                                    ->get();
                                
                                // Opsional: Menghitung jumlah sebagai badge (misal kita hitung semua 5 terakhir)
                                $unreadCount = $riwayatCuti->count(); 
                            }
                        @endphp

                        <button type="button"
                                class="notification-button"
                                id="notification-button"
                                onclick="toggleNotif(event)"
                                aria-label="Notifikasi"
                                aria-expanded="false">
                            <svg fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>

                            @if($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount }}</span>
                            @endif
                        </button>

                        <div class="notification-dropdown" id="notification-dropdown">
                            <div class="notif-header">
                                <span>Status Pengajuan Terakhir</span>
                            </div>

                            <div class="notif-list">
                                @forelse($riwayatCuti as $cuti)
                                    <a href="{{ route('karyawan.cuti.status') }}" class="notif-item unread">
                                        <div class="notif-title">
                                            Pengajuan Cuti 
                                            @if(strtolower($cuti->status) == 'disetujui')
                                                <span style="color: #10b981;">Disetujui</span>
                                            @elseif(strtolower($cuti->status) == 'ditolak')
                                                <span style="color: #ef4444;">Ditolak</span>
                                            @else
                                                <span style="color: #f59e0b;">Diajukan</span>
                                            @endif
                                        </div>

                                        <div class="notif-desc">
                                            Cuti untuk tanggal {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }} berstatus <strong>{{ ucfirst($cuti->status) }}</strong>.
                                        </div>

                                        <span class="notif-time">
                                            {{ optional($cuti->updated_at ?? $cuti->created_at)->diffForHumans() ?? 'Baru saja' }}
                                        </span>
                                    </a>
                                @empty
                                    <div class="notif-empty">
                                        <svg style="width: 32px; height: 32px; margin: 0 auto 8px; color: #d1d5db;"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        Belum ada aktivitas pengajuan cuti.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @php
                        $currentUser = Auth::user();
                        $fotoKaryawan = $currentUser?->karyawan?->foto ?? null;
                    @endphp

                    <div class="user-profile">
                        <button type="button" class="profile-button">
                            @if($fotoKaryawan)
                                <img
                                    src="{{ asset('storage/' . $fotoKaryawan) }}"
                                    alt="{{ $currentUser->name ?? 'User' }}"
                                    class="user-photo"
                                >
                            @else
                                <div class="user-photo profile-initial">
                                    {{ strtoupper(substr($currentUser->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif

                            <div class="user-information">
                                <p class="user-name">
                                    {{ $currentUser->name ?? 'User Name' }}
                                </p>
                                <p class="user-role">Karyawan</p>
                            </div>

                            <svg class="profile-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown hanya berisi tombol Logout --}}
                        <div class="profile-dropdown">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-button">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="main-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>
<script>
        function toggleNotif(event) {
            event.stopPropagation();

            const wrapper = document.getElementById('notif-wrapper');
            const button = document.getElementById('notification-button');

            const isActive = wrapper.classList.toggle('active');
            button.setAttribute('aria-expanded', isActive ? 'true' : 'false');
        }

        document.addEventListener('click', function(event) {
            const wrapper = document.getElementById('notif-wrapper');
            const button = document.getElementById('notification-button');

            if (wrapper && !wrapper.contains(event.target)) {
                wrapper.classList.remove('active');

                if (button) {
                    button.setAttribute('aria-expanded', 'false');
                }
            }
        });
    </script>
</html>