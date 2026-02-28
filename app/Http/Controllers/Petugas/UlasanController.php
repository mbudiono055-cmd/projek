<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with(['user','buku'])
            ->latest()
            ->paginate(10);

        return view('petugas.ulasan.index', compact('ulasans'));
    }
}
