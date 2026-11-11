@extends('layouts.siswa')

@section('content')
@php
    $averageRating = $buku->ulasans->count() > 0 ? $buku->ulasans->avg('rating') : null;
@endphp

<div class="mx-auto max-w-6xl space-y-7">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('siswa.katalog') }}" class="font-medium transition hover:text-blue-800">Katalog Buku</a>
        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6"/></svg>
        <span class="truncate font-medium text-slate-800" aria-current="page">{{ $buku->judul }}</span>
    </nav>

    @if(session('success') || session('error'))
        <div role="status" class="rounded-2xl border px-5 py-4 text-sm font-medium {{ session('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-rose-200 bg-rose-50 text-rose-800' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div role="alert" class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
            <p class="font-semibold">Periksa kembali pengajuanmu:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white shadow-sm">
        <div class="grid lg:grid-cols-[0.85fr_1.15fr]">
            <div class="relative flex min-h-[22rem] items-center justify-center overflow-hidden bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100 p-8 sm:p-12 lg:min-h-[38rem]">
                <div class="pointer-events-none absolute -left-16 top-10 h-48 w-48 rounded-full bg-blue-200/30 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-16 right-0 h-56 w-56 rounded-full bg-indigo-200/30 blur-3xl"></div>
                <div class="absolute left-5 top-5 inline-flex items-center gap-2 rounded-full border border-white/80 bg-white/90 px-3.5 py-2 text-xs font-semibold shadow-sm backdrop-blur sm:left-7 sm:top-7">
                    <span class="h-2 w-2 rounded-full {{ $buku->stok > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                    <span class="{{ $buku->stok > 0 ? 'text-emerald-800' : 'text-rose-800' }}">
                        {{ $buku->stok > 0 ? 'Tersedia · ' . $buku->stok . ' buku' : 'Stok habis' }}
                    </span>
                </div>

                <div class="relative flex h-80 w-full max-w-[17rem] items-center justify-center sm:h-[26rem] sm:max-w-[19rem]">
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}" alt="Sampul buku {{ $buku->judul }}" class="h-full w-full rounded-2xl object-contain drop-shadow-2xl" fetchpriority="high">
                    @else
                        <div class="flex aspect-[2/3] h-full max-h-80 w-auto items-center justify-center rounded-2xl border border-white bg-white/80 text-blue-300 shadow-xl">
                            <svg class="h-20 w-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21"/></svg>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col p-6 sm:p-9 lg:p-10">
                <div>
                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-800 ring-1 ring-inset ring-blue-100">
                        {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    <h1 class="mt-4 text-3xl font-bold leading-tight tracking-tight text-slate-950 sm:text-4xl">{{ $buku->judul }}</h1>
                    <p class="mt-3 text-base text-slate-600">oleh <span class="font-semibold text-slate-800">{{ $buku->penulis }}</span></p>

                    @if($averageRating !== null)
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <span class="text-lg font-bold text-slate-900">{{ number_format($averageRating, 1) }}</span>
                            <span class="flex items-center text-amber-500" aria-label="Rating rata-rata {{ number_format($averageRating, 1) }} dari 5">
                                @for($star = 1; $star <= 5; $star++)
                                    <svg class="h-4 w-4 {{ $star <= round($averageRating) ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>
                                @endfor
                            </span>
                            <span class="text-xs text-slate-500">dari {{ $buku->ulasans->count() }} ulasan</span>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-slate-500">Belum ada ulasan untuk buku ini.</p>
                    @endif
                </div>

                <dl class="mt-7 grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <dt class="text-xs font-medium text-slate-500">Penerbit</dt>
                        <dd class="mt-1.5 text-sm font-semibold text-slate-900">{{ $buku->penerbit }}</dd>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                        <dt class="text-xs font-medium text-slate-500">Tahun terbit</dt>
                        <dd class="mt-1.5 text-sm font-semibold text-slate-900">{{ $buku->tahun_terbit }}</dd>
                    </div>
                </dl>

                <div class="mt-7 rounded-2xl border border-blue-100 bg-blue-50/60 p-5">
                    <div class="mb-4">
                        <h2 class="font-bold text-slate-900">Ajukan peminjaman</h2>
                        <p class="mt-1 text-xs leading-5 text-slate-600">Pilih jumlah dan tanggal pengembalian yang kamu rencanakan.</p>
                    </div>

                    @if($buku->stok > 0)
                        <form action="{{ route('siswa.pinjam', $buku->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="jumlah" class="mb-1.5 block text-xs font-semibold text-slate-700">Jumlah buku</label>
                                    <input id="jumlah" type="number" name="jumlah" min="1" max="{{ $buku->stok }}" value="{{ old('jumlah', 1) }}" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    <p class="mt-1.5 text-xs text-slate-500">Maksimal {{ $buku->stok }} buku</p>
                                </div>
                                <div>
                                    <label for="tanggal_kembali" class="mb-1.5 block text-xs font-semibold text-slate-700">Tanggal pengembalian</label>
                                    <input id="tanggal_kembali" type="date" name="tanggal_kembali" min="{{ now()->toDateString() }}" value="{{ old('tanggal_kembali') }}" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    <p class="mt-1.5 text-xs text-slate-500">Pilih hari ini atau tanggal berikutnya</p>
                                </div>
                            </div>
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">
                                Ajukan peminjaman
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </button>
                        </form>
                    @else
                        <div class="rounded-xl border border-rose-200 bg-white px-4 py-4 text-sm text-rose-800">
                            Stok buku sedang habis, jadi pengajuan peminjaman belum tersedia.
                        </div>
                    @endif
                </div>

                <a href="{{ route('siswa.katalog') }}" class="mt-4 inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"/></svg>
                    Kembali ke katalog
                </a>
            </div>
        </div>
    </section>

    <section aria-labelledby="reviews-title" class="space-y-4">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Pengalaman pembaca</p>
                <h2 id="reviews-title" class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Ulasan buku</h2>
            </div>
            <span class="rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">{{ $buku->ulasans->count() }} ulasan</span>
        </div>

        @if($buku->ulasans->isNotEmpty())
            <div class="grid gap-4 lg:grid-cols-2">
                @foreach($buku->ulasans as $ulasan)
                    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-sm font-bold text-blue-800">
                                    {{ strtoupper(substr($ulasan->user->nama ?? 'S', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $ulasan->user->nama ?? 'Pembaca' }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ $ulasan->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-0.5 text-amber-500" aria-label="Rating {{ $ulasan->rating }} dari 5">
                                @for($star = 1; $star <= 5; $star++)
                                    <svg class="h-4 w-4 {{ $star <= $ulasan->rating ? 'fill-current' : 'fill-none text-slate-300' }}" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $ulasan->komentar }}</p>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>
                </div>
                <p class="mt-3 font-semibold text-slate-800">Belum ada ulasan</p>
                <p class="mt-1 text-sm text-slate-500">Jadilah pembaca pertama yang berbagi pengalaman tentang buku ini.</p>
            </div>
        @endif
    </section>
</div>
@endsection
