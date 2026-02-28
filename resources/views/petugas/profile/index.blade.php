@extends('layouts.petugas')

@section('content')

<div class="max-w-4xl mx-auto">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <div class="flex items-center gap-6 mb-8">

            @if($user->foto)
                <img src="{{ asset('uploads/profile/'.$user->foto) }}"
                     class="w-24 h-24 rounded-full object-cover border-4 border-blue-500">
            @else
                <div class="w-24 h-24 bg-blue-600 text-white text-3xl font-bold flex items-center justify-center rounded-full">
                    {{ strtoupper(substr($user->nama,0,1)) }}
                </div>
            @endif

            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->nama }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-blue-600 mt-1">Role: {{ ucfirst($user->role) }}</p>
            </div>

        </div>

        <hr class="mb-8">

        <!-- FORM EDIT PROFIL -->
        <form action="{{ route('petugas.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <h3 class="text-lg font-semibold mb-4">Edit Profil</h3>

            <div>
                <label class="block mb-1 font-medium">Nama</label>
                <input type="text" name="nama" value="{{ $user->nama }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block mb-1 font-medium">Foto Profil</label>
                <input type="file" name="foto"
                       class="w-full border rounded-lg px-4 py-2 bg-gray-50">
            </div>

            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>

        </form>

        <hr class="my-10">

        <!-- FORM GANTI PASSWORD -->
        <form action="{{ route('petugas.profile.password') }}" method="POST" class="space-y-4">
            @csrf

            <h3 class="text-lg font-semibold mb-4">Ganti Password</h3>

            <div>
                <label class="block mb-1 font-medium">Password Lama</label>
                <input type="password" name="password_lama"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label class="block mb-1 font-medium">Password Baru</label>
                <input type="password" name="password_baru"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label class="block mb-1 font-medium">Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500">
            </div>

            <button class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                Ganti Password
            </button>

        </form>

    </div>

</div>

@endsection