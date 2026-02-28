@extends('layouts.siswa')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800">
            🕒 Riwayat Peminjaman
        </h2>
        <p class="text-slate-500 mt-1">
            Lihat semua aktivitas peminjaman buku yang pernah Anda lakukan.
        </p>
    </div>

    <!-- Card Table -->
    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- Table Head -->
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4 text-left">Judul</th>
                        <th class="px-6 py-4 text-center">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-center">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Bukti</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-slate-100">

                    @forelse($riwayat as $index => $item)
                    <tr class="hover:bg-slate-50 transition duration-200">

                        <!-- No -->
                        <td class="px-6 py-4 text-center font-semibold text-slate-600">
                            {{ $index + 1 }}
                        </td>

                        <!-- Judul -->
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $item->buku->judul }}
                        </td>

                        <!-- Tanggal Pinjam -->
                        <td class="px-6 py-4 text-center text-slate-500">
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                        </td>

                        <!-- Tanggal Kembali -->
                        <td class="px-6 py-4 text-center text-slate-500">
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'menunggu')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    Menunggu
                                </span>

                            @elseif($item->status == 'diterima')
                                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                                    Dipinjam
                                </span>

                            @elseif($item->status == 'ditolak')
                                <span class="px-3 py-1 text-xs rounded-full bg-rose-100 text-rose-700 font-semibold">
                                    Ditolak
                                </span>

                            @elseif($item->status == 'terlambat')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                    Terlambat
                                </span>

                            @elseif($item->status == 'dikembalikan')
                                <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 font-semibold">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>

                        <!-- Bukti -->
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'diterima' || $item->status == 'terlambat' || $item->status == 'dikembalikan')
                                <a href="{{ route('siswa.bukti', $item->id) }}"
                                   class="px-3 py-1 text-xs bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    Lihat
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <div class="text-5xl mb-4">📚</div>
                                <p class="text-lg font-semibold">
                                    Belum ada riwayat peminjaman
                                </p>
                                <p class="text-sm mt-2">
                                    Silakan pinjam buku terlebih dahulu dari katalog.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
