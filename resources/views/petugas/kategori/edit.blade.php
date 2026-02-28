@extends('layouts.petugas')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

        <h1 class="text-2xl font-bold text-indigo-700 mb-6">
            Edit Kategori
        </h1>

        <form action="{{ route('petugas.kategori.update', $data->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Nama Kategori
                </label>
                <input
                    type="text"
                    name="nama_kategori"
                    value="{{ $data->nama_kategori }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition"
                    placeholder="Masukkan nama kategori"
                    required
                >
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl shadow-md transition">
                    Update
                </button>

                <a href="{{ route('petugas.kategori.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-xl transition">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
