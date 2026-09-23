<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SICUTI - Reset Kata Sandi</title>

    <!-- Fonts -->
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .reset-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .reset-header {
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

        .reset-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #0b3c7c;
            letter-spacing: 0.5px;
        }

        .reset-header p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .reset-card {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f3f4f6;
        }

        .reset-card p.instruction {
            font-size: 14px;
            color: #4b5563;
            text-align: center;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
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
            margin-top: 8px;
        }

        .btn-submit:hover {
            background-color: #082a5c;
        }

        .error-message {
            margin-top: 8px;
            font-size: 12px;
            color: #dc2626;
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

    <div class="reset-wrapper">

        <!-- Header -->
        <div class="reset-header">
            <div class="logo-box">
                <!-- Logo yang sama seperti halaman Lupa Password -->
                <svg
                    style="width: 28px; height: 28px;"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                    ></path>
                </svg>
            </div>

            <h1>SICUTI</h1>
            <p>Reset Kata Sandi</p>
        </div>

        <!-- Card -->
        <div class="reset-card">

            <p class="instruction">
                Silakan masukkan kata sandi baru untuk akun Anda.
            </p>

            @if ($errors->any())
                <div style="margin-bottom: 20px;">
                    @foreach ($errors->all() as $error)
                        <div class="error-message">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token -->
                <input
                    type="hidden"
                    name="token"
                    value="{{ $request->route('token') }}"
                >

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Alamat Email</label>

                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg
                                style="width: 20px; height: 20px;"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                ></path>
                            </svg>
                        </div>

                        <input
                            id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email anda"
                        >
                    </div>

                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Kata Sandi Baru</label>

                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg
                                style="width: 20px; height: 20px;"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v2h8z"
                                ></path>
                            </svg>
                        </div>

                        <input
                            id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Masukkan kata sandi baru"
                        >
                    </div>

                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>

                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg
                                style="width: 20px; height: 20px;"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 3c-2.755 0-5.312.936-7.348 2.507l-.122.093A11.953 11.953 0 004.012 12c0 2.755.936 5.312 2.507 7.348l.093.122A11.953 11.953 0 0012 21c2.755 0 5.312-.936 7.348-2.507l.122-.093A11.953 11.953 0 0020.988 12c0-2.755-.936-5.312-2.507-7.348l-.093-.122z"
                                ></path>
                            </svg>
                        </div>

                        <input
                            id="password_confirmation"
                            class="form-input"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi kata sandi baru"
                        >
                    </div>

                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    Reset Kata Sandi
                </button>
            </form>
        </div>

        <!-- Back to Login -->
        <div class="back-link-container">
            <a href="{{ route('login') }}" class="back-link">

                <svg
                    style="width: 16px; height: 16px; margin-right: 8px;"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m0 7h18"
                    ></path>
                </svg>

                Kembali ke Login
            </a>
        </div>

    </div>

</body>
</html>