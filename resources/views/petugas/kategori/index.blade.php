@extends('layouts.petugas')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700"><i data-feather="layers" class="h-6 w-6"></i></div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Koleksi</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Data Kategori</h1>
                <p class="mt-1 text-sm text-slate-500">Atur kategori agar koleksi mudah dijelajahi.</p>
            </div>
        </div>
        <a href="{{ route('petugas.kategori.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-900 hover:shadow-md">
            <i data-feather="plus" class="h-4 w-4"></i>
            Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('petugas.kategori.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <label for="category-search" class="sr-only">Cari kategori</label>
        <div class="relative flex-1">
            <i data-feather="search" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i>
            <input id="category-search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi kategori..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>
        <button type="submit" class="rounded-xl bg-blue-800 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Cari Kategori</button>
        @if(request('search'))
            <a href="{{ route('petugas.kategori.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6"><h2 class="font-semibold text-slate-800">Daftar Kategori</h2><p class="text-sm text-slate-500">{{ $data->total() }} kategori ditemukan</p></div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-blue-950 text-xs uppercase tracking-wider text-blue-100">
                    <tr><th class="px-5 py-4 font-semibold">No</th><th class="px-5 py-4 font-semibold">Kategori</th><th class="px-5 py-4 text-center font-semibold">Jumlah Buku</th><th class="px-5 py-4 text-right font-semibold">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $k)
                        <tr class="transition hover:bg-blue-50/50">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $data->firstItem() + $loop->index }}</td>
                            <td class="min-w-72 px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700"><i data-feather="book" class="h-5 w-5"></i></span>
                                    <div><p class="font-semibold text-slate-800">{{ $k->nama_kategori }}</p><p class="mt-1 max-w-xl text-xs leading-relaxed text-slate-500">{{ $k->deskripsi ?: 'Belum ada deskripsi untuk kategori ini.' }}</p></div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-center"><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $k->buku_count }} buku</span></td>
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('petugas.kategori.edit', $k->id) }}" class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-800 transition hover:bg-blue-50">Edit</a>
                                    <form action="{{ route('petugas.kategori.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-14 text-center"><p class="font-semibold text-slate-700">{{ request('search') ? 'Kategori tidak ditemukan' : 'Belum ada data kategori' }}</p><p class="mt-1 text-sm text-slate-500">Coba kata kunci lain atau tambahkan kategori baru.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
            <div class="border-t border-slate-100 bg-slate-50 px-5 py-4">{{ $data->links() }}</div>
        @endif
    </section>
</div>
<script>feather.replace();</script>
@endsection
