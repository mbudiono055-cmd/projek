<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class KatalogController extends Controller
{
    // ================= KATALOG + FILTER + SEARCH =================
    public function index(Request $request)
    {
        $kategori = Kategori::all();

        $bukus = Buku::disetujui()->with('kategori')
            ->when($request->kategori, function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('siswa.katalog', compact('bukus', 'kategori'));
    }

    // ================= DETAIL =================
    public function show($id)
    {
        $buku = Buku::disetujui()->with(['kategori', 'ulasans.user'])
                    ->findOrFail($id);

        return view('siswa.detail', compact('buku'));
    }
}
