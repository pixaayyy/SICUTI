@extends('layouts.staffadmin')

@section('title', 'Tambah Pegawai - SICUTI')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen font-sans">
    
    <!-- Header Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Pegawai Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Masukkan data pegawai atau pengguna baru ke dalam sistem.</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Error Validasi -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="font-bold">Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc pl-10 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
        <form action="{{ route('staffadmin.pegawai.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                       placeholder="Masukkan nama lengkap">
            </div>

            <div class="mb-5">
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                       placeholder="Masukkan username unik">
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                       placeholder="email@perusahaan.com">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required minlength="8" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all pr-10"
                           placeholder="Minimal 8 karakter">
                    
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg id="iconEye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="iconEyeSlash" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mb-5">
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role (Hak Akses)</label>
                <select name="role" id="role" required 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white transition-all">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Hak Akses --</option>
                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    <option value="mandor" {{ old('role') == 'mandor' ? 'selected' : '' }}>Mandor</option>
                    <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="staff_administrasi" {{ old('role') == 'staff_administrasi' ? 'selected' : '' }}>Staff Administrasi</option>
                    <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                </select>
            </div>

            <!-- BAGIAN TAMBAHAN DEPARTEMEN & TANGGAL BERGABUNG -->
            <div class="mb-5">
                <label for="departemen" class="block text-sm font-semibold text-gray-700 mb-2">Departemen</label>
                <input type="text" name="departemen" id="departemen" value="{{ old('departemen') }}" required 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                       placeholder="Contoh: IT, HRD, Produksi, Operasional">
            </div>

            <div class="mb-8">
                <label for="tanggal_bergabung" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" value="{{ old('tanggal_bergabung') }}" required 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-700">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="reset" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Kosongkan Form
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#0a5c9e] text-white font-medium rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
                    Simpan Pegawai
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Script untuk Toggle Password -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const iconEye = document.getElementById('iconEye');
        const iconEyeSlash = document.getElementById('iconEyeSlash');

        togglePassword.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconEye.classList.add('hidden');
                iconEyeSlash.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                iconEye.classList.remove('hidden');
                iconEyeSlash.classList.add('hidden');
            }
        });
    });
</script>
@endsection