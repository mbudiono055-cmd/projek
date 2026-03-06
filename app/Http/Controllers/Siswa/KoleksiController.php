<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KoleksiBuku;
use App\Models\Buku;

class KoleksiController extends Controller
{
    // =========================
    // TAMPILKAN KOLEKSI SISWA
    // =========================
    public function index()
    {
        $koleksi = KoleksiBuku::with('buku')
            ->where('user_id', session('user_id'))
            ->latest()
            ->get();

        return view('siswa.koleksi.index', compact('koleksi'));
    }

    // =========================
    // TAMBAH KE KOLEKSI
    // =========================
    public function tambah($id)
    {
        $userId = session('user_id');

        // cek buku ada
        $buku = Buku::findOrFail($id);

        // cek sudah ada di koleksi atau belum
        $cek = KoleksiBuku::where('user_id', $userId)
                ->where('buku_id', $id)
                ->first();

        if ($cek) {
            return back()->with('error','Buku sudah ada di koleksi');
        }

        KoleksiBuku::create([
            'user_id' => $userId,
            'buku_id' => $id
        ]);

        return back()->with('success','Buku berhasil ditambahkan ke koleksi');
    }

    // =========================
    // HAPUS KOLEKSI
    // =========================
    public function hapus($id)
    {
        $koleksi = KoleksiBuku::where('id',$id)
                    ->where('user_id', session('user_id'))
                    ->firstOrFail();

        $koleksi->delete();

        return back()->with('success','Buku berhasil dihapus dari koleksi');
    }
}
