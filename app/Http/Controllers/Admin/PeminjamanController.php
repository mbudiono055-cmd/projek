<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        Peminjaman::select('id', 'status', 'tanggal_kembali')
            ->get()
            ->each(function ($peminjaman) {
                $peminjaman->cekStatusTerlambat();
            });

        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');
        $status = $request->query('status', '');
        $validStatuses = ['menunggu', 'diterima', 'ditolak', 'terlambat', 'dikembalikan'];

        $data = Peminjaman::with(['buku', 'user'])
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
            ->when(in_array($status, $validStatuses, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('data'));
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

        $query = Peminjaman::with(['buku', 'user'])
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
            });

        if ($jenis === 'peminjaman') {
            $query->whereIn('status', ['diterima', 'terlambat']);
        } elseif ($jenis === 'pengembalian') {
            $query->where('status', 'dikembalikan');
        }

        $data = $query->latest()->get();

        return view('admin.laporan.peminjaman', compact('data', 'search', 'status', 'jenis'));
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
