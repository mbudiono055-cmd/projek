@extends('layouts.siswa')

@section('content')
<div class="mx-auto max-w-7xl space-y-7">
    @if(session('success') || session('error'))
        <div role="status" class="rounded-2xl border px-5 py-4 text-sm font-medium {{ session('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-rose-200 bg-rose-50 text-rose-800' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <header class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">Temukan bacaanmu</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Katalog Buku</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Jelajahi koleksi perpustakaan, lihat ketersediaan, dan simpan buku yang ingin kamu baca.</p>
        </div>
        <div class="inline-flex w-fit items-center gap-2 rounded-2xl border border-blue-100 bg-white px-4 py-3 shadow-sm">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21"/></svg>
            </span>
            <span><strong class="block text-lg leading-5 text-slate-900">{{ $bukus->count() }}</strong><span class="text-xs text-slate-500">buku ditemukan</span></span>
        </div>
    </header>

    <section class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <form method="GET" action="{{ route('siswa.katalog') }}" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_15rem_auto_auto]">
            <label class="relative block">
                <span class="sr-only">Cari judul buku</span>
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4"/></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul buku..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </label>
            <label>
                <span class="sr-only">Pilih kategori</span>
                <select name="kategori" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">
                Cari buku
            </button>
            @if(request('search') || request('kategori'))
                <a href="{{ route('siswa.katalog') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
            @endif
        </form>
        @if(request('search') || request('kategori'))
            <p class="mt-3 px-1 text-xs text-slate-500">Hasil pencarian diperbarui sesuai filter yang dipilih.</p>
        @endif
    </section>

    @if($bukus->isNotEmpty())
        <section aria-label="Daftar buku" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($bukus as $item)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <a href="{{ route('siswa.detail', $item->id) }}" class="block">
                        <div class="relative flex h-60 items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 to-blue-50 p-6">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Sampul {{ $item->judul }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105" loading="lazy">
                            @else
                                <div class="flex h-36 w-28 items-center justify-center rounded-xl bg-white text-blue-300 shadow-sm">
                                    <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21"/></svg>
                                </div>
                            @endif
                            <span class="absolute left-4 top-4 rounded-full border border-white/80 bg-white/90 px-3 py-1 text-xs font-semibold text-blue-800 shadow-sm">{{ $item->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-slate-500">{{ $item->penulis }}</p>
                            <h2 class="mt-1 line-clamp-2 min-h-14 text-lg font-bold leading-7 text-slate-900">{{ $item->judul }}</h2>
                            <p class="mt-2 text-xs text-slate-500">{{ $item->penerbit }} <span class="mx-1 text-slate-300">•</span> {{ $item->tahun_terbit }}</p>
                        </div>
                        <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                            <span class="inline-flex items-center gap-2 text-xs font-semibold {{ $item->stok > 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                <span class="h-2 w-2 rounded-full {{ $item->stok > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $item->stok > 0 ? 'Tersedia · ' . $item->stok : 'Stok habis' }}
                            </span>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('siswa.koleksi.tambah', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" aria-label="Simpan {{ $item->judul }} ke koleksi" title="Simpan ke koleksi" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-amber-200 bg-amber-50 text-amber-700 transition hover:bg-amber-100 focus:outline-none focus:ring-4 focus:ring-amber-100">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>
                                    </button>
                                </form>
                                <a href="{{ route('siswa.detail', $item->id) }}" class="inline-flex items-center justify-center rounded-xl bg-blue-900 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">Detail</a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21"/></svg>
            </div>
            <h2 class="mt-5 text-lg font-bold text-slate-900">Buku belum ditemukan</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Coba gunakan kata kunci lain atau hapus filter untuk melihat seluruh katalog.</p>
            @if(request('search') || request('kategori'))
                <a href="{{ route('siswa.katalog') }}" class="mt-5 inline-flex rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950">Tampilkan semua buku</a>
            @endif
        </section>
    @endif
</div>
@endsection
