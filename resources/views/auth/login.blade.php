<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SICUTI - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased overflow-hidden">
    
    <div class="min-h-screen flex">
        
        <!-- Sisi Kiri: Branding & Gambar Background -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#0b3c7c] flex-col justify-between p-10 text-white">
            
            <!-- Overlay Background Gambar -->
            <div class="absolute inset-0 z-0">
                <!-- Menggunakan inline style dan asset() agar spasi pada nama file terdeteksi dengan aman -->
                <div class="w-full h-full bg-cover bg-center opacity-40 mix-blend-multiply" 
                     style="background-image: url('{{ asset('images/foto perusahaan.jpeg') }}');">
                </div>
            </div>

            <!-- Konten Sisi Kiri -->
            <div class="relative z-10 flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                PT Trisaka Kopkarsentra Utama
            </div>
            
            <div class="relative z-10 text-center -mt-20">
                <h1 class="text-7xl font-bold mb-4 tracking-wide">SICUTI</h1>
                <p class="text-lg font-light tracking-wide">Sistem Informasi Pengajuan Cuti Pegawai</p>
                <div class="mt-8 inline-block bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-4">
                    <p class="text-sm font-medium">PT. TRISAKA KOPKARSENTRA UTAMA</p>
                    <p class="text-xs text-blue-200 mt-1">SISTEM APLIKASI CUTI ONLINE</p>
                </div>
            </div>
            
            <div class="relative z-10 text-xs text-blue-200">
                © 2024 Politeknik Negeri Cilacap
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-[#f8fafc] p-6 sm:p-12">
            <div class="w-full max-w-md">
                
                <!-- Header Form -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-sm text-gray-500">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Kotak Form Putih -->
                <div class="bg-white p-8 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email atau Username -->
                        <div class="mb-5">
                            <label for="login" class="block text-sm font-semibold text-gray-700 mb-2">Email atau Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus placeholder="Masukkan email atau username"
                                    class="pl-11 block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm transition-colors">
                            </div>
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- Kata Sandi -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input id="password" type="password" name="password" required placeholder="Masukkan kata sandi"
                                    class="pl-11 pr-10 block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm transition-colors">
                                <!-- Ikon Eye -->
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center cursor-pointer">
                                    <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Ingat Saya & Lupa Kata Sandi -->
                        <div class="flex items-center justify-between mb-8">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-[#0b3c7c] shadow-sm focus:ring-[#0b3c7c]">
                                <span class="ml-2 text-sm text-gray-600 font-medium">Ingat Saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-[#0b3c7c] hover:text-blue-900" href="{{ route('password.request') }}">
                                    Lupa Kata Sandi?
                                </a>
                            @endif
                        </div>

                        <!-- Tombol Masuk -->
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#0b3c7c] hover:bg-[#082a5c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0b3c7c] transition-colors">
                            Masuk
                        </button>
                    </form>
                </div>

                <!-- Footer Kanan -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    Butuh bantuan akses? <a href="#" class="font-semibold text-[#0b3c7c] hover:underline">Hubungi HR Admin</a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>