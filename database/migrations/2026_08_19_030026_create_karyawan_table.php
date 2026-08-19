<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom-kolom profil karyawan
            $table->string('nik', 50)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('departemen', 100)->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->string('foto')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};