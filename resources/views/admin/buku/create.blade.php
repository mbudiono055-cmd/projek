@extends('layouts.admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">Tambah Buku</h2>

<form action="{{ route('buku.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow">

    @csrf

    <div class="mb-4">
        <label class="block mb-1">Judul</label>
        <input type="text" name="judul" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">penulis</label>
        <input type="text" name="penulis" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Penerbit</label>
        <input type="text" name="penerbit" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Kategori</label>
        <select name="kategori_id" class="w-full border p-2 rounded">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Tahun Terbit</label>
        <input type="number" name="tahun_terbit" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Stok</label>
        <input type="number" name="stok" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Gambar</label>
        <input type="file" name="gambar" class="w-full border p-2 rounded">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

    <a href="{{ route('buku.index') }}"
           class="bg-gray-400 text-white px-6 py-2 rounded-lg">
            Kembali
        </a>

</form>

@endsection
