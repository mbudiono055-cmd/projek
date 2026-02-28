<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    /**
     * Ajukan peminjaman buku
     */
    public function pinjam(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after_or_equal:today'
        ]);

        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $buku = Buku::findOrFail($id);

        if ($request->jumlah > $buku->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        // Cek apakah masih ada peminjaman aktif
        $cek = Peminjaman::where('user_id', $userId)
                ->where('buku_id', $id)
                ->whereIn('status', ['menunggu', 'diterima'])
                ->first();

        if ($cek) {
            return back()->with('error', 'Kamu masih memiliki pengajuan atau pinjaman buku ini');
        }

        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $userId,
                'buku_id' => $id,
                'jumlah' => $request->jumlah,
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'menunggu'
            ]);

            Log::info('Peminjaman berhasil dibuat', [
                'peminjaman_id' => $peminjaman->id,
                'user_id' => $userId,
                'buku_id' => $id
            ]);

            return redirect()->route('siswa.buku.saya')
                    ->with('success', 'Pengajuan peminjaman menunggu validasi admin');
        } catch (\Exception $e) {
            Log::error('Gagal membuat peminjaman: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengajukan peminjaman. Silakan coba lagi.');
        }
    }

    /**
     * Buku Saya (yang masih aktif)
     */
    public function bukuSaya()
    {
        $userId = session('user_id');

        $data = Peminjaman::where('user_id', $userId)
                    ->whereIn('status', ['menunggu', 'diterima'])
                    ->with('buku')
                    ->latest()
                    ->get();

        return view('siswa.buku_saya', compact('data'));
    }

    /**
     * Riwayat (semua histori peminjaman)
     */
    public function riwayat()
    {
        $userId = session('user_id');

        $riwayat = Peminjaman::where('user_id', $userId)
                    ->with('buku')
                    ->latest()
                    ->get();

        return view('siswa.riwayat', compact('riwayat'));
    }

    public function bukti($id)
{
    $userId = session('user_id');

    $data = Peminjaman::where('id', $id)
                ->where('user_id', $userId)
                ->whereIn('status', ['diterima', 'dikembalikan'])
                ->with('buku')
                ->firstOrFail();

    return view('siswa.bukti', compact('data'));
}

    /**
     * Batalkan pengajuan (hanya jika masih menunggu)
     */
    public function batal($id)
    {
        $userId = session('user_id');

        $peminjaman = Peminjaman::where('id', $id)
                        ->where('user_id', $userId)
                        ->where('status', 'menunggu')
                        ->firstOrFail();

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Pengajuan berhasil dibatalkan');
    }

    public function simpanUlasan(Request $request)
{
    $request->validate([
        'buku_id' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required'
    ]);

    Ulasan::create([
        'user_id' => session('user_id'),
        'buku_id' => $request->buku_id,
        'rating' => $request->rating,
        'komentar' => $request->komentar
    ]);

    return back()->with('success', 'Ulasan berhasil dikirim!');
}
}
