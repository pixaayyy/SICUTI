<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HR Dashboard') - SICUTI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #0b3b84;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
        }

        .sidebar-header h1 {
            margin: 0 0 4px 0;
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-header p {
            margin: 0;
            font-size: 11px;
            color: #d1d5db;
        }

        .sidebar-menu {
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .menu-item svg {
            margin-right: 12px;
            width: 20px;
            height: 20px;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .menu-item.active {
            background-color: #ffffff;
            color: #0b3b84;
            border-left: 4px solid #0b3b84;
            border-radius: 0 24px 24px 0;
            margin-right: 16px;
        }

        /* Main Content Styling */
        .main-wrapper {
            flex: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
        }

        /* Topbar Styling */
        .topbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 32px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 24px; /* Jarak notif dan profil */
        }

        .notification-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            position: relative;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        /* Wrapper Profil & Dropdown */
        .user-dropdown-wrapper {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer; /* Memberikan indikasi bisa diklik */
            padding: 4px 8px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .user-info:hover {
            background-color: #f3f4f6;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e5e7eb;
            object-fit: cover;
        }

        .user-text {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 180px;
            display: none; /* Sembunyikan default */
            flex-direction: column;
            z-index: 50;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: flex; /* Munculkan saat class 'show' aktif */
        }

        .dropdown-item {
            padding: 12px 16px;
            font-size: 14px;
            color: #374151;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .logout-btn {
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            color: #dc2626; /* Merah untuk logout */
            font-weight: 500;
        }

        .logout-btn:hover {
            background-color: #fef2f2;
        }

        /* Content Area */
        .content-area {
            padding: 32px;
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>SICUTI</h1>
            <p>PT Trisaka Kopkarsentra Utama</p>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('hr.dashboard') }}" class="menu-item {{ request()->routeIs('hr.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('hr.persetujuan') }}" class="menu-item {{ request()->routeIs(['hr.persetujuan', 'hr.pengajuan.show']) ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Persetujuan Cuti
            </a>
            <a href="{{ route('hr.riwayat') }}" class="menu-item {{ request()->routeIs('hr.riwayat') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Persetujuan
            </a>
            <a href="{{ route('hr.profil') }}" class="menu-item {{ request()->routeIs('hr.profil') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profil Saya
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <div class="user-profile">
                
                <!-- Tombol Notifikasi -->
                <button class="notification-btn">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    
                    <!-- Logic Notifikasi Aktif -->
                    @php
                        // Ganti 'PengajuanCuti' dengan nama Model yang sesuai di sistem Anda (misal: Cuti)
                        // dan sesuaikan string statusnya jika menggunakan huruf kapital ('Pending' atau 'Menunggu')
                        $adaNotif = \App\Models\PengajuanCuti::where('status', 'pending')->exists();
                    @endphp
                    @if($adaNotif)
                        <span class="notification-dot"></span>
                    @endif
                </button>

                <!-- Wrapper Profil dengan Dropdown -->
                <div class="user-dropdown-wrapper">
                    <!-- Area yang diklik untuk memunculkan dropdown -->
                    <div class="user-info" onclick="toggleProfileDropdown()">
                        @php
                            $user = Auth::user();
                            $fotoKaryawan = $user?->karyawan?->foto;
                        @endphp

                        @if($fotoKaryawan)
                            <img src="{{ asset('storage/' . $fotoKaryawan) }}" alt="Avatar" class="user-avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=random" alt="Avatar" class="user-avatar">
                        @endif
                        <div class="user-text">
                            <span class="user-name">{{ Auth::user()->name ?? 'User Name' }}</span>
                            <span class="user-role">HR</span>
                        </div>
                        <!-- Panah Dropdown Kecil -->
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #6b7280;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <!-- Menu Dropdown Logout -->
                    <div id="profileMenu" class="dropdown-menu">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Inject Konten View -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Script untuk Toggle Dropdown Logout -->
    <script>
        function toggleProfileDropdown() {
            document.getElementById('profileMenu').classList.toggle('show');
        }

        // Tutup dropdown jika user klik di luar area profil
        window.onclick = function(event) {
            if (!event.target.closest('.user-dropdown-wrapper')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>