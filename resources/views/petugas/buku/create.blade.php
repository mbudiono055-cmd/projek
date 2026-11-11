@extends('layouts.petugas')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Perpustakaan</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Tambah Buku</h1>
        <p class="mt-1 text-sm text-slate-500">Lengkapi informasi buku untuk menambahkannya ke koleksi.</p>
    </div>

    @if($errors->any())
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <p class="mb-1 font-semibold">Periksa kembali data yang diisi.</p>
            <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        @csrf
        <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-5 sm:px-8">
            <h2 class="font-semibold text-slate-800">Informasi Buku</h2>
            <p class="mt-1 text-sm text-slate-500">Kolom bertanda wajib diisi harus dilengkapi.</p>
        </div>

        <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-[minmax(0,1fr)_260px]">
            <div class="grid content-start gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="judul" class="mb-2 block text-sm font-semibold text-slate-700">Judul Buku <span class="text-rose-500">*</span></label>
                    <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required maxlength="255" autofocus
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan judul buku">
                    @error('judul')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="penulis" class="mb-2 block text-sm font-semibold text-slate-700">Penulis <span class="text-rose-500">*</span></label>
                    <input id="penulis" type="text" name="penulis" value="{{ old('penulis') }}" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Nama penulis">
                    @error('penulis')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="penerbit" class="mb-2 block text-sm font-semibold text-slate-700">Penerbit <span class="text-rose-500">*</span></label>
                    <input id="penerbit" type="text" name="penerbit" value="{{ old('penerbit') }}" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Nama penerbit">
                    @error('penerbit')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kategori_id" class="mb-2 block text-sm font-semibold text-slate-700">Kategori <span class="text-rose-500">*</span></label>
                    <select id="kategori_id" name="kategori_id" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="">Pilih kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tahun_terbit" class="mb-2 block text-sm font-semibold text-slate-700">Tahun Terbit <span class="text-rose-500">*</span></label>
                        <input id="tahun_terbit" type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required min="0" max="2100" inputmode="numeric"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="2026">
                        @error('tahun_terbit')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="stok" class="mb-2 block text-sm font-semibold text-slate-700">Stok <span class="text-rose-500">*</span></label>
                        <input id="stok" type="number" name="stok" value="{{ old('stok') }}" required min="0" inputmode="numeric"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="0">
                        @error('stok')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <label for="gambar" class="mb-2 block text-sm font-semibold text-slate-700">Sampul Buku <span class="font-normal text-slate-400">(opsional)</span></label>
                <label for="gambar" class="group flex min-h-72 cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 p-4 text-center transition hover:border-blue-300 hover:bg-blue-50/50">
                    <img id="cover-preview" alt="Pratinjau sampul buku" class="hidden h-56 w-40 rounded-xl object-cover shadow-md">
                    <span id="cover-placeholder" class="flex flex-col items-center">
                        <span class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-800 transition group-hover:scale-105">
                            <i data-feather="image" class="h-6 w-6"></i>
                        </span>
                        <span class="text-sm font-semibold text-slate-700">Pilih gambar sampul</span>
                        <span class="mt-1 text-xs text-slate-400">JPG atau PNG, maks. 2 MB</span>
                    </span>
                </label>
                <input id="gambar" type="file" name="gambar" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="sr-only">
                @error('gambar')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/60 px-6 py-5 sm:flex-row sm:justify-end sm:px-8">
            <a href="{{ route('petugas.buku.index') }}" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Kembali</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900 hover:shadow-md">
                <i data-feather="plus" class="h-4 w-4"></i>
                Simpan Buku
            </button>
        </div>
    </form>
</div>
<script>
    feather.replace();

    const coverInput = document.getElementById('gambar');
    const coverPreview = document.getElementById('cover-preview');
    const coverPlaceholder = document.getElementById('cover-placeholder');
    let coverPreviewUrl;

    coverInput.addEventListener('change', () => {
        const file = coverInput.files[0];
        if (coverPreviewUrl) URL.revokeObjectURL(coverPreviewUrl);

        if (!file) {
            coverPreview.classList.add('hidden');
            coverPlaceholder.classList.remove('hidden');
            return;
        }

        coverPreviewUrl = URL.createObjectURL(file);
        coverPreview.src = coverPreviewUrl;
        coverPreview.classList.remove('hidden');
        coverPlaceholder.classList.add('hidden');
    });
</script>
@endsection
