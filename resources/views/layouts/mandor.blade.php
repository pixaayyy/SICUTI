<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard Mandor - SICUTI')
    </title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Figtree', Arial, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .app-container {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }


        /* =====================================================
           SIDEBAR
           ===================================================== */

        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #0d3b82;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-brand {
            padding: 28px 24px 30px;
        }

        .sidebar-brand h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .sidebar-brand p {
            color: #bfdbfe;
            font-size: 11px;
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

            padding: 12px 16px;
            margin-bottom: 8px;

            color: #dbeafe;
            text-decoration: none;

            border-radius: 8px;

            font-size: 14px;
            font-weight: 500;

            transition: all 0.2s;
        }

        .sidebar-menu:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu.active {
            background-color: #ffffff;
            color: #0d3b82;
            font-weight: 600;
        }

        .sidebar-menu svg {
            width: 20px;
            height: 20px;
        }


        /* =====================================================
           MAIN AREA
           ===================================================== */

        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }


        /* =====================================================
           TOPBAR
           ===================================================== */

        .topbar {
            min-height: 70px;

            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            justify-content: flex-end;
            align-items: center;

            padding: 0 32px;
            gap: 20px;

            position: relative;
            z-index: 1000;
        }


        /* =====================================================
           NOTIFIKASI
           ===================================================== */

        .notification-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .notification-btn {
            background: #f3f4f6;
            border: none;

            width: 40px;
            height: 40px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            color: #4b5563;

            position: relative;

            transition: 0.2s;

            text-decoration: none;
        }

        .notification-btn:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        .notification-badge {
            position: absolute;

            top: 4px;
            right: 4px;

            background-color: #ef4444;
            color: white;

            font-size: 10px;
            font-weight: bold;

            width: 16px;
            height: 16px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Dropdown Notifikasi */

        .notification-dropdown {
            display: none;

            position: absolute;

            right: 0;
            top: 50px;

            width: 320px;

            background: white;

            border-radius: 12px;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);

            border: 1px solid #e5e7eb;

            z-index: 1100;

            overflow: hidden;
        }

        .notification-header {
            padding: 12px 16px;

            border-bottom: 1px solid #f3f4f6;

            font-weight: 600;
            font-size: 13px;

            color: #1f2937;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-body {
            max-height: 250px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 12px 16px;

            border-bottom: 1px solid #f9fafb;

            font-size: 12px;

            color: #4b5563;

            text-decoration: none;

            display: block;
        }

        .notification-item:hover {
            background: #f8fafc;
        }

        .notification-item p {
            color: #111827;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .notification-empty {
            padding: 20px;

            text-align: center;

            color: #9ca3af;

            font-size: 12px;
        }


        /* =====================================================
           USER PROFILE
           ===================================================== */

        .user-profile-wrapper {
            position: relative;
        }

        .user-profile {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 6px 8px;

            border: none;

            background: transparent;

            border-radius: 8px;

            cursor: pointer;

            transition: background-color 0.2s;
        }

        .user-profile:hover {
            background-color: #f3f4f6;
        }

        .user-photo {
            width: 36px;
            height: 36px;

            background-color: #0d3b82;

            color: white;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;

            flex-shrink: 0;
        }

        .user-info {
            text-align: left;
        }

        .user-info .name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .user-info .role {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .profile-arrow {
            color: #6b7280;

            transition: transform 0.2s ease;
        }


        /* =====================================================
           DROPDOWN PROFILE
           HANYA BERISI LOGOUT
           ===================================================== */

        .profile-dropdown {
            display: none;

            position: absolute;

            right: 0;

            top: calc(100% + 8px);

            width: 140px;

            background-color: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);

            z-index: 1200;

            padding: 6px;
        }

        .profile-dropdown.show {
            display: block;
        }


        /* =====================================================
           LOGOUT
           ===================================================== */

        .logout-form {
            margin: 0;
        }

        .logout-button {
            width: 100%;

            display: flex;
            align-items: center;

            gap: 8px;

            padding: 9px 10px;

            border: none;

            background: transparent;

            border-radius: 7px;

            color: #dc2626;

            font-size: 13px;

            font-weight: 500;

            cursor: pointer;

            text-align: left;

            transition: 0.2s;
        }

        .logout-button:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }

        .logout-button svg {
            flex-shrink: 0;
        }


        /* =====================================================
           MAIN CONTENT
           ===================================================== */

        .main-content {
            flex: 1;

            padding: 32px;

            overflow-y: auto;
        }
    </style>
</head>


<body>

    <div class="app-container">


        <!-- =================================================
             SIDEBAR
             ================================================= -->

        <aside class="sidebar">

            <div class="sidebar-brand">

                <h1>SICUTI</h1>

                <p>
                    PT Trisaka Kopkarsentra Utama
                </p>

            </div>


            <nav class="sidebar-nav">


                <!-- Dashboard -->

                <a href="{{ route('mandor.dashboard') }}"
                   class="sidebar-menu {{ request()->routeIs('mandor.dashboard') ? 'active' : '' }}">

                    <svg fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>

                    </svg>

                    <span>
                        Dashboard
                    </span>

                </a>


                <!-- Pengajuan Cuti -->

                <a href="{{ route('mandor.pengajuan') }}"
                   class="sidebar-menu {{ request()->routeIs('mandor.pengajuan') ? 'active' : '' }}">

                    <svg fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a2 2 0 012 2V19a2 2 0 01-2 2z">
                        </path>

                    </svg>

                    <span>
                        Pengajuan Cuti
                    </span>

                </a>


                <!-- Anggota Tim -->

                <a href="{{ route('mandor.anggota') }}"
                   class="sidebar-menu {{ request()->routeIs('mandor.anggota') ? 'active' : '' }}">

                    <svg fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>

                    </svg>

                    <span>
                        Anggota Tim
                    </span>

                </a>


                <!-- Riwayat -->

                <a href="{{ route('mandor.riwayat') }}"
                   class="sidebar-menu {{ request()->routeIs('mandor.riwayat') ? 'active' : '' }}">

                    <svg fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>

                    </svg>

                    <span>
                        Riwayat Persetujuan
                    </span>

                </a>


                <!-- Profil -->

                <a href="{{ route('profile.edit') }}"
                   class="sidebar-menu {{ request()->routeIs('profile.*') ? 'active' : '' }}">

                    <svg fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>

                    </svg>

                    <span>
                        Profil Saya
                    </span>

                </a>

            </nav>

        </aside>


        <!-- =================================================
             MAIN AREA
             ================================================= -->

        <main class="main-area">


            <!-- =================================================
                 TOPBAR
                 ================================================= -->

            <header class="topbar">


                <!-- ==============================
                     NOTIFIKASI
                     ============================== -->

                <div class="notification-wrapper">

                    <button class="notification-btn"
                            onclick="toggleNotifications()">

                        <svg width="20"
                             height="20"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>

                        </svg>


                        <!-- Badge Notifikasi -->

                        @if(Auth::user()->unreadNotifications->count() > 0)

                            <span class="notification-badge">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>

                        @endif

                    </button>


                    <!-- Dropdown Notifikasi -->

                    <div id="notificationDropdown"
                         class="notification-dropdown">

                        <div class="notification-header">

                            <span>
                                Notifikasi Pengajuan Cuti
                            </span>

                            <span style="
                                font-size: 10px;
                                color: #2563eb;
                                cursor: pointer;
                            ">
                                Terbaru
                            </span>

                        </div>


                        <div class="notification-body">

                            @forelse(Auth::user()->unreadNotifications as $notification)

                                <a href="{{ route('mandor.pengajuan') }}"
                                   class="notification-item">

                                    <p>
                                        {{ $notification->data['pesan'] ?? 'Ada pengajuan cuti baru masuk.' }}
                                    </p>

                                    <span style="
                                        font-size: 10px;
                                        color: #9ca3af;
                                    ">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                </a>

                            @empty

                                <div class="notification-empty">
                                    Tidak ada notifikasi baru.
                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>


                <!-- ==============================
                     USER PROFILE
                     ============================== -->

                <div class="user-profile-wrapper">


                    <!-- Tombol Profil -->

                    <button type="button"
                            class="user-profile"
                            id="profileButton">

                        <div class="user-photo">

                            {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}

                        </div>


                        <div class="user-info">

                            <p class="name">
                                {{ Auth::user()->name ?? 'Nama Mandor' }}
                            </p>

                            <p class="role">
                                Mandor
                            </p>

                        </div>


                        <!-- Panah -->

                        <svg class="profile-arrow"
                             id="profileArrow"
                             width="16"
                             height="16"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 9l6 6 6-6">
                            </path>

                        </svg>

                    </button>


                    <!-- ==============================
                         DROPDOWN LOGOUT
                         HANYA BERISI LOGOUT
                         ============================== -->

                    <div class="profile-dropdown"
                         id="profileDropdown">

                        <form action="{{ route('logout') }}"
                              method="POST"
                              class="logout-form">

                            @csrf

                            <button type="submit"
                                    class="logout-button">

                                <svg width="17"
                                     height="17"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7">
                                    </path>

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 20H5a2 2 0 01-2-2V6a2 2 0 012-2h2">
                                    </path>

                                </svg>

                                <span>
                                    Logout
                                </span>

                            </button>

                        </form>

                    </div>

                </div>

            </header>


            <!-- =================================================
                 CONTENT
                 ================================================= -->

            <div class="main-content">

                @yield('content')

            </div>

        </main>

    </div>


    <!-- =====================================================
         JAVASCRIPT
         ===================================================== -->

    <script>

        /* =================================================
           NOTIFIKASI
           ================================================= */

        function toggleNotifications() {

            const dropdown =
                document.getElementById('notificationDropdown');

            dropdown.style.display =
                dropdown.style.display === 'block'
                    ? 'none'
                    : 'block';
        }


        /* =================================================
           PROFILE
           ================================================= */

        const profileButton =
            document.getElementById('profileButton');

        const profileDropdown =
            document.getElementById('profileDropdown');

        const profileArrow =
            document.getElementById('profileArrow');


        if (profileButton && profileDropdown) {

            profileButton.addEventListener('click', function(event) {

                event.stopPropagation();


                /*
                 * Tutup dropdown notifikasi
                 * ketika profile diklik
                 */

                const notificationDropdown =
                    document.getElementById('notificationDropdown');

                if (notificationDropdown) {
                    notificationDropdown.style.display = 'none';
                }


                /*
                 * Buka / tutup dropdown profile
                 */

                profileDropdown.classList.toggle('show');


                /*
                 * Putar panah
                 */

                if (profileDropdown.classList.contains('show')) {

                    profileArrow.style.transform =
                        'rotate(180deg)';

                } else {

                    profileArrow.style.transform =
                        'rotate(0deg)';

                }

            });

        }


        /* =================================================
           KLIK DI LUAR DROPDOWN
           ================================================= */

        window.addEventListener('click', function(event) {


            /* -------------------------------
               Tutup Notifikasi
               ------------------------------- */

            const notificationWrapper =
                document.querySelector('.notification-wrapper');

            const notificationDropdown =
                document.getElementById('notificationDropdown');


            if (
                notificationWrapper &&
                !notificationWrapper.contains(event.target)
            ) {

                notificationDropdown.style.display = 'none';

            }


            /* -------------------------------
               Tutup Profile
               ------------------------------- */

            const profileWrapper =
                document.querySelector('.user-profile-wrapper');


            if (
                profileWrapper &&
                !profileWrapper.contains(event.target)
            ) {

                profileDropdown.classList.remove('show');


                if (profileArrow) {

                    profileArrow.style.transform =
                        'rotate(0deg)';

                }

            }

        });

    </script>

</body>

</html>