@extends('layouts.karyawan')

@section('title', 'Ajukan Cuti Baru')

@section('content')
<div class="max-w-4xl">
    
    <!-- Header Halaman -->
    <div class="mb-8 border-b-2 border-[#0b3c7c] pb-4">
        <h2 class="text-3xl font-bold text-gray-900">Ajukan Cuti Baru</h2>
        <p class="mt-2 text-sm text-gray-500">Silakan isi formulir di bawah ini dengan lengkap untuk mengajukan permohonan cuti Anda.</p>
    </div>

    <!-- Alert Sukses (Jika ada) -->
    @if (session('status'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('karyawan.cuti.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        @csrf

        <!-- SECTION 1: DETAIL CUTI -->
        <div>
            <h3 class="flex items-center text-lg font-bold text-[#0b3c7c] mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Detail Cuti
            </h3>
            
            <div class="space-y-6">
                <!-- Jenis Cuti -->
                <div>
                    <label for="jenis_cuti" class="block text-sm font-semibold text-gray-700">Jenis Cuti <span class="text-red-500">*</span></label>
                    <select id="jenis_cuti" name="jenis_cuti" required class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm rounded-lg bg-gray-50">
                        <option value="" disabled selected>Pilih jenis cuti...</option>
                        <option value="Tahunan">Cuti Tahunan</option>
                        <option value="Sakit">Cuti Sakit</option>
                        <option value="Melahirkan">Cuti Melahirkan</option>
                        <option value="Penting">Cuti Khusus</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-400">Pilih kategori cuti yang sesuai dengan kebutuhan Anda.</p>
                    <x-input-error :messages="$errors->get('jenis_cuti')" class="mt-1" />
                </div>

                <!-- KOLOM TAMBAHAN: Cuti Khusus (Sembunyi secara default) -->
                <div id="kolom_cuti_khusus" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <label for="keterangan_khusus" class="block text-sm font-semibold text-[#0b3c7c]">Detail Cuti Khusus <span class="text-red-500">*</span></label>
                    <input type="text" id="keterangan_khusus" name="keterangan_khusus" placeholder="Misal: Menikah, Istri Melahirkan, Ada keluarga meninggal..." class="mt-2 block w-full py-3 px-4 border-gray-300 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm rounded-lg bg-white">
                    <p class="mt-1 text-xs text-gray-500">Sebutkan secara spesifik keperluan cuti khusus Anda.</p>
                </div>

                <!-- Tanggal Mulai & Selesai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required class="mt-1 block w-full py-3 px-4 border-gray-300 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm rounded-lg bg-gray-50">
                        <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-1" />
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-700">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required class="mt-1 block w-full py-3 px-4 border-gray-300 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm rounded-lg bg-gray-50">
                        <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-1" />
                    </div>
                </div>

                <!-- Kotak Info Durasi & Sisa Cuti -->
                <div class="flex items-center justify-between bg-gray-100 p-4 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-100 text-[#0b3c7c] rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold">Estimasi Durasi</p>
                            <p class="text-lg font-bold text-gray-900">- Hari</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-semibold">Sisa Cuti Tahunan</p>
                        <p class="text-lg font-bold text-[#0b3c7c]">{{ $sisaCuti }} Hari</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-200">

        <!-- SECTION 2: KETERANGAN TAMBAHAN -->
        <div>
            <h3 class="flex items-center text-lg font-bold text-[#0b3c7c] mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                Keterangan Tambahan
            </h3>

            <div class="space-y-6">
                <!-- Alasan / Keterangan -->
                <div>
                    <label for="alasan" class="block text-sm font-semibold text-gray-700">Alasan / Keterangan <span class="text-red-500">*</span></label>
                    <textarea id="alasan" name="alasan" rows="4" required placeholder="Jelaskan alasan pengajuan cuti secara singkat..." class="mt-1 block w-full py-3 px-4 border-gray-300 focus:ring-[#0b3c7c] focus:border-[#0b3c7c] sm:text-sm rounded-lg bg-gray-50 resize-none"></textarea>
                    <x-input-error :messages="$errors->get('alasan')" class="mt-1" />
                </div>

                <!-- Dokumen Pendukung -->
                <div>
                    <!-- Label ini akan berubah dinamis via JS -->
                    <label id="label_dokumen" class="block text-sm font-semibold text-gray-700 mb-2">Dokumen Pendukung (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="dokumen" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0b3c7c] hover:text-blue-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0b3c7c]">
                                    <span>Unggah File</span>
                                    <input id="dokumen" name="dokumen" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">atau seret dan lepas</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, JPG, PNG maksimal 5MB</p>
                        </div>
                    </div>
                    <!-- Peringatan dinamis untuk Cuti Sakit (Sembunyi secara default) -->
                    <p id="note_sakit" class="mt-2 text-sm font-medium text-red-600 hidden flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Wajib melampirkan Surat Keterangan Sakit dari Dokter!
                    </p>
                    <x-input-error :messages="$errors->get('dokumen')" class="mt-1" />
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-end gap-4 pt-6">
            <a href="#" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Batal</a>
            <button type="submit" class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-[#0b3c7c] hover:bg-[#082a5c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0b3c7c] transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L5.999 12Zm0 0h7.5"></path>
                </svg>
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

<!-- SCRIPT UNTUK LOGIKA FORM DINAMIS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisCuti = document.getElementById('jenis_cuti');
        
        // Element untuk Cuti Khusus
        const kolomKhusus = document.getElementById('kolom_cuti_khusus');
        const inputKhusus = document.getElementById('keterangan_khusus');
        
        // Element untuk Dokumen Cuti Sakit
        const dokumenInput = document.getElementById('dokumen');
        const labelDokumen = document.getElementById('label_dokumen');
        const noteSakit = document.getElementById('note_sakit');

        // Fungsi dijalankan setiap kali dropdown diganti
        jenisCuti.addEventListener('change', function() {
            
            // 1. Logika untuk Cuti Khusus (value = Penting)
            if (this.value === 'Penting') {
                kolomKhusus.classList.remove('hidden'); // Tampilkan kolom
                inputKhusus.setAttribute('required', 'required'); // Wajib diisi
            } else {
                kolomKhusus.classList.add('hidden'); // Sembunyikan kolom
                inputKhusus.removeAttribute('required'); // Lepas wajib diisi
                inputKhusus.value = ''; // Kosongkan isinya
            }

            // 2. Logika untuk Cuti Sakit (value = Sakit)
            if (this.value === 'Sakit') {
                noteSakit.classList.remove('hidden'); // Munculkan tulisan merah
                labelDokumen.innerHTML = 'Dokumen Pendukung <span class="text-red-500">*</span>'; // Ubah label jadi Wajib
                dokumenInput.setAttribute('required', 'required'); // Memaksa user upload file
            } else {
                noteSakit.classList.add('hidden'); // Sembunyikan tulisan merah
                labelDokumen.innerHTML = 'Dokumen Pendukung (Opsional)'; // Kembalikan label opsional
                dokumenInput.removeAttribute('required'); // Lepas wajib upload
            }
            
        });
    });
</script>
@endsection