@extends('layouts.karyawan')

@section('title', 'Profil Saya')

@section('content')
<!-- CSS Internal Khusus Halaman Profil -->
<style>
    /* Reset & Variabel Global Profil */
    .profile-wrapper {
        font-family: 'Figtree', sans-serif;
        color: #111827;
        width: 100%;
        padding-bottom: 40px;
    }
    .profile-header { margin-bottom: 24px; }
    .profile-title {
        font-size: 28px;
        font-weight: 700;
        color: #0b3c7c;
        margin-bottom: 4px;
    }
    .profile-subtitle { font-size: 14px; color: #6b7280; }
    .profile-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        align-items: flex-start;
    }
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        border: 1px solid #f3f4f6;
        padding: 32px;
    }
    .card-header {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 16px;
        margin-bottom: 24px;
    }
    .card-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #0b3c7c;
    }
    .card-personal {
        flex: 1 1 60%;
        min-width: 300px;
    }
    .personal-content {
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
    }
    .photo-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f3f4f6;
    }
    .btn-outline {
        font-size: 12px;
        font-weight: 600;
        color: #0b3c7c;
        background-color: #ffffff;
        border: 1px solid #0b3c7c;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        background-color: #0b3c7c;
        color: #ffffff;
    }
    .details-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px 24px;
    }
    .detail-item label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 6px;
    }
    .detail-item p {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        padding-top: 6px;
    }
    .detail-item p.highlight {
        color: #0b3c7c;
        font-weight: 700;
    }
    .card-footer {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .card-password {
        flex: 1 1 30%;
        min-width: 300px;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #4b5563;
        margin-bottom: 8px;
    }
    .input-wrapper {
        position: relative;
    }
    .form-input {
        width: 100%;
        padding: 10px 40px 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        background-color: #ffffff;
        color: #111827;
        transition: border-color 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #0b3c7c;
        box-shadow: 0 0 0 3px rgba(11, 60, 124, 0.1);
    }
    .password-toggle-icon {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #9ca3af;
        display: flex;
        align-items: center;
    }
    .password-toggle-icon:hover {
        color: #4b5563;
    }
    .btn-primary {
        background-color: #0b3c7c;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #082a5c;
    }
    .btn-full { width: 100%; }
    
    /* Styling Alert Sukses dengan Transisi Animasi */
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 24px;
        font-weight: 500;
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        opacity: 1;
    }
    .alert-hidden {
        opacity: 0;
        transform: translateY(-10px);
        pointer-events: none;
    }

    .text-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
    .d-none { display: none !important; }
</style>

<div class="profile-wrapper">
    <div class="profile-header">
        <h1 class="profile-title">Profil Saya</h1>
        <p class="profile-subtitle">Kelola informasi pribadi dan keamanan akun Anda.</p>
    </div>

    <!-- Alert Sukses dengan ID agar bisa dikontrol JavaScript -->
    @if (session('status') === 'password-updated')
        <div id="success-alert" class="alert-success">Kata sandi Anda berhasil diperbarui!</div>
    @endif
    @if (session('status') === 'profile-updated')
        <div id="success-alert" class="alert-success">Informasi profil Anda berhasil diperbarui!</div>
    @endif

    <div class="profile-grid">
        
        <!-- KOLOM KIRI: Informasi Pribadi -->
        @php
            $user = Auth::user();
            $karyawan = $user->karyawan;
        @endphp
        
        <form method="post" action="{{ route('karyawan.profil.update') }}" class="card card-personal" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="card-header">
                <h3>Informasi Pribadi</h3>
            </div>
            
            <div class="personal-content">
                <!-- Foto Profil -->
                <div class="photo-section">
                    <img id="photo-preview" 
                         src="{{ $karyawan && $karyawan->foto ? asset('storage/' . $karyawan->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0b3c7c&color=fff' }}" 
                         alt="Foto Profil" class="profile-photo">
                    
                    <label for="foto" id="btn-upload-foto" class="btn-outline d-none">
                        Pilih Foto Baru
                    </label>
                    <input type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg" style="display: none;" onchange="previewImage(event)">
                    <x-input-error :messages="$errors->get('foto')" class="text-error" />
                </div>

                <!-- Grid Detail -->
                <div class="details-grid">
                    
                    <div class="detail-item">
                        <label for="name">Nama Lengkap</label>
                        <p id="text-nama">{{ $user->name }}</p>
                        <input type="text" id="input-nama" name="name" value="{{ old('name', $user->name) }}" required class="form-input d-none">
                        <x-input-error :messages="$errors->get('name')" class="text-error" />
                    </div>
                    
                    <div class="detail-item">
                        <label for="nik">NIK</label>
                        <p id="text-nik">{{ $karyawan->nik ?? '-' }}</p>
                        <input type="text" id="input-nik" name="nik" value="{{ old('nik', $karyawan->nik) }}" class="form-input d-none" placeholder="Masukkan NIK">
                        <x-input-error :messages="$errors->get('nik')" class="text-error" />
                    </div>

                    <div class="detail-item">
                        <label>Jabatan</label>
                        <p>{{ $karyawan->jabatan ?? '-' }}</p>
                    </div>

                    <div class="detail-item">
                        <label>Departemen</label>
                        <p>{{ $karyawan->departemen ?? '-' }}</p>
                    </div>

                    <div class="detail-item">
                        <label for="email">Email</label>
                        <p id="text-email">{{ $user->email }}</p>
                        <input type="email" id="input-email" name="email" value="{{ old('email', $user->email) }}" required class="form-input d-none">
                        <x-input-error :messages="$errors->get('email')" class="text-error" />
                    </div>

                    <div class="detail-item">
                        <label for="no_telepon">No. Telepon</label>
                        <p id="text-telepon">{{ $karyawan->no_telepon ?? '-' }}</p>
                        <input type="text" id="input-telepon" name="no_telepon" value="{{ old('no_telepon', $karyawan->no_telepon) }}" class="form-input d-none" placeholder="Masukkan No Telepon">
                        <x-input-error :messages="$errors->get('no_telepon')" class="text-error" />
                    </div>

                    <div class="detail-item">
                        <label>Tanggal Bergabung</label>
                        <p>{{ $karyawan && $karyawan->tanggal_bergabung ? \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->translatedFormat('d F Y') : '-' }}</p>
                    </div>

                    <div class="detail-item">
                        <label>Sisa Cuti Tahunan</label>
                        <p class="highlight">12 Hari</p>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn-edit" class="btn-primary" onclick="aktifkanEditMode()">Edit Profil</button>
                
                <div id="action-buttons" class="d-none" style="display: flex; gap: 12px;">
                    <button type="button" class="btn-outline" onclick="window.location.reload()">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>

        <!-- KOLOM KANAN: Ubah Password -->
        <div class="card card-password">
            <div class="card-header">
                <h3>Ubah Password</h3>
            </div>
            
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <!-- Password Lama -->
                <div class="form-group">
                    <label for="current_password">Password Lama</label>
                    <div class="input-wrapper">
                        <input type="password" id="current_password" name="current_password" class="form-input" placeholder="Masukkan password lama">
                        <span class="password-toggle-icon" onclick="togglePassword('current_password', 'icon-current')">
                            <svg id="icon-current" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-error" />
                </div>

                <!-- Password Baru -->
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password baru">
                        <span class="password-toggle-icon" onclick="togglePassword('password', 'icon-new')">
                            <svg id="icon-new" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="text-error" />
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                        <span class="password-toggle-icon" onclick="togglePassword('password_confirmation', 'icon-confirm')">
                            <svg id="icon-confirm" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-error" />
                </div>

                <button type="submit" class="btn-primary btn-full">Simpan Password</button>
            </form>
        </div>

    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('photo-preview');
            output.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function aktifkanEditMode() {
        document.getElementById('text-nama').classList.add('d-none');
        document.getElementById('text-email').classList.add('d-none');
        document.getElementById('text-nik').classList.add('d-none');
        document.getElementById('text-telepon').classList.add('d-none');
        document.getElementById('btn-edit').classList.add('d-none');

        document.getElementById('input-nama').classList.remove('d-none');
        document.getElementById('input-email').classList.remove('d-none');
        document.getElementById('input-nik').classList.remove('d-none');
        document.getElementById('input-telepon').classList.remove('d-none');
        document.getElementById('btn-upload-foto').classList.remove('d-none');
        document.getElementById('action-buttons').classList.remove('d-none');
    }

    function togglePassword(fieldId, iconId) {
        const inputField = document.getElementById(fieldId);
        const iconElement = document.getElementById(iconId);

        if (inputField.type === "password") {
            inputField.type = "text";
            iconElement.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.057 10.057 0 012.062-3.238m4.93-2.128A9.954 9.954 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"></path>`;
        } else {
            inputField.type = "password";
            iconElement.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
        }
    }

    // Script Otomatis Menghilangkan Alert Sukses setelah 4 Detik (4000ms)
    document.addEventListener('DOMContentLoaded', function() {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(function() {
                alertBox.classList.add('alert-hidden');
            }, 4000); // Waktu tunggu sebelum mulai menghilang (4 detik)
        }
    });

    @if($errors->has('name') || $errors->has('email') || $errors->has('foto') || $errors->has('nik') || $errors->has('no_telepon'))
        document.addEventListener('DOMContentLoaded', function() {
            aktifkanEditMode();
        });
    @endif
</script>
@endsection