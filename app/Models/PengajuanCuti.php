<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_cuti';

    protected $fillable = [
        'karyawan_id',
        'jenis_cuti_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'alasan',
        'status',
        'catatan',
        'data_pendukung',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'durasi' => 'integer',
    ];


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }


    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class);
    }

    
    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
    public function mandor()
    {
        return $this->belongsTo(User::class, 'mandor_id');
    }
}