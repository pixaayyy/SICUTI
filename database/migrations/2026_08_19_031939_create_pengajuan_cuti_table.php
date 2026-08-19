<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_cuti', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel karyawan
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            
            // Detail Cuti
            $table->string('jenis_cuti');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi');
            $table->text('alasan')->nullable();
            
            // Status pengajuan: Menunggu Persetujuan, Disetujui, Ditolak
            $table->string('status')->default('Menunggu Persetujuan');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cuti');
    }
};