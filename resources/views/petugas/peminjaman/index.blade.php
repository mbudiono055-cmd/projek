@extends('layouts.petugas')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-slate-800">
    Validasi Peminjaman
</h2>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-blue-600 text-white uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-center">No</th>
                    <th class="px-6 py-4 text-left">User</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-center">Jumlah</th>
                    <th class="px-6 py-4 text-center">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-center">Tanggal Kembali</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($data as $item)
                <tr class="hover:bg-slate-50 transition duration-200">

                    <!-- NO -->
                    <td class="px-6 py-4 text-center font-semibold text-slate-600">
                        {{ $loop->iteration }}
                    </td>

                    <!-- USER -->
                    <td class="px-6 py-4 font-medium text-slate-700">
                        {{ $item->user->nama ?? '-' }}
                    </td>

                    <!-- BUKU -->
                    <td class="px-6 py-4 text-slate-600">
                        {{ $item->buku->judul }}
                    </td>

                    <!-- JUMLAH -->
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-slate-100 rounded-md text-xs font-semibold">
                            {{ $item->jumlah }}
                        </span>
                    </td>

                    <!-- TANGGAL -->
                    <td class="px-6 py-4 text-center text-slate-500">
                        {{ $item->tanggal_pinjam->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4 text-center text-slate-500">
                        {{ $item->tanggal_kembali->format('d M Y') }}
                    </td>

                    <!-- STATUS -->
                    <td class="px-6 py-4 text-center">
                        @if($item->status == 'menunggu')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                Menunggu
                            </span>
                        @elseif($item->status == 'diterima')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                Disetujui
                            </span>
                        @elseif($item->status == 'ditolak')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">
                                Ditolak
                            </span>
                        @elseif($item->status == 'terlambat')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                Terlambat
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                Dikembalikan
                            </span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-4 text-center space-x-2">

                        @if($item->status == 'menunggu')

                            <form action="{{ route('petugas.peminjaman.verifikasi', [$item->id, 'terima']) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1 text-xs rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('petugas.peminjaman.verifikasi', [$item->id, 'tolak']) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1 text-xs rounded-lg bg-rose-600 text-white hover:bg-rose-700 transition shadow-sm">
                                    Tolak
                                </button>
                            </form>

                        @elseif($item->status == 'diterima' || $item->status == 'terlambat')

                            <form action="{{ route('petugas.peminjaman.verifikasi', [$item->id, 'kembali']) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1 text-xs rounded-lg bg-slate-700 text-white hover:bg-slate-800 transition shadow-sm">
                                    Kembalikan
                                </button>
                            </form>

                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600">
                                Selesai
                            </span>
                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-slate-400">
                        Belum ada data peminjaman 📚
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
