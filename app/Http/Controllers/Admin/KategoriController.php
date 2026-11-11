<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.kategori.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index');
    }

    public function edit($id)
    {
        $data = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ]);

        $data = Kategori::findOrFail($id);
        $data->update($validated);

        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $data = Kategori::findOrFail($id);
        $data->delete();

        return redirect()->route('kategori.index');
    }
}
