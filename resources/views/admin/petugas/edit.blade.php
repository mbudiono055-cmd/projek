@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl p-8">

        <h2 class="text-2xl font-bold mb-6">
            Edit Petugas
        </h2>

        <form action="{{ route('petugas.update', $petugas->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-semibold">Nama</label>
                <input type="text" name="nama"
                    value="{{ $petugas->nama }}"
                    class="w-full border rounded px-4 py-2">
            </div>

            <div>
                <label class="block mb-2 font-semibold">Email</label>
                <input type="email" name="email"
                    value="{{ $petugas->email }}"
                    class="w-full border rounded px-4 py-2">
            </div>

            <div>
                <label class="block mb-2 font-semibold">Password</label>
                <input type="password" name="password"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                    class="w-full border rounded px-4 py-2">
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('petugas.index') }}"
                   class="bg-gray-400 text-white px-5 py-2 rounded-lg">
                    Kembali
                </a>

                <button type="submit"
                    class="bg-yellow-500 text-white px-6 py-2 rounded-lg">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
