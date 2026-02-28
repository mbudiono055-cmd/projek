@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10">

    <div class="bg-white rounded-2xl shadow-xl p-8">

        <form action="{{ route('profil.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            <!-- Foto -->
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Foto Profil</label>
                <input type="file" name="foto"
                       class="w-full border p-3 rounded-xl">
            </div>

            <!-- Nama -->
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Nama</label>
                <input type="text"
                       name="nama"
                       value="{{ $admin->nama }}"
                       class="w-full border p-3 rounded-xl">
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Email</label>
                <input type="email"
                       name="email"
                       value="{{ $admin->email }}"
                       class="w-full border p-3 rounded-xl">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block mb-2 font-semibold">
                    Password Baru (Opsional)
                </label>
                <input type="password"
                       name="password"
                       class="w-full border p-3 rounded-xl">
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label class="block mb-2 font-semibold">
                    Konfirmasi Password
                </label>
                <input type="password"
                       name="password_confirmation"
                       class="w-full border p-3 rounded-xl">
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>

            <a href="{{ route('profil') }}"
                   class="bg-gray-600 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition">
                    Kembali
                </a>

        </form>

    </div>

</div>
@endsection
