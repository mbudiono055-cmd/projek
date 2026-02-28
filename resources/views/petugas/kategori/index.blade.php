@extends('layouts.petugas')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">📂 Data Kategori</h2>

        <a href="{{ route('petugas.kategori.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-blue-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama Kategori</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($data as $k)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $k->nama_kategori }}
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('petugas.kategori.edit',$k->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded-lg transition">
                            Edit
                        </a>

                        <form action="{{ route('petugas.kategori.destroy',$k->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus kategori ini?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-lg transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-8 text-gray-400">
                        Belum ada data kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
