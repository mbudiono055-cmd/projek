@extends('layouts.admin')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl bg-white p-10 rounded-2xl shadow-xl">

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">
            ✏️ Edit Buku
        </h2>

        <form action="{{ route('buku.update', $buku->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-2">Judul</label>
                <input type="text" name="judul"
                       value="{{ $buku->judul }}"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">penulis</label>
                <input type="text" name="penulis"
                       value="{{ $buku->penulis }}"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Penerbit</label>
                <input type="text" name="penerbit"
                       value="{{ $buku->penerbit }}"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Kategori</label>
                <select name="kategori_id"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}"
                            {{ $buku->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit"
                       value="{{ $buku->tahun_terbit }}"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Stok</label>
                <input type="number" name="stok"
                       value="{{ $buku->stok }}"
                       class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Gambar</label>
                <input type="file" name="gambar"
                       class="w-full border rounded-lg px-4 py-2">

                @if($buku->gambar)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Preview Gambar:</p>
                        <img src="{{ asset('storage/'.$buku->gambar) }}"
                             class="w-24 rounded-lg shadow">
                    </div>
                @endif
            </div>

            <div class="flex justify-between pt-6">
                <a href="{{ route('buku.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg transition">
                    Kembali
                </a>

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg shadow transition">
                    Update Buku
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
