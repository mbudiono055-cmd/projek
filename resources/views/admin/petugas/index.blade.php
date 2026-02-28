@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">👨‍💼 Data Petugas</h2>

        <a href="{{ route('petugas.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Tambah Petugas
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
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($petugas as $index => $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $p->nama }}
                    </td>
                    <td class="px-6 py-4">{{ $p->email }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('petugas.edit',$p->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded-lg transition">
                            Edit
                        </a>

                        <form action="{{ route('petugas.destroy',$p->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus petugas ini?')"
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
