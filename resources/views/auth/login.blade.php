<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SICUTI - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
        }

        body {
            color: #111827;
            background-color: #f8fafc;
            overflow: hidden;
            height: 100vh;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        .left-panel {
            display: none;
            background-color: #0b3c7c;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
            color: white;
            position: relative;
        }

        .bg-overlay {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .bg-image {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0.4;
            mix-blend-mode: multiply;
        }

        .panel-content {
            position: relative;
            z-index: 10;
        }

        .brand-top {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .brand-center {
            text-align: center;
            margin-top: -80px;
        }

        .brand-center h1 {
            font-size: 70px;
            font-weight: bold;
            margin-bottom: 16px;
            letter-spacing: 1px;
        }

        .brand-center p {
            font-size: 18px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .brand-badge {
            margin-top: 32px;
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 16px;
        }

        .brand-badge p.title {
            font-size: 14px;
            font-weight: 500;
        }

        .brand-badge p.sub {
            font-size: 12px;
            color: #bfdbfe;
            margin-top: 4px;
        }

        .panel-footer {
            position: relative;
            z-index: 10;
            font-size: 12px;
            color: #bfdbfe;
        }

        .right-panel {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            padding: 24px;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-header h2 {
            font-size: 30px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 14px;
            color: #6b7280;
        }

        .form-card {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f3f4f6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            pointer-events: none;
            color: #9ca3af;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            font-size: 14px;
            color: #111827;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #0b3c7c;
            box-shadow: 0 0 0 3px rgba(11, 60, 124, 0.1);
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            font-size: 14px;
        }

        .checkbox-label {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            color: #4b5563;
            font-weight: 500;
        }

        .checkbox-label input {
            border-radius: 4px;
            border: 1px solid #d1d5db;
            color: #0b3c7c;
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }

        .forgot-link {
            font-weight: 600;
            color: #0b3c7c;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #1e40af;
        }

        .btn-submit {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            background-color: #0b3c7c;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #082a5c;
        }

        .right-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }

        .right-footer a {
            font-weight: 600;
            color: #0b3c7c;
            text-decoration: none;
        }

        .right-footer a:hover {
            text-decoration: underline;
        }

        @media (min-width: 1024px) {
            .left-panel {
                display: flex;
                width: 50%;
            }
            .right-panel {
                width: 50%;
                padding: 48px;
            }
        }
    </style>
</head>
<body>
    
    <div class="login-wrapper">        
        <div class="left-panel">
            
            <div class="bg-overlay">
                <div class="bg-image" style="background-image: url('{{ asset('images/foto perusahaan.jpeg') }}');"></div>
            </div>

            <div class="panel-content brand-top">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                PT Trisaka Kopkarsentra Utama
            </div>
            
            <div class="panel-content brand-center">
                <h1>SICUTI</h1>
                <p>Sistem Informasi Pengajuan Cuti Pegawai</p>
                <div class="brand-badge">
                    <p class="title">PT. TRISAKA KOPKARSENTRA UTAMA</p>
                    <p class="sub">SISTEM APLIKASI CUTI ONLINE</p>
                </div>
            </div>
            
            <div class="panel-footer">
                © 2026 Politeknik Negeri Cilacap
            </div>
        </div>

        <div class="right-panel">
            <div class="form-container">
                
                <div class="form-header">
                    <h2>Selamat Datang</h2>
                    <p>Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status style="margin-bottom: 16px;" :status="session('status')" />

                <div class="form-card">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="login">Email atau Username</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input id="login" class="form-input" type="text" name="login" value="{{ old('login') }}" required autofocus placeholder="Masukkan email atau username">
                            </div>
                            <x-input-error :messages="$errors->get('login')" style="margin-top: 8px;" />
                        </div>

                        <div class="form-group" style="margin-bottom: 24px;">
                            <label for="password">Kata Sandi</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input id="password" class="form-input" style="padding-right: 40px;" type="password" name="password" required placeholder="Masukkan kata sandi">
                            <div id="togglePassword" style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); cursor: pointer; color: #9ca3af; z-index: 10;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" style="margin-top: 8px;" />
                        </div>

                        <div class="form-actions">
                            <label for="remember_me" class="checkbox-label">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>Ingat Saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    Lupa Kata Sandi?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn-submit">
                            Masuk
                        </button>
                    </form>
                </div>

                <div class="right-footer">
                    Butuh bantuan akses? <a href="#">Hubungi HR Admin</a>
                </div>

            </div>
        </div>
    </div>
</body>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            this.style.color = type === 'password' ? '#9ca3af' : '#0b3c7c';
        });
    </script>
</body>
</html>
</html>