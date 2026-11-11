@extends('layouts.petugas')

@section('content')

<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Koleksi</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-800">Tambah Kategori</h1>
        <p class="mt-2 text-sm text-slate-500">Buat kategori dan tambahkan deskripsi agar koleksi lebih mudah dipahami.</p>

        <form action="{{ route('petugas.kategori.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div>
                <label for="nama_kategori" class="mb-2 block text-sm font-semibold text-slate-700">Nama Kategori</label>
                <input id="nama_kategori" type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" maxlength="255" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    placeholder="Contoh: Pengembangan Diri">
                @error('nama_kategori')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="2000"
                    class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                    placeholder="Jelaskan jenis buku yang termasuk dalam kategori ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@else<p class="mt-1.5 text-xs text-slate-400">Maksimal 2.000 karakter.</p>@enderror
            </div>
            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row">
                <a href="{{ route('petugas.kategori.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Kembali</a>
                <button type="submit" class="rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

@endsection
