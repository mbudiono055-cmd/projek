<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'buku' => DB::table('buku')->count(),
            'petugas' => DB::table('users')->where('role', 'petugas')->count(),
            'peminjaman' => DB::table('peminjaman')->count(),
            'pengembalian' => DB::table('pengembalian')->count(),
        ]);
    }
}
