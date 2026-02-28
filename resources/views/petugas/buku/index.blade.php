@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">📚 Data Buku</h2>

        <a href="{{ route('petugas.buku.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Gambar</th>
                    <th class="px-6 py-4 text-left">Judul</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Tahun</th>
                    <th class="px-6 py-4 text-left">Stok</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($buku as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>

                    <td class="px-6 py-4">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}"
                                 class="w-14 h-20 object-cover rounded shadow">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 font-semibold">{{ $item->judul }}</td>
                    <td class="px-6 py-4">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $item->tahun_terbit }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs">
                            {{ $item->stok }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('petugas.buku.edit', $item->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded-lg transition">
                            Edit
                        </a>

                        <form action="{{ route('petugas.buku.destroy', $item->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus buku ini?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-lg transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
