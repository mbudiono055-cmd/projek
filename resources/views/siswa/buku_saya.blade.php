@extends('layouts.siswa')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800">
            Buku Saya
        </h2>
        <p class="text-slate-500 mt-1">
            Lihat pengajuan dan peminjaman buku yang masih aktif.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4 text-left">Judul</th>
                        <th class="px-6 py-4 text-center">Jumlah</th>
                        <th class="px-6 py-4 text-center">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-center">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition duration-200">
                            <td class="px-6 py-4 text-center font-semibold text-slate-600">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $item->buku->judul }}
                            </td>
                            <td class="px-6 py-4 text-center text-slate-600">
                                {{ $item->jumlah }}
                            </td>
                            <td class="px-6 py-4 text-center text-slate-500">
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center text-slate-500">
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status === 'menunggu')
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                        Menunggu
                                    </span>
                                @elseif($item->status === 'terlambat')
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                        Terlambat
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status === 'menunggu')
                                    <form action="{{ route('siswa.batal', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Batalkan pengajuan peminjaman ini?')"
                                                class="px-3 py-1 text-xs bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                                            Batalkan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('siswa.bukti', $item->id) }}"
                                       class="px-3 py-1 text-xs bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                        Cetak bukti pinjam
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <p class="text-lg font-semibold">Belum ada peminjaman aktif</p>
                                    <p class="text-sm mt-2">Buku yang diajukan atau sedang dipinjam akan muncul di sini.</p>
                                    <a href="{{ route('siswa.katalog') }}"
                                       class="mt-4 px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                        Lihat katalog
                                    </a>
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
