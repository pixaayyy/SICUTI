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
            gap: 24px;
        }

        /* AWAL STYLING NOTIFIKASI */
        .notification-wrapper {
            position: relative;
        }

        .notification-btn {
            background: #f3f4f6;
            border: none;
            color: #4b5563;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background-color 0.2s;
        }

        .notification-btn:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .notification-dot {
            position: absolute;
            top: 2px;
            right: 4px;
            width: 10px;
            height: 10px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .notif-menu {
            width: 320px;
            right: -20px;
            padding: 0;
        }

        .notif-header {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            font-size: 14px;
            color: #111827;
        }

        .notif-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .notif-item {
            display: flex;
            flex-direction: column;
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .notif-item:hover {
            background-color: #f9fafb;
        }

        .notif-item-title {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .notif-item-desc {
            font-size: 12px;
            color: #6b7280;
        }
        
        .notif-item-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 6px;
        }

        .notif-footer {
            padding: 10px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .notif-footer a {
            color: #2563eb;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
        }

        .notif-footer a:hover {
            text-decoration: underline;
        }
        /* AKHIR STYLING NOTIFIKASI */

        /* Wrapper Profil & Dropdown */
        .user-dropdown-wrapper {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
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

        /* Dropdown Menu Global Styling */
        .dropdown-menu {
            position: absolute;
            top: 110%;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            z-index: 50;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: flex;
        }

        /* Profile Dropdown Specific */
        .profile-menu {
            right: 0;
            width: 180px;
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
            color: #dc2626;
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
                
                <!-- BAGIAN NOTIFIKASI YANG BISA DIKLIK -->
                <div class="notification-wrapper">
                    <button class="notification-btn" onclick="toggleNotifDropdown()">
                        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        
                        @php
                            // Mengambil maksimal 5 cuti terbaru yang statusnya butuh persetujuan
                            $notifCuti = \App\Models\PengajuanCuti::whereIn('status', ['menunggu', 'menunggu_supervisor', 'menunggu_hr'])
                                            ->orderBy('created_at', 'desc')
                                            ->take(5)
                                            ->get();
                            $adaNotif = $notifCuti->count() > 0;
                        @endphp

                        @if($adaNotif)
                            <span class="notification-dot"></span>
                        @endif
                    </button>

                    <!-- Dropdown Menu Notifikasi -->
                    <div id="notifMenu" class="dropdown-menu notif-menu">
                        <div class="notif-header">Notifikasi Pengajuan Cuti</div>
                        <div class="notif-body">
                            @forelse($notifCuti as $cuti)
                                <a href="{{ route('hr.persetujuan') }}" class="notif-item">
                                    <span class="notif-item-title">{{ $cuti->karyawan->user->name ?? 'Karyawan' }}</span>
                                    <span class="notif-item-desc">Mengajukan cuti selama {{ $cuti->durasi }} hari. Menunggu persetujuan Anda.</span>
                                    <span class="notif-item-time">{{ $cuti->created_at->diffForHumans() }}</span>
                                </a>
                            @empty
                                <div style="padding: 20px; text-align: center; font-size: 12px; color: #6b7280;">
                                    Belum ada notifikasi baru.
                                </div>
                            @endforelse
                        </div>
                        @if($adaNotif)
                        <div class="notif-footer">
                            <a href="{{ route('hr.persetujuan') }}">Lihat Halaman Persetujuan</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Wrapper Profil dengan Dropdown -->
                <div class="user-dropdown-wrapper">
                    <!-- Area yang diklik untuk memunculkan dropdown profil -->
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
                    <div id="profileMenu" class="dropdown-menu profile-menu">
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

    <!-- Script untuk Toggle Dropdown -->
    <script>
        // Buka tutup notifikasi
        function toggleNotifDropdown() {
            document.getElementById('notifMenu').classList.toggle('show');
            // Jika notifikasi dibuka, pastikan dropdown profil tertutup
            document.getElementById('profileMenu').classList.remove('show');
        }

        // Buka tutup profil logout
        function toggleProfileDropdown() {
            document.getElementById('profileMenu').classList.toggle('show');
            // Jika profil dibuka, pastikan dropdown notifikasi tertutup
            document.getElementById('notifMenu').classList.remove('show');
        }

        // Tutup semua dropdown jika user klik di luar area menu
        window.onclick = function(event) {
            if (!event.target.closest('.user-dropdown-wrapper') && !event.target.closest('.notification-wrapper')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>