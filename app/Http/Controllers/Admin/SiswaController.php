<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SiswaController extends Controller
{
    // TAMPIL DATA
    public function index(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');

        $siswa = $this->querySiswa($search)->paginate(10)->withQueryString();

        return view('admin.siswa.index', compact('siswa'));
    }

    public function cetak(Request $request)
    {
        $validated = $request->validate(['search' => ['nullable', 'string']]);
        $search = trim($validated['search'] ?? '');
        $siswa = $this->querySiswa($search)->get();

        return view('admin.laporan.siswa', compact('siswa', 'search'));
    }

    private function querySiswa(string $search)
    {
        return User::where('role', 'siswa')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama');
    }

    // EXPORT CSV
    public function export(): StreamedResponse
    {
        $fileName = 'data_siswa.csv';
        $siswa = User::where('role', 'siswa')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($siswa) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'Email']);

            $no = 1;
            foreach ($siswa as $data) {
                fputcsv($file, [
                    $no++,
                    $data->nama,
                    $data->email,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
