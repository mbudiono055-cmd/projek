@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-4">

    <!-- HEADER -->
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                Manajemen Ulasan
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Kelola dan moderasi ulasan dari siswa
            </p>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-blue-100 border border-blue-200 text-blue-700 rounded-2xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE CARD -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">

                <!-- TABLE HEAD -->
                <thead class="bg-gradient-to-r from-blue-700 to-blue-600 text-white text-xs uppercase tracking-wider">
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

                <!-- TABLE BODY -->
                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($ulasans as $ulasan)
                    <tr class="hover:bg-blue-50/50 transition duration-200">

                        <!-- SISWA -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-600 text-white flex items-center justify-center rounded-full font-bold text-sm shadow">
                                    {{ strtoupper(substr(optional($ulasan->user)->nama ?? 'U', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-slate-700">
                                    {{ optional($ulasan->user)->nama ?? 'User Tidak Ditemukan' }}
                                </span>
                            </div>
                        </td>

                        <!-- EMAIL -->
                        <td class="px-6 py-4 text-slate-500 text-sm">
                            {{ optional($ulasan->user)->email ?? '-' }}
                        </td>

                        <!-- BUKU -->
                        <td class="px-6 py-4 text-slate-700 font-medium">
                            {{ optional($ulasan->buku)->judul }}
                        </td>

                        <!-- RATING -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="text-yellow-400 text-base">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $ulasan->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-semibold">
                                    {{ $ulasan->rating }}/5
                                </span>
                            </div>
                        </td>

                        <!-- KOMENTAR -->
                        <td class="px-6 py-4 text-slate-600 max-w-sm">
                            <details class="cursor-pointer">
                                <summary class="truncate">
                                    {{ Str::limit($ulasan->komentar, 50) }}
                                </summary>
                                <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                                    {{ $ulasan->komentar }}
                                </p>
                            </details>
                        </td>

                        <!-- TANGGAL -->
                        <td class="px-6 py-4 text-slate-400 text-sm">
                            {{ $ulasan->created_at->format('d M Y') }}
                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-semibold transition shadow">
                                    Hapus
                                </button>
                            </form>
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

        <!-- PAGINATION -->
        <div class="p-6 border-t border-slate-100 bg-slate-50">
            {{ $ulasans->links() }}
        </div>

    </div>

</div>

@endsection
