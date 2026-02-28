<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    // Tampilkan semua ulasan
    public function index()
    {
        $ulasans = Ulasan::with(['buku', 'user'])
                    ->latest()
                    ->paginate(10);

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
