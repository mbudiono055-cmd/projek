<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    // Tampilkan semua ulasan
    public function index(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');

        $ulasans = Ulasan::with(['buku', 'user'])
                    ->when($search !== '', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('komentar', 'like', "%{$search}%")
                                ->orWhere('rating', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($query) use ($search) {
                                    $query->where('nama', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%");
                                })
                                ->orWhereHas('buku', function ($query) use ($search) {
                                    $query->where('judul', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->latest()
                    ->paginate(10)
                    ->withQueryString();

        return view('admin.ulasan.index', compact('ulasans'));
    }

    // Hapus ulasan (moderasi)
    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
