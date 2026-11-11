@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14H4V6a1 1 0 011-1z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Aktivitas</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Riwayat Peminjaman</h1>
                <p class="mt-1 text-sm text-slate-500">Cari transaksi berdasarkan peminjam, buku, atau status.</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('peminjaman.laporan.cetak', array_merge(request()->only('search'), ['jenis' => 'peminjaman'])) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-4 py-3 text-sm font-semibold text-blue-800 shadow-sm transition hover:bg-blue-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5h-2M6 14h12v8H6z" /></svg>
                Cetak Peminjaman
            </a>
            <a href="{{ route('peminjaman.laporan.cetak', array_merge(request()->only('search'), ['jenis' => 'pengembalian'])) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-white px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm transition hover:bg-emerald-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5h-2M6 14h12v8H6z" /></svg>
                Cetak Pengembalian
            </a>
            <a href="{{ route('peminjaman.laporan.cetak', request()->only(['search', 'status'])) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-950">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5h-2M6 14h12v8H6z" /></svg>
                Cetak Semua
            </a>
        </div>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('peminjaman.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:flex-row">
        <label for="loan-search" class="sr-only">Cari peminjaman</label>
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8" /><path stroke-linecap="round" stroke-width="1.8" d="m20 20-4-4" /></svg>
            <input id="loan-search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, email, judul buku, atau status..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>
        <label for="loan-status" class="sr-only">Filter status</label>
        <select id="loan-status" name="status" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            <option value="">Semua status</option>
            <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
            <option value="diterima" @selected(request('status') === 'diterima')>Disetujui</option>
            <option value="terlambat" @selected(request('status') === 'terlambat')>Terlambat</option>
            <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
            <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
        </select>
        <button type="submit" class="rounded-xl bg-blue-800 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Terapkan</button>
        @if(request('search') || request('status'))
            <a href="{{ route('peminjaman.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h2 class="font-semibold text-slate-800">Daftar Transaksi</h2>
            <p class="text-sm text-slate-500">{{ $data->total() }} transaksi ditemukan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-blue-950 text-xs uppercase tracking-wider text-blue-100">
                    <tr>
                        <th class="px-5 py-4 text-center font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Peminjam</th>
                        <th class="px-5 py-4 text-left font-semibold">Buku</th>
                        <th class="px-5 py-4 text-center font-semibold">Jumlah</th>
                        <th class="px-5 py-4 text-center font-semibold">Tanggal Pinjam</th>
                        <th class="px-5 py-4 text-center font-semibold">Tanggal Kembali</th>
                        <th class="px-5 py-4 text-center font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $item)
                        <tr class="transition hover:bg-blue-50/50">
                            <td class="whitespace-nowrap px-5 py-4 text-center text-slate-400">{{ $data->firstItem() + $loop->index }}</td>
                            <td class="min-w-48 px-5 py-4">
                                <p class="font-semibold text-slate-800">{{ $item->user->nama ?? '-' }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">{{ $item->user->email ?? '' }}</p>
                            </td>
                            <td class="min-w-48 px-5 py-4 font-medium text-slate-700">{{ $item->buku->judul ?? '-' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-center"><span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $item->jumlah }}</span></td>
                            <td class="whitespace-nowrap px-5 py-4 text-center text-slate-600">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-center text-slate-600">{{ $item->tanggal_kembali->format('d M Y') }}</td>
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
                        <tr><td colspan="7" class="px-6 py-14 text-center">
                            <p class="font-semibold text-slate-700">{{ request('search') || request('status') ? 'Transaksi tidak ditemukan' : 'Belum ada riwayat peminjaman' }}</p>
                            <p class="mt-1 text-sm text-slate-500">Ubah kata kunci atau status filter untuk mencoba lagi.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
            <div class="border-t border-slate-100 bg-slate-50 px-5 py-4">{{ $data->links() }}</div>
        @endif
    </section>
</div>
@endsection
