@extends('layouts.admin')

@section('content')

<div class="flex justify-center">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-md p-8">

        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">
            Tambah Petugas
        </h2>

        <form action="{{ route('petugas.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block mb-2 font-medium">Nama</label>
                <input type="text" name="nama" class="w-full border rounded px-4 py-2">
            </div>

            <div>
                <label class="block mb-2 font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded px-4 py-2">
            </div>

            <div>
                <label class="block mb-2 font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded px-4 py-2">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('petugas.index') }}"
                   class="bg-gray-500 text-white px-5 py-2 rounded-md">
                    Kembali
                </a>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
