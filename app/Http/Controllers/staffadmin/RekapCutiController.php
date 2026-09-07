<?php
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan; // Sesuaikan dengan model kamu

class RekapCutiController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('sisaCuti')->paginate(10);

        // Memanggil file rekap-cuti.blade.php di dalam folder staffadmin
        return view('staffadmin.rekapcuti', compact('karyawans'));
    }
}
?>