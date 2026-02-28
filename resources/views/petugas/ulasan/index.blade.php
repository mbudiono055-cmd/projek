@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-4">

    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-indigo-800 tracking-tight">
            Data Ulasan Siswa
        </h1>
        <p class="text-slate-500 mt-1 text-sm">
            Petugas dapat melihat ulasan buku dari siswa
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <thead class="bg-gradient-to-r from-indigo-700 to-indigo-600 text-white text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Komentar</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($ulasans as $ulasan)
                    <tr class="hover:bg-indigo-50/50 transition duration-200">

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-600 text-white flex items-center justify-center rounded-full font-bold text-sm shadow">
                                    {{ strtoupper(substr(optional($ulasan->user)->nama ?? 'U', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-slate-700">
                                    {{ optional($ulasan->user)->nama ?? 'User Tidak Ditemukan' }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-500 text-sm">
                            {{ optional($ulasan->user)->email ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-slate-700 font-medium">
                            {{ optional($ulasan->buku)->judul ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="text-yellow-400">
                                    @for($i=1; $i<=5; $i++)
                                        {{ $i <= $ulasan->rating ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">
                                    {{ $ulasan->rating }}/5
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-600 max-w-sm">
                            <details class="cursor-pointer">
                                <summary class="truncate">
                                    {{ \Illuminate\Support\Str::limit($ulasan->komentar, 50) }}
                                </summary>
                                <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                                    {{ $ulasan->komentar }}
                                </p>
                            </details>
                        </td>

                        <td class="px-6 py-4 text-slate-400 text-sm">
                            {{ $ulasan->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="text-slate-400 text-xs italic">
                                Tidak tersedia
                            </span>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-14 text-slate-400">
                            Belum ada ulasan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="p-6 border-t border-slate-100 bg-slate-50">
            {{ $ulasans->links() }}
        </div>

    </div>

</div>

@endsection