@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3 2.75 5.57 6.15.9-4.45 4.33 1.05 6.12L12 17.03l-5.5 2.89 1.05-6.12L3.1 9.47l6.15-.9L12 3z" /></svg>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Umpan Balik</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Manajemen Ulasan</h1>
            <p class="mt-1 text-sm text-slate-500">Temukan dan moderasi ulasan dari siswa.</p>
        </div>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.ulasan.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <label for="review-search" class="sr-only">Cari ulasan</label>
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8" /><path stroke-linecap="round" stroke-width="1.8" d="m20 20-4-4" /></svg>
            <input id="review-search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, judul buku, komentar, atau rating..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        </div>
        <button type="submit" class="rounded-xl bg-blue-800 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">Cari Ulasan</button>
        @if(request('search'))
            <a href="{{ route('admin.ulasan.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h2 class="font-semibold text-slate-800">Ulasan Siswa</h2>
            <p class="text-sm text-slate-500">{{ $ulasans->total() }} ulasan ditemukan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-blue-950 text-xs uppercase tracking-wider text-blue-100">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Siswa</th>
                        <th class="px-5 py-4 font-semibold">Buku</th>
                        <th class="px-5 py-4 font-semibold">Rating</th>
                        <th class="px-5 py-4 font-semibold">Komentar</th>
                        <th class="px-5 py-4 font-semibold">Tanggal</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($ulasans as $ulasan)
                        <tr class="transition hover:bg-blue-50/50">
                            <td class="min-w-52 px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 font-bold text-blue-800">{{ strtoupper(substr(optional($ulasan->user)->nama ?? 'U', 0, 1)) }}</span>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ optional($ulasan->user)->nama ?? 'User Tidak Ditemukan' }}</p>
                                        <p class="mt-0.5 text-xs text-slate-500">{{ optional($ulasan->user)->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="min-w-48 px-5 py-4 font-medium text-slate-700">{{ optional($ulasan->buku)->judul ?? '-' }}</td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-amber-400" aria-label="Rating {{ $ulasan->rating }} dari 5">@for($i=1; $i<=5; $i++){{ $i <= $ulasan->rating ? '★' : '☆' }}@endfor</span>
                                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-800">{{ $ulasan->rating }}/5</span>
                                </div>
                            </td>
                            <td class="min-w-64 max-w-sm px-5 py-4 text-slate-600">
                                <details class="cursor-pointer">
                                    <summary class="truncate marker:text-blue-600">{{ Str::limit($ulasan->komentar, 60) }}</summary>
                                    <p class="mt-2 whitespace-normal text-sm leading-relaxed text-slate-500">{{ $ulasan->komentar }}</p>
                                </details>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-slate-500">{{ $ulasan->created_at->format('d M Y') }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-14 text-center">
                            <p class="font-semibold text-slate-700">{{ request('search') ? 'Ulasan tidak ditemukan' : 'Belum ada ulasan' }}</p>
                            <p class="mt-1 text-sm text-slate-500">Coba kata kunci lain atau periksa kembali nanti.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($ulasans->hasPages())
            <div class="border-t border-slate-100 bg-slate-50 px-5 py-4">{{ $ulasans->links() }}</div>
        @endif
    </section>
</div>
@endsection
