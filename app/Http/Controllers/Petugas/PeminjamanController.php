<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        Peminjaman::all()->each->cekStatusTerlambat();

        $validated = $request->validate([
            'search' => ['nullable', 'string'],
            'status' => ['nullable', 'in:menunggu,diterima,ditolak,terlambat,dikembalikan'],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';

        $data = $this->queryPeminjaman($search, $status)->paginate(12)->withQueryString();

        return view('petugas.peminjaman.index', compact('data'));
    }

    public function cetak(Request $request)
    {
        Peminjaman::select('id', 'status', 'tanggal_kembali')
            ->get()
            ->each(function ($peminjaman) {
                $peminjaman->cekStatusTerlambat();
            });

        $validated = $request->validate([
            'search' => ['nullable', 'string'],
            'status' => ['nullable', 'in:menunggu,diterima,ditolak,terlambat,dikembalikan'],
            'jenis' => ['nullable', 'in:peminjaman,pengembalian'],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';
        $jenis = $validated['jenis'] ?? '';
        $query = $this->queryPeminjaman($search, $status);

        if ($jenis === 'peminjaman') {
            $query->whereIn('status', ['diterima', 'terlambat']);
        } elseif ($jenis === 'pengembalian') {
            $query->where('status', 'dikembalikan');
        }

        $data = $query->get();

        return view('admin.laporan.peminjaman', compact('data', 'search', 'status', 'jenis'));
    }

    private function queryPeminjaman(string $search, string $status)
    {
        return Peminjaman::with(['buku', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('status', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('nama', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('buku', function ($query) use ($search) {
                            $query->where('judul', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest();
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
            $peminjaman->tanggal_dikembalikan = now()->toDateString();
        }

        $peminjaman->save();

        return back()->with('success', 'Status berhasil diperbarui!');
    }
}
