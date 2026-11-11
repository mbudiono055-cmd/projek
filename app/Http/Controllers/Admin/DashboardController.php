<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /* ================= DASHBOARD ================= */
    public function index()
    {
        Peminjaman::all()->each->cekStatusTerlambat();

        $totalBuku = Buku::count();
        $menungguValidasiBuku = Buku::where('status_validasi', Buku::STATUS_MENUNGGU)->count();
        $totalPetugas = User::where('role', 'petugas')->count();

        $dipinjam = Peminjaman::whereIn('status', [
            Peminjaman::STATUS_DITERIMA,
            Peminjaman::STATUS_TERLAMBAT
        ])->count();

        $terlambat = Peminjaman::where(
            'status',
            Peminjaman::STATUS_TERLAMBAT
        )->count();

        $data = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'menungguValidasiBuku',
            'totalPetugas',
            'dipinjam',
            'terlambat',
            'data'
        ));
    }

    /* ================= PROFIL ================= */
    public function profil()
    {
        $admin = User::find(session('user_id'));

        return view('admin.profil.index', compact('admin'));
    }

    /* ================= EDIT PROFIL ================= */
    public function editProfil()
    {
        $admin = User::find(session('user_id'));

        return view('admin.profil.edit', compact('admin'));
    }

    /* ================= UPDATE PROFIL ================= */
    public function updateProfil(Request $request)
    {
        $admin = User::find(session('user_id'));

        if (!$admin) {
            return redirect('/login');
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $admin->nama = $request->nama;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {

            // Hapus foto lama kalau ada
            if ($admin->foto && file_exists(public_path('foto_admin/' . $admin->foto))) {
                unlink(public_path('foto_admin/' . $admin->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_admin'), $filename);

            $admin->foto = $filename;
        }

        $admin->save();

        // update session name juga
        session(['user_name' => $admin->nama]);

        return redirect('/admin/profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
}