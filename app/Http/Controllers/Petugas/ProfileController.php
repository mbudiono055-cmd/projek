<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ProfileController extends Controller
{
    // ======================
    // TAMPILKAN PROFIL
    // ======================
    public function index()
    {
        $user = User::find(Session::get('user_id'));
        return view('petugas.profile.index', compact('user'));
    }

    // ======================
    // UPDATE PROFIL
    // ======================
    public function update(Request $request)
    {
        $user = User::find(Session::get('user_id'));

        $request->validate([
            'nama'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $namaFile);

            $user->foto = $namaFile;
        }

        $user->save();

        Session::put('user_name', $user->nama);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    // ======================
    // UPDATE PASSWORD
    // ======================
    public function updatePassword(Request $request)
    {
        $user = User::find(Session::get('user_id'));

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed'
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama salah');
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diganti');
    }
}