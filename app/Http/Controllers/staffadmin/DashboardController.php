<?php

namespace App\Http\Controllers\StaffAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dummy untuk metrik monitoring sesuai gambar
        $data = [
            'total_selesai' => '1,248',
            'karyawan_cuti' => '42',
            'rata_durasi'   => '3.5',
        ];

        // Me-return view dashboard dan passing data
        return view('staffadmin.dashboard', $data);
    }
}