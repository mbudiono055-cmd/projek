@extends('layouts.petugas')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700"><i data-feather="book-open" class="h-6 w-6"></i></div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Perpustakaan</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Data Buku</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola koleksi dan ketersediaan buku.</p>
            </div>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('petugas.buku.laporan.cetak', request()->only(['search', 'status'])) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-5 py-3 text-sm font-semibold text-blue-800 shadow-sm transition hover:bg-blue-50">
                <i data-feather="printer" class="h-4 w-4"></i>
                Cetak Laporan
            </a>
            <a href="{{ route('petugas.buku.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-900 hover:shadow-md">
                <i data-feather="plus" class="h-4 w-4"></i>
                Tambah Buku
            </a>
        </div>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('petugas.buku.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <label for="book-search" class="sr-only">Cari buku</label>
        <div class="relative flex-1">
            <i data-feather="search" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i>
            <input id="book-search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, penerbit, tahun, atau kategori..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>
        <label for="book-status" class="sr-only">Filter status validasi</label>
        <select id="book-status" name="status" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            <option value="">Semua status</option>
            <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu validasi</option>
            <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
            <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
        </select>
        <button type="submit" class="rounded-xl bg-blue-800 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Cari Buku</button>
        @if(request('search') || request('status'))
            <a href="{{ route('petugas.buku.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div><h2 class="font-semibold text-slate-800">Koleksi Buku</h2><p class="text-sm text-slate-500">{{ $buku->total() }} buku ditemukan</p></div>
            <span class="text-xs font-medium text-slate-400">Halaman {{ $buku->currentPage() }} dari {{ max($buku->lastPage(), 1) }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-blue-950 text-xs uppercase tracking-wider text-blue-100">
                    <tr><th class="px-5 py-4 font-semibold">No</th><th class="px-5 py-4 font-semibold">Buku</th><th class="px-5 py-4 font-semibold">Kategori</th><th class="px-5 py-4 font-semibold">Tahun</th><th class="px-5 py-4 text-center font-semibold">Stok</th><th class="px-5 py-4 font-semibold">Validasi</th><th class="px-5 py-4 text-right font-semibold">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($buku as $item)
                        <tr class="transition hover:bg-blue-50/50">
                            <td class="whitespace-nowrap px-5 py-4 text-slate-400">{{ $buku->firstItem() + $loop->index }}</td>
                            <td class="min-w-64 px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="h-14 w-11 rounded-lg object-cover shadow-sm ring-1 ring-slate-200">
                                    @else
                                        <span class="flex h-14 w-11 items-center justify-center rounded-lg bg-blue-50 text-blue-700"><i data-feather="book" class="h-5 w-5"></i></span>
                                    @endif
                                    <div><p class="font-semibold text-slate-800">{{ $item->judul }}</p><p class="mt-0.5 text-xs text-slate-500">{{ $item->penulis }}</p></div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">{{ $item->tahun_terbit }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-center"><span class="inline-flex min-w-10 justify-center rounded-full {{ $item->stok > 0 ? 'bg-blue-50 text-blue-800' : 'bg-rose-50 text-rose-700' }} px-3 py-1 text-xs font-bold">{{ $item->stok }}</span></td>
                            <td class="whitespace-nowrap px-5 py-4">
                                @if($item->status_validasi === \App\Models\Buku::STATUS_MENUNGGU)
                                    <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">Menunggu Admin</span>
                                @elseif($item->status_validasi === \App\Models\Buku::STATUS_DISETUJUI)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">Disetujui</span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">Ditolak</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('petugas.buku.edit', $item->id) }}" class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-800 transition hover:bg-blue-50">Edit</a>
                                    <form action="{{ route('petugas.buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-14 text-center"><p class="font-semibold text-slate-700">{{ request('search') ? 'Buku tidak ditemukan' : 'Belum ada data buku' }}</p><p class="mt-1 text-sm text-slate-500">Coba kata kunci lain atau tambahkan buku ke koleksi.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($buku->hasPages())
            <div class="border-t border-slate-100 bg-slate-50 px-5 py-4">{{ $buku->links() }}</div>
        @endif
    </section>
</div>
<script>feather.replace();</script>
@endsection
