@extends('layouts.petugas')

@section('content')
<div class="mx-auto max-w-7xl space-y-8">
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 px-6 py-7 text-white shadow-lg sm:px-9 sm:py-9">
        <div class="absolute -right-10 -top-20 h-64 w-64 rounded-full border-[40px] border-white/5"></div>
        <div class="absolute -bottom-28 right-1/3 h-56 w-56 rounded-full bg-blue-400/10 blur-3xl"></div>
        <div class="relative flex flex-col gap-7 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-blue-200">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    Ruang Kerja Petugas
                </p>
                <h1 class="text-2xl font-bold tracking-tight sm:text-4xl">Halo, {{ session('user_name') ?? 'Petugas' }}.</h1>
                <p class="mt-2 max-w-xl text-sm leading-relaxed text-blue-100/80 sm:text-base">Pantau koleksi dan tangani peminjaman dari satu tempat.</p>
            </div>
            <a href="{{ route('petugas.peminjaman.index', ['status' => 'menunggu']) }}" class="inline-flex items-center justify-between gap-6 rounded-2xl border border-white/15 bg-white/10 px-4 py-3 transition hover:bg-white/15">
                <span class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-300/15 text-amber-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    <span class="text-left"><span class="block text-xs text-blue-100/70">Perlu ditinjau</span><span class="mt-0.5 block text-sm font-semibold">Permintaan peminjaman</span></span>
                </span>
                <span class="flex h-8 min-w-8 items-center justify-center rounded-full bg-amber-300 px-2 text-sm font-bold text-blue-950">{{ $menunggu }}</span>
            </a>
        </div>
        <div class="relative mt-7 flex items-center gap-2 text-xs text-blue-100/70">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z" /></svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div><p class="text-sm font-medium text-slate-500">Total Koleksi</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-800">{{ $totalBuku }}</p><p class="mt-1 text-xs text-slate-400">Judul buku terdaftar</p></div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700 transition group-hover:bg-blue-800 group-hover:text-white"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.51 4.5 1.385m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.51-4.5 1.385" /></svg></span>
            </div>
        </div>
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div><p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-800">{{ $dipinjam }}</p><p class="mt-1 text-xs text-slate-400">Buku masih dipinjam</p></div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 transition group-hover:bg-indigo-700 group-hover:text-white"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
            </div>
        </div>
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div><p class="text-sm font-medium text-slate-500">Terlambat</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-800">{{ $terlambat }}</p><p class="mt-1 text-xs text-slate-400">Perlu tindak lanjut</p></div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition group-hover:bg-rose-500 group-hover:text-white"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m9.303 3.376c.866 1.5-.216 3.374-1.948 3.374H4.645c-1.732 0-2.814-1.874-1.948-3.374L10.052 3.75c.866-1.5 3.03-1.5 3.896 0l7.355 12.376zM12 16.5h.008v.008H12V16.5z" /></svg></span>
            </div>
        </div>
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div><p class="text-sm font-medium text-slate-500">Menunggu Validasi</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-800">{{ $menunggu }}</p><p class="mt-1 text-xs text-slate-400">Permintaan baru</p></div>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-500 group-hover:text-white"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
            </div>
        </div>
    </section>

    <section>
        <div class="mb-4 flex items-center justify-between">
            <div><h2 class="text-lg font-bold text-slate-800">Akses Cepat</h2><p class="mt-1 text-sm text-slate-500">Langsung ke pekerjaan yang sering digunakan.</p></div>
        </div>
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <a href="{{ route('petugas.buku.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-800"><i data-feather="book-open" class="h-5 w-5"></i></span>
                <span class="min-w-0 flex-1"><span class="block font-semibold text-slate-800">Data Buku</span><span class="mt-0.5 block text-xs text-slate-500">Kelola koleksi</span></span>
                <i data-feather="arrow-up-right" class="h-4 w-4 text-slate-400 transition group-hover:text-blue-700"></i>
            </a>
            <a href="{{ route('petugas.kategori.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-800"><i data-feather="layers" class="h-5 w-5"></i></span>
                <span class="min-w-0 flex-1"><span class="block font-semibold text-slate-800">Kategori</span><span class="mt-0.5 block text-xs text-slate-500">Atur kategori buku</span></span>
                <i data-feather="arrow-up-right" class="h-4 w-4 text-slate-400 transition group-hover:text-blue-700"></i>
            </a>
            <a href="{{ route('petugas.peminjaman.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700"><i data-feather="clipboard" class="h-5 w-5"></i></span>
                <span class="min-w-0 flex-1"><span class="block font-semibold text-slate-800">Validasi</span><span class="mt-0.5 block text-xs text-slate-500">Proses peminjaman</span></span>
                <i data-feather="arrow-up-right" class="h-4 w-4 text-slate-400 transition group-hover:text-blue-700"></i>
            </a>
            <a href="{{ route('petugas.ulasan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-700"><i data-feather="message-square" class="h-5 w-5"></i></span>
                <span class="min-w-0 flex-1"><span class="block font-semibold text-slate-800">Ulasan</span><span class="mt-0.5 block text-xs text-slate-500">Lihat masukan siswa</span></span>
                <i data-feather="arrow-up-right" class="h-4 w-4 text-slate-400 transition group-hover:text-blue-700"></i>
            </a>
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-blue-600">Aktivitas terbaru</p>
                <h2 class="mt-1 text-lg font-bold text-slate-800">Peminjaman Terbaru</h2>
                <p class="text-sm text-slate-500">5 transaksi terakhir di perpustakaan.</p>
            </div>
            <a href="{{ route('petugas.peminjaman.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 px-4 py-2.5 text-sm font-semibold text-blue-900 transition hover:bg-blue-50">
                Semua Peminjaman
                <i data-feather="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr><th class="px-5 py-3 text-left font-semibold">Peminjam</th><th class="px-5 py-3 text-left font-semibold">Buku</th><th class="px-5 py-3 text-center font-semibold">Jumlah</th><th class="px-5 py-3 text-center font-semibold">Tanggal Pinjam</th><th class="px-5 py-3 text-center font-semibold">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $item)
                        <tr class="transition hover:bg-blue-50/40">
                            <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-800">{{ $item->user->nama ?? '-' }}</td>
                            <td class="min-w-48 px-5 py-4 text-slate-600">{{ $item->buku->judul ?? '-' }}</td>
                            <td class="px-5 py-4 text-center"><span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $item->jumlah }}</span></td>
                            <td class="whitespace-nowrap px-5 py-4 text-center text-slate-500">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-center">
                                @if($item->status == 'menunggu')
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                                @elseif($item->status == 'diterima')
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">Ditolak</span>
                                @elseif($item->status == 'terlambat')
                                    <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700">Terlambat</span>
                                @else
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center"><p class="font-semibold text-slate-700">Belum ada aktivitas peminjaman</p><p class="mt-1 text-sm text-slate-500">Transaksi terbaru akan muncul di sini.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
<script>feather.replace();</script>
@endsection
