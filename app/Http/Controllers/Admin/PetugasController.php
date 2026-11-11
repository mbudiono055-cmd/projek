<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');

        $petugas = $this->queryPetugas($search)->paginate(10)->withQueryString();

        return view('admin.petugas.index', compact('petugas'));
    }

    public function cetak(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');
        $petugas = $this->queryPetugas($search)->get();

        return view('admin.laporan.petugas', compact('petugas', 'search'));
    }

    private function queryPetugas(string $search)
    {
        return User::where('role', 'petugas')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama');
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas'
        ]);

        return redirect()->route('petugas.index')
            ->with('success','Petugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('petugas.index')
            ->with('success','Petugas berhasil diupdate');
    }

    public function destroy($id)
    {
        User::where('role', 'petugas')->findOrFail($id)->delete();

        return back()->with('success','Petugas berhasil dihapus');
    }
}