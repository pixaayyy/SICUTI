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
        'tanggal_bergabung',
        'foto',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function pengajuanCuti()
    {
        return $this->hasMany(PengajuanCuti::class);
    }


    public function sisaCuti()
    {
        return $this->hasOne(SisaCuti::class);
    }
}