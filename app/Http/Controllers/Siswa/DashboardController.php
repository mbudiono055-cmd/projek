<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $userId = session('user_id');

        $totalBuku = Buku::disetujui()->count();

        // Hitung yang sedang dipinjam (diterima + terlambat)
        $dipinjam = Peminjaman::where('user_id', $userId)
                        ->whereIn('status', ['diterima', 'terlambat'])
                        ->count();

        $dikembalikan = Peminjaman::where('user_id', $userId)
                            ->where('status', 'dikembalikan')
                            ->count();

        $bukuTerbaru = Buku::disetujui()->latest()->take(4)->get();

        return view('siswa.dashboard', compact(
            'totalBuku',
            'dipinjam',
            'dikembalikan',
            'bukuTerbaru'
        ));
    }


    // ================= KATALOG =================
    public function katalog()
    {
        $bukus = Buku::disetujui()->get();
        return view('siswa.katalog', compact('bukus'));
    }


    // ================= PINJAM BUKU =================
    public function pinjam($id)
    {
        $userId = session('user_id');
        $buku = Buku::disetujui()->findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // Cek apakah siswa sudah pinjam buku ini dan belum dikembalikan
        $cek = Peminjaman::where('user_id', $userId)
                    ->where('buku_id', $id)
                    ->whereIn('status', ['diterima', 'terlambat'])
                    ->first();

        if ($cek) {
            return back()->with('error', 'Kamu sudah meminjam buku ini.');
        }

        // Create peminjaman with 'menunggu' status (need petugas approval)
        Peminjaman::create([
            'user_id' => $userId,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(7), // Default 7 days
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil! Menunggu persetujuan petugas.');
    }


    // ================= BUKU SAYA =================
    public function bukuSaya()
    {
        $userId = session('user_id');

        $peminjaman = Peminjaman::with('buku')
                        ->where('user_id', $userId)
                        ->whereIn('status', ['diterima', 'terlambat'])
                        ->get();

        // Auto-check and update status to 'terlambat' if overdue
        foreach ($peminjaman as $p) {
            $p->cekStatusTerlambat();
        }

        return view('siswa.buku_saya', compact('peminjaman'));
    }


    // ================= RIWAYAT =================
    public function riwayat()
    {
        $userId = session('user_id');

        $riwayat = Peminjaman::with('buku')
                    ->where('user_id', $userId)
                    ->get();

        // Auto-check and update status to 'terlambat' if overdue
        foreach ($riwayat as $p) {
            $p->cekStatusTerlambat();
        }

        return view('siswa.riwayat', compact('riwayat'));
    }
}
