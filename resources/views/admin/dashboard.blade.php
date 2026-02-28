@extends('layouts.admin')

@section('content')

<!-- ================= WELCOME BANNER ================= -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 mb-8 text-white shadow-lg relative overflow-hidden">
    <div class="absolute right-0 top-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
        <i class="fa-solid fa-book-open-reader text-9xl"></i>
    </div>
    <h1 class="text-2xl font-bold mb-1">Selamat Datang Kembali! 👋</h1>
    <p class="opacity-90">Berikut adalah ringkasan aktivitas perpustakaan hari ini.</p>
</div>

<!-- ================= STATISTIK ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-blue-500">
        <p class="text-sm text-slate-500">Total Koleksi Buku</p>
        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalBuku }}</h3>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-yellow-500">
        <p class="text-sm text-slate-500">Sedang Dipinjam</p>
        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $dipinjam }}</h3>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-red-500">
        <p class="text-sm text-slate-500">Keterlambatan</p>
        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $terlambat }}</h3>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-green-500">
        <p class="text-sm text-slate-500">Total Petugas</p>
        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalPetugas }}</h3>
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
