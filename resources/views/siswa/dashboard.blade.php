@extends('layouts.siswa')

@section('content')
<div class="mx-auto max-w-7xl space-y-8">
    @if(session('success') || session('error'))
        <div role="status" class="rounded-2xl border px-5 py-4 text-sm font-medium {{ session('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-rose-200 bg-rose-50 text-rose-800' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-800 px-6 py-8 text-white shadow-xl shadow-blue-950/10 sm:px-10 sm:py-10">
        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full bg-sky-300/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-indigo-300/10 blur-3xl"></div>
        <div class="relative flex flex-col gap-8 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.22em] text-sky-200">Ruang baca digitalmu</p>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Halo, {{ session('user_name') ?? 'Siswa' }}!</h1>
                <p class="mt-3 max-w-xl text-sm leading-6 text-blue-100 sm:text-base">
                    Temukan bacaan berikutnya, simpan buku favorit, dan pantau perjalanan membaca kamu di sini.
                </p>
                <a href="{{ route('siswa.katalog') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-blue-950 shadow-sm transition hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-white/30">
                    Jelajahi katalog
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
            </div>
            <div class="hidden h-36 w-36 shrink-0 items-center justify-center rounded-[2rem] border border-white/15 bg-white/10 sm:flex">
                <svg class="h-20 w-20 text-sky-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M12 7v14m0-14C10.7 5.9 9.1 5.5 7.5 5.5S4.3 5.9 3 7v13c1.3-1.1 2.9-1.5 4.5-1.5s3.2.4 4.5 1.5m0-13c1.3-1.1 2.9-1.5 4.5-1.5S20.7 5.9 22 7v13c-1.3-1.1-2.9-1.5-4.5-1.5s-3.2.4-4.5 1.5"/>
                </svg>
            </div>
        </div>
    </section>

    <section aria-label="Ringkasan aktivitas" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <a href="{{ route('siswa.katalog') }}" class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21m4-14h8m-8 4h8"/></svg>
                </span>
                <span class="text-xs font-semibold text-slate-400 transition group-hover:text-blue-700">Lihat katalog <span aria-hidden="true">→</span></span>
            </div>
            <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $totalBuku ?? 0 }}</p>
            <p class="mt-1 text-sm text-slate-500">Buku di katalog</p>
        </a>

        <a href="{{ route('siswa.buku.saya') }}" class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="M12 7v5l3 2"/></svg>
                </span>
                <span class="text-xs font-semibold text-slate-400 transition group-hover:text-amber-700">Lihat pinjaman <span aria-hidden="true">→</span></span>
            </div>
            <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $dipinjam ?? 0 }}</p>
            <p class="mt-1 text-sm text-slate-500">Buku sedang dipinjam</p>
        </a>

        <a href="{{ route('siswa.riwayat') }}" class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:col-span-2 xl:col-span-1">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 12 4 4L19 6"/><circle cx="12" cy="12" r="9"/></svg>
                </span>
                <span class="text-xs font-semibold text-slate-400 transition group-hover:text-emerald-700">Buka riwayat <span aria-hidden="true">→</span></span>
            </div>
            <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $dikembalikan ?? 0 }}</p>
            <p class="mt-1 text-sm text-slate-500">Buku sudah dikembalikan</p>
        </a>
    </section>

    <section>
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Pilihan terbaru</p>
                <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Buku untuk dijelajahi</h2>
            </div>
            <a href="{{ route('siswa.katalog') }}" class="shrink-0 text-sm font-semibold text-blue-800 hover:text-blue-950">Lihat semua <span aria-hidden="true">→</span></a>
        </div>

        @if(isset($bukuTerbaru) && $bukuTerbaru->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($bukuTerbaru as $buku)
                    <article class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <a href="{{ route('siswa.detail', $buku->id) }}" class="block">
                            <div class="flex h-52 items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 to-blue-50 p-5">
                                @if($buku->gambar)
                                    <img src="{{ asset('storage/' . $buku->gambar) }}" alt="Sampul {{ $buku->judul }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105" loading="lazy">
                                @else
                                    <div class="flex h-28 w-24 items-center justify-center rounded-xl bg-white text-blue-300 shadow-sm">
                                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5zm0 0V21"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <span class="text-xs font-medium text-slate-500">{{ $buku->penulis }}</span>
                                <h3 class="mt-1 line-clamp-2 min-h-12 font-semibold leading-6 text-slate-900 group-hover:text-blue-800">{{ $buku->judul }}</h3>
                                <p class="mt-3 text-xs font-medium {{ $buku->stok > 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                                    {{ $buku->stok > 0 ? 'Stok tersedia · ' . $buku->stok : 'Stok habis' }}
                                </p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
                <p class="font-semibold text-slate-800">Belum ada buku untuk ditampilkan</p>
                <p class="mt-1 text-sm text-slate-500">Buku terbaru akan muncul di sini setelah tersedia di katalog.</p>
            </div>
        @endif
    </section>

    <section class="flex flex-col gap-5 rounded-2xl border border-blue-100 bg-blue-50/70 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">Mulai membaca</p>
            <h2 class="mt-1 text-lg font-bold text-slate-900">Pilih buku, lalu ajukan peminjaman</h2>
            <p class="mt-1 text-sm text-slate-600">Buka detail buku di katalog untuk melihat stok dan mengisi pengajuan.</p>
        </div>
        <a href="{{ route('siswa.katalog') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">
            Cari buku
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.3-4.3M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/></svg>
        </a>
    </section>
</div>
@endsection
