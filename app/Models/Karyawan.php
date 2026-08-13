<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'user_id',
        'nik',
        'jabatan',
        'departemen',
        'no_telepon',
        'foto',
    ];

    /**
     * Karyawan memiliki satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Karyawan memiliki banyak pengajuan cuti
     */
    public function pengajuanCuti()
    {
        return $this->hasMany(PengajuanCuti::class);
    }

    /**
     * Karyawan memiliki banyak saldo cuti
     */
    public function sisaCuti()
    {
        return $this->hasMany(SisaCuti::class);
    }
}