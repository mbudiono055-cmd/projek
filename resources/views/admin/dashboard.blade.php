@extends('layouts.admin')

@section('content')

<!-- ================= WELCOME ================= -->
<div class="mb-8 flex items-center justify-between gap-4">
    <div>
        <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-blue-600">Dashboard Admin</p>
        <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">
            Selamat datang, {{ session('nama') ?? 'Admin' }}
        </h1>
        <p class="mt-2 text-sm text-slate-500 sm:text-base">Pantau aktivitas perpustakaan dan kelola layanan hari ini.</p>
    </div>
    <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 sm:flex">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
    </div>
</div>

@if($menungguValidasiBuku > 0)
    <a href="{{ route('buku.index', ['status' => 'menunggu']) }}" class="mb-8 flex items-center justify-between gap-4 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-amber-900 transition hover:border-amber-300 hover:bg-amber-100">
        <div>
            <p class="font-semibold">Ada buku menunggu validasi</p>
            <p class="mt-1 text-sm text-amber-800">{{ $menungguValidasiBuku }} buku dari Petugas perlu ditinjau.</p>
        </div>
        <span class="shrink-0 rounded-xl bg-amber-200 px-4 py-2 text-sm font-semibold">Tinjau buku</span>
    </a>
@endif

<!-- ================= STATISTIK ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-slate-500">Total Koleksi Buku</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700 transition group-hover:bg-blue-700 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800">{{ $totalBuku }}</h3>
    </div>

    <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-slate-500">Sedang Dipinjam</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-500 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800">{{ $dipinjam }}</h3>
    </div>

    <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-slate-500">Keterlambatan</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition group-hover:bg-rose-500 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m9.303 3.376c.866 1.5-.216 3.374-1.948 3.374H4.645c-1.732 0-2.814-1.874-1.948-3.374L10.052 3.75c.866-1.5 3.03-1.5 3.896 0l7.355 12.376zM12 16.5h.008v.008H12V16.5z" /></svg>
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800">{{ $terlambat }}</h3>
    </div>

    <div class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-slate-500">Total Petugas</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-500 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M14 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800">{{ $totalPetugas }}</h3>
    </div>

</div>

<!-- ================= RIWAYAT TERBARU ================= -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between bg-blue-600">
        <div>
            <h2 class="text-lg font-semibold text-white">
                Riwayat Peminjaman Terbaru
            </h2>
            <p class="text-xs text-blue-100">
                Menampilkan 5 data terbaru
            </p>
        </div>

        <a href="{{ route('peminjaman.index') }}"
           class="px-4 py-2 text-xs font-semibold rounded-lg bg-white text-blue-600 hover:bg-blue-50 transition shadow-sm">
            Lihat Selengkapnya →
        </a>
    </div>

    @if($data->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">User</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-center">Jumlah</th>
                    <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-center">Tgl Kembali</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @foreach($data as $item)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-6 py-4 font-medium">
                        {{ $item->user->nama ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->buku->judul ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        {{ $item->jumlah }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($item->status == 'menunggu')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                Menunggu
                            </span>
                        @elseif($item->status == 'diterima')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Diterima
                            </span>
                        @elseif($item->status == 'ditolak')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                Ditolak
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600">
                                {{ ucfirst($item->status) }}
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <!-- EMPTY STATE -->
    <div class="py-12 text-center text-slate-400">
        <p class="text-sm">Belum ada riwayat peminjaman.</p>
    </div>
    @endif

</div>

</div>

@endsection
