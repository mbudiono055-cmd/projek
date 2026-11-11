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
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700">Tersimpan untuk nanti</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Koleksi Saya</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">Buku-buku pilihanmu tersimpan rapi di satu tempat.</p>
        </div>
        <a href="{{ route('siswa.katalog') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4m-9-9h4m-2-2v4"/></svg>
            Jelajahi katalog
        </a>
    </header>

    @if($koleksi->isNotEmpty())
        <div class="flex items-center justify-between rounded-2xl border border-amber-100 bg-amber-50/70 px-5 py-4">
            <p class="text-sm text-slate-700">Kamu menyimpan <strong class="text-slate-900">{{ $koleksi->count() }} buku</strong> di koleksi.</p>
            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-amber-800 shadow-sm">Koleksi pribadi</span>
        </div>

        <section aria-label="Buku tersimpan" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($koleksi as $item)
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <a href="{{ route('siswa.detail', $item->buku->id) }}" class="block">
                        <div class="relative flex h-56 items-center justify-center overflow-hidden bg-gradient-to-br from-amber-50 to-blue-50 p-5">
                            @if($item->buku->gambar)
                                <img src="{{ asset('storage/' . $item->buku->gambar) }}" alt="Sampul {{ $item->buku->judul }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105" loading="lazy">
                            @else
                                <div class="flex h-32 w-24 items-center justify-center rounded-xl bg-white text-blue-300 shadow-sm">
                                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21"/></svg>
                                </div>
                            @endif
                            <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full border border-white/80 bg-white/90 px-3 py-1 text-xs font-semibold text-amber-800 shadow-sm">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>
                                Favorit
                            </span>
                        </div>
                    </a>
                    <div class="flex flex-1 flex-col p-5">
                        <p class="text-xs font-medium text-slate-500">{{ $item->buku->penulis }}</p>
                        <h2 class="mt-1 line-clamp-2 min-h-14 text-lg font-bold leading-7 text-slate-900">{{ $item->buku->judul }}</h2>
                        <p class="mt-2 text-xs text-slate-500">{{ $item->buku->penerbit }} <span class="mx-1 text-slate-300">•</span> {{ $item->buku->tahun_terbit }}</p>
                        <div class="mt-auto flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                            <span class="text-xs font-semibold {{ $item->buku->stok > 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $item->buku->stok > 0 ? 'Tersedia · ' . $item->buku->stok : 'Stok habis' }}
                            </span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('siswa.detail', $item->buku->id) }}" class="rounded-xl bg-blue-900 px-3.5 py-2.5 text-xs font-semibold text-white transition hover:bg-blue-950">Detail</a>
                                <form action="{{ route('siswa.koleksi.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini dari koleksi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Hapus {{ $item->buku->judul }} dari koleksi" title="Hapus dari koleksi" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-rose-200 text-rose-700 transition hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16m-10 4v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>
            </div>
            <h2 class="mt-5 text-lg font-bold text-slate-900">Koleksimu masih kosong</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Simpan buku yang menarik perhatianmu dari katalog. Buku tersebut akan muncul di halaman ini.</p>
            <a href="{{ route('siswa.katalog') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950">Temukan buku favorit</a>
        </section>
    @endif
</div>
@endsection
