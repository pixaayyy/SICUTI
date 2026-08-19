<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sisa_cuti', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel karyawan
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            
            $table->year('tahun');
            $table->integer('sisa_cuti')->default(12);
            $table->integer('cuti_terpakai')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sisa_cuti');
    }
};