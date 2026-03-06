<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class ProfileController extends Controller
{

    public function index()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        return view('siswa.profile.index', compact('siswa'));
    }


    public function edit()
    {
        $userId = session('user_id');

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        return view('siswa.profile.edit', compact('siswa'));
    }


    public function update(Request $request)
    {

        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $userId = session('user_id');

        $siswa = Siswa::where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }


        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('foto_profil'), $filename);

            $siswa->foto = $filename;
        }


        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->alamat = $request->alamat;

        $siswa->save();

        return redirect()->route('siswa.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

}
