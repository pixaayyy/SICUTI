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

    <!-- CSS Internal -->
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .forgot-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background-color: #0b3c7c;
            color: white;
            margin-bottom: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .forgot-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #0b3c7c;
            letter-spacing: 0.5px;
        }

        .forgot-header p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .forgot-card {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f3f4f6;
        }

        .forgot-card p.instruction {
            font-size: 14px;
            color: #4b5563;
            text-align: center;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            pointer-events: none;
            color: #9ca3af;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
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

        .back-link-container {
            margin-top: 32px;
            text-align: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            color: #0b3c7c;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #1e40af;
        }
    </style>
</head>
<body>
    
    <div class="forgot-wrapper">
        
        <div class="forgot-header">
            <div class="logo-box">
                <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h1>SICUTI</h1>
            <p>Lupa Kata Sandi</p>
        </div>

        <div class="forgot-card">
            
            <p class="instruction">
                Masukkan email Anda untuk menerima instruksi pemulihan kata sandi
            </p>

            <x-auth-session-status style="margin-bottom: 16px; text-align: center; font-weight: 500; color: #16a34a;" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email anda">
                    </div>
                    <x-input-error :messages="$errors->get('email')" style="margin-top: 8px;" />
                </div>

                <button type="submit" class="btn-submit">
                    Kirim
                </button>
            </form>
        </div>

        <div class="back-link-container">
            <a href="{{ route('login') }}" class="back-link">
                <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Login
            </a>
        </div>
    </div>

</body>
</html>