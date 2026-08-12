<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SICUTI - Lupa Kata Sandi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-[#f8fafc] min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        
        <!-- Header: Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-[#0b3c7c] text-white mb-4 shadow-md">
                <!-- Ikon Gedung (Menyesuaikan logo di UI) -->
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-[#0b3c7c] tracking-wide">SICUTI</h1>
            <p class="text-sm text-gray-500 mt-1">Lupa Kata Sandi</p>
        </div>

        <!-- Kotak Form Putih -->
        <div class="bg-white p-8 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100">
            
            <p class="text-sm text-gray-600 text-center mb-6 leading-relaxed">
                Masukkan email Anda untuk menerima instruksi pemulihan kata sandi
            </p>

            <!-- Session Status (Untuk menampilkan pesan sukses jika email terkirim) -->
            <x-auth-session-status class="mb-4 text-center font-medium text-green-600" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Input Alamat Email -->
                <div class="mb-6">
                    <label for="email" class="block text-xs font-bold text-gray-800 mb-2 uppercase tracking-wide">Alamat Email</label>
                    <div class="relative">
                        <!-- Ikon Surat -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email anda"
                            class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm transition-colors">
                    </div>
                    <!-- Pesan Error Validasi -->
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Tombol Kirim -->
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#0b3c7c] hover:bg-[#082a5c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0b3c7c] transition-colors">
                    Kirim
                </button>
            </form>
        </div>

        <!-- Tautan Kembali ke Login -->
        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-semibold text-[#0b3c7c] hover:text-blue-900 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Login
            </a>
        </div>

    </div>

</body>
</html>