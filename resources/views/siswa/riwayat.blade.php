@extends('layouts.siswa')

@section('content')
@php
    $statusStyles = [
        'menunggu' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'diterima' => 'bg-blue-50 text-blue-800 ring-blue-200',
        'ditolak' => 'bg-rose-50 text-rose-800 ring-rose-200',
        'terlambat' => 'bg-red-50 text-red-800 ring-red-200',
        'dikembalikan' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
    ];
    $statusLabels = [
        'menunggu' => 'Menunggu',
        'diterima' => 'Dipinjam',
        'ditolak' => 'Ditolak',
        'terlambat' => 'Terlambat',
        'dikembalikan' => 'Dikembalikan',
    ];
    $pinjamanAktif = $riwayat->whereIn('status', ['diterima', 'terlambat'])->count();
    $menunggu = $riwayat->where('status', 'menunggu')->count();
    $selesai = $riwayat->where('status', 'dikembalikan')->count();
@endphp

<div class="mx-auto max-w-7xl space-y-7">
    <header class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">Aktivitas membaca</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Riwayat Peminjaman</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Pantau status pengajuan dan catatan peminjaman buku kamu.</p>
        </div>
        <a href="{{ route('siswa.katalog') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">
            Cari buku
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4m-9-9h4m-2-2v4"/></svg>
        </a>
    </header>

    <section aria-label="Ringkasan peminjaman" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Total pengajuan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $riwayat->count() }}</p>
        </div>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
            <p class="text-xs font-medium text-amber-800">Menunggu persetujuan</p>
            <p class="mt-2 text-2xl font-bold text-amber-950">{{ $menunggu }}</p>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4">
            <p class="text-xs font-medium text-blue-800">Sedang dipinjam</p>
            <p class="mt-2 text-2xl font-bold text-blue-950">{{ $pinjamanAktif }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4">
            <p class="text-xs font-medium text-emerald-800">Sudah dikembalikan</p>
            <p class="mt-2 text-2xl font-bold text-emerald-950">{{ $selesai }}</p>
        </div>
    </section>

    @if($riwayat->isNotEmpty())
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="font-bold text-slate-900">Semua aktivitas</h2>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $riwayat->count() }} catatan peminjaman</p>
                </div>
                <span class="hidden rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 sm:inline-flex">Terbaru lebih dahulu</span>
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4">Buku</th>
                            <th scope="col" class="px-6 py-4">Tanggal pinjam</th>
                            <th scope="col" class="px-6 py-4">Tanggal kembali</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($riwayat as $item)
                            @php
                                $status = $item->status;
                                $canViewProof = in_array($status, ['diterima', 'terlambat', 'dikembalikan'], true);
                            @endphp
                            <tr class="transition hover:bg-slate-50/80">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $item->buku->judul ?? 'Buku tidak tersedia' }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $item->buku->penulis ?? '' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $statusStyles[$status] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($canViewProof)
                                        <a href="{{ route('siswa.bukti', $item->id) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-800">{{ $status === 'dikembalikan' ? 'Cetak bukti kembali' : 'Cetak bukti pinjam' }}</a>
                                    @else
                                        <span class="text-xs text-slate-400">Belum tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divide-y divide-slate-100 md:hidden">
                @foreach($riwayat as $item)
                    @php
                        $status = $item->status;
                        $canViewProof = in_array($status, ['diterima', 'terlambat', 'dikembalikan'], true);
                    @endphp
                    <article class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="font-semibold leading-5 text-slate-900">{{ $item->buku->judul ?? 'Buku tidak tersedia' }}</h3>
                                <p class="mt-1 text-xs text-slate-500">{{ $item->buku->penulis ?? '' }}</p>
                            </div>
                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $statusStyles[$status] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                {{ $statusLabels[$status] ?? ucfirst($status) }}
                            </span>
                        </div>
                        <dl class="mt-4 grid grid-cols-2 gap-3 rounded-xl bg-slate-50 p-3 text-xs">
                            <div>
                                <dt class="text-slate-500">Tanggal pinjam</dt>
                                <dd class="mt-1 font-semibold text-slate-800">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Tanggal kembali</dt>
                                <dd class="mt-1 font-semibold text-slate-800">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</dd>
                            </div>
                        </dl>
                        @if($canViewProof)
                            <a href="{{ route('siswa.bukti', $item->id) }}" class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-blue-50 hover:text-blue-800">{{ $status === 'dikembalikan' ? 'Cetak bukti pengembalian' : 'Cetak bukti peminjaman' }}</a>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @else
        <section class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm7 0v5h5m-9 5h5m-5 4h5"/></svg>
            </div>
            <h2 class="mt-5 text-lg font-bold text-slate-900">Belum ada riwayat peminjaman</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Saat kamu mengajukan peminjaman, status dan perkembangannya akan tercatat di halaman ini.</p>
            <a href="{{ route('siswa.katalog') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-950">Jelajahi katalog</a>
        </section>
    @endif
</div>
@endsection
