@extends('layouts.petugas')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-4">Tambah Kategori</h2>

    <form action="{{ route('petugas.kategori.store') }}" method="POST">
    @csrf

    <div class="mb-4">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori"
               class="border p-2 w-full" required>
    </div>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>
</form>


</div>

@endsection
