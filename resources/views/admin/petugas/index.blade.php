@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M14 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Pengguna</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Data Petugas</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola akun petugas yang membantu operasional.</p>
            </div>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('petugas.laporan.cetak', request()->only('search')) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-5 py-3 text-sm font-semibold text-blue-800 shadow-sm transition hover:bg-blue-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5h-2M6 14h12v8H6z" /></svg>
                Cetak Laporan
            </a>
            <a href="{{ route('petugas.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-900 hover:shadow-md">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Petugas
            </a>
        </div>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('petugas.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <label for="staff-search" class="sr-only">Cari petugas</label>
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8" /><path stroke-linecap="round" stroke-width="1.8" d="m20 20-4-4" /></svg>
            <input id="staff-search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau email petugas..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>
        <button type="submit" class="rounded-xl bg-blue-800 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Cari Petugas</button>
        @if(request('search'))
            <a href="{{ route('petugas.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h2 class="font-semibold text-slate-800">Daftar Petugas</h2>
            <p class="text-sm text-slate-500">{{ $petugas->total() }} petugas ditemukan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-blue-950 text-xs uppercase tracking-wider text-blue-100">
                    <tr><th class="px-5 py-4 font-semibold">No</th><th class="px-5 py-4 font-semibold">Nama Petugas</th><th class="px-5 py-4 font-semibold">Email</th><th class="px-5 py-4 text-right font-semibold">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($petugas as $p)
                        <tr class="transition hover:bg-blue-50/50">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $petugas->firstItem() + $loop->index }}</td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-800">{{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}</span>
                                    <span class="font-semibold text-slate-800">{{ $p->nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $p->email }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('petugas.edit', $p->id) }}" class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-800 transition hover:bg-blue-50">Edit</a>
                                    <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus petugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-14 text-center">
                            <p class="font-semibold text-slate-700">{{ request('search') ? 'Petugas tidak ditemukan' : 'Belum ada data petugas' }}</p>
                            <p class="mt-1 text-sm text-slate-500">Coba kata kunci lain atau tambahkan petugas baru.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($petugas->hasPages())
            <div class="border-t border-slate-100 bg-slate-50 px-5 py-4">{{ $petugas->links() }}</div>
        @endif
    </section>
</div>
@endsection
