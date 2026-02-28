<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // OPTIONAL: update otomatis status terlambat dulu
    Peminjaman::all()->each->cekStatusTerlambat();

    // ================= STATISTIK =================
    $totalBuku = Buku::count();

    $totalPetugas = User::where('role', 'petugas')->count();

    // Sedang dipinjam = diterima + terlambat
    $dipinjam = Peminjaman::whereIn('status', [
        Peminjaman::STATUS_DITERIMA,
        Peminjaman::STATUS_TERLAMBAT
    ])->count();

    // Hitung yang benar-benar sudah terlambat
    $terlambat = Peminjaman::where(
        'status',
        Peminjaman::STATUS_TERLAMBAT
    )->count();

    // ================= RIWAYAT TERBARU =================
    $data = Peminjaman::with(['user', 'buku'])
        ->latest()
        ->take(5)
        ->get();

    return view('petugas.dashboard', compact(
        'totalBuku',
        'totalPetugas',
        'dipinjam',
        'terlambat',
        'data'
    ));
}
}
