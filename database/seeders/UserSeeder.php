<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\SisaCuti;
use App\Models\PengajuanCuti; // Wajib ditambahkan
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Karyawan
        $karyawanUser = User::create([
            'name' => 'Aji Santoso',
            'username' => 'aji_santoso',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('1233'),
            'role' => 'karyawan',
        ]);

        $karyawan1 = Karyawan::create([
            'user_id' => $karyawanUser->id,
            'nik' => '330123456789',
            'jabatan' => 'Staff Operasional',
            'departemen' => 'Produksi',
            'no_telepon' => '081234567890',
            'tanggal_bergabung' => Carbon::parse('2024-01-15'),
        ]);

        SisaCuti::create([
            'karyawan_id' => $karyawan1->id,
            'tahun' => 2026,
            'sisa_cuti' => 10,
            'cuti_terpakai' => 2,
        ]);

        // Buat satu contoh Pengajuan Cuti yang sudah Disetujui untuk Aji
        PengajuanCuti::create([
            'karyawan_id' => $karyawan1->id,
            'jenis_cuti' => 'Cuti Tahunan',
            'tanggal_mulai' => Carbon::parse('2026-08-12'),
            'tanggal_selesai' => Carbon::parse('2026-08-14'),
            'durasi' => 2,
            'alasan' => 'Acara keluarga di kampung',
            'status' => 'Disetujui',
        ]);

        // Buat satu contoh Pengajuan Cuti Menunggu Persetujuan
        PengajuanCuti::create([
            'karyawan_id' => $karyawan1->id,
            'jenis_cuti' => 'Cuti Sakit',
            'tanggal_mulai' => Carbon::parse('2026-08-15'),
            'tanggal_selesai' => Carbon::parse('2026-08-17'),
            'durasi' => 3,
            'alasan' => 'Sakit demam',
            'status' => 'Menunggu Persetujuan',
        ]);

        // 2. Akun Mandor
        $mandorUser = User::create([
            'name' => 'Budi Pratama (Mandor)',
            'username' => 'mandor1',
            'email' => 'mandor@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'mandor',
        ]);

        $mandor1 = Karyawan::create([
            'user_id' => $mandorUser->id,
            'nik' => '330987654321',
            'jabatan' => 'Mandor Lapangan',
            'departemen' => 'Produksi',
            'no_telepon' => '089876543210',
            'tanggal_bergabung' => Carbon::parse('2022-05-10'),
        ]);

        SisaCuti::create([
            'karyawan_id' => $mandor1->id,
            'tahun' => 2026,
            'sisa_cuti' => 12,
            'cuti_terpakai' => 0,
        ]);
    }
}