@extends('layouts.petugas')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Koleksi</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-800">Edit Kategori</h1>
        <p class="mt-2 text-sm text-slate-500">Perbarui nama atau deskripsi kategori.</p>

        <form action="{{ route('petugas.kategori.update', $data->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_kategori" class="block text-sm font-semibold text-gray-600 mb-2">Nama Kategori</label>
                <input
                    id="nama_kategori"
                    type="text"
                    name="nama_kategori"
                    value="{{ old('nama_kategori', $data->nama_kategori) }}"
                    maxlength="255"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition"
                    placeholder="Masukkan nama kategori"
                    required
                >
                @error('nama_kategori')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="2000"
                    class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    placeholder="Jelaskan jenis buku yang termasuk dalam kategori ini...">{{ old('deskripsi', $data->deskripsi) }}</textarea>
                @error('deskripsi')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@else<p class="mt-1.5 text-xs text-slate-400">Maksimal 2.000 karakter.</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl shadow-md transition">
                    Update
                </button>

                <a href="{{ route('petugas.kategori.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-xl transition">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
