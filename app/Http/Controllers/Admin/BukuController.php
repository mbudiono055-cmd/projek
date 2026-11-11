<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string'],
            'status' => ['nullable', 'in:menunggu,disetujui,ditolak'],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';

        $buku = Buku::with('kategori')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhere('tahun_terbit', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($query) use ($search) {
                            $query->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status_validasi', $status);
            })
            ->orderBy('judul')
            ->paginate(10)
            ->withQueryString();
        $menungguValidasi = Buku::where('status_validasi', Buku::STATUS_MENUNGGU)->count();

        return view('admin.buku.index', compact('buku', 'menungguValidasi'));
    }

    public function cetak(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string'],
            'status' => ['nullable', 'in:menunggu,disetujui,ditolak'],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';

        $buku = Buku::with('kategori')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhere('tahun_terbit', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function ($query) use ($search) {
                            $query->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status_validasi', $status);
            })
            ->orderBy('judul')
            ->get();

        return view('admin.laporan.buku', compact('buku', 'search', 'status'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'kategori_id' => 'required',
            'tahun_terbit' => 'required',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('buku', 'public');
        }

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori_id' => $request->kategori_id,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'gambar' => $gambar,
            'status_validasi' => Buku::STATUS_DISETUJUI,
        ]);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'kategori_id' => 'required',
            'tahun_terbit' => 'required',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambar = $buku->gambar;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('buku', 'public');
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori_id' => $request->kategori_id,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'gambar' => $gambar
        ]);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        Buku::findOrFail($id)->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }

    public function validasi(Request $request, $id)
    {
        abort_unless(session('role') === 'admin', 403);

        $validated = $request->validate([
            'aksi' => ['required', 'in:setujui,tolak'],
        ]);

        $buku = Buku::where('status_validasi', Buku::STATUS_MENUNGGU)->findOrFail($id);
        $buku->status_validasi = $validated['aksi'] === 'setujui'
            ? Buku::STATUS_DISETUJUI
            : Buku::STATUS_DITOLAK;
        $buku->save();

        $pesan = $validated['aksi'] === 'setujui'
            ? 'Buku berhasil disetujui dan ditampilkan di katalog.'
            : 'Buku ditolak dan tidak ditampilkan di katalog.';

        return redirect()->route('buku.index')->with('success', $pesan);
    }
}
