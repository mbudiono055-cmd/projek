<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::with(['buku', 'user'])
            ->latest()
            ->get();

        // Auto-check and update status to 'terlambat' if overdue
        foreach ($data as $peminjaman) {
            $peminjaman->cekStatusTerlambat();
        }

        return view('petugas.peminjaman.index', compact('data'));
    }

    public function verifikasi($id, $aksi)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);
        $buku = $peminjaman->buku;

        if ($aksi === 'terima') {

            if ($buku->stok < $peminjaman->jumlah) {
                return back()->with('error', 'Stok buku tidak cukup!');
            }

            $buku->decrement('stok', $peminjaman->jumlah);
            $peminjaman->status = 'diterima';
        }

        elseif ($aksi === 'tolak') {
            $peminjaman->status = 'ditolak';
        }

        elseif ($aksi === 'kembali') {

            if ($peminjaman->status !== 'diterima' && $peminjaman->status !== 'terlambat') {
                return back()->with('error', 'Status belum diterima!');
            }

            $buku->increment('stok', $peminjaman->jumlah);
            $peminjaman->status = 'dikembalikan';
        }

        $peminjaman->save();

        return back()->with('success', 'Status berhasil diperbarui!');
    }
}
