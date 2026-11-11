<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');

        $data = Kategori::withCount('buku')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama_kategori', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_kategori')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.kategori.index', compact('data'));
    }

    public function create()
    {
        return view('petugas.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ]);

        Kategori::create($validated);

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = Kategori::findOrFail($id);
        return view('petugas.kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ]);

        $data = Kategori::findOrFail($id);
        $data->update($validated);

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Kategori::findOrFail($id);
        $data->delete();

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
