<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $table = 'approvals';

    protected $fillable = [
        'pengajuan_cuti_id',
        'approver_id',
        'status',
        'catatan',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Approval milik pengajuan cuti
     */
    public function pengajuanCuti()
    {
        return $this->belongsTo(PengajuanCuti::class);
    }

    /**
     * Approver adalah user
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}