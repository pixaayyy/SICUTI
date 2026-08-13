<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisaCuti extends Model
{
    use HasFactory;

    protected $table = 'sisa_cuti';

    protected $fillable = [
        'karyawan_id',
        'tahun',
        'jatah',
        'terpakai',
        'sisa',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'jatah' => 'integer',
        'terpakai' => 'integer',
        'sisa' => 'integer',
    ];

    /**
     * Saldo cuti milik karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}