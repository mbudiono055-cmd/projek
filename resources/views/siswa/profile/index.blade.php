@extends('layouts.siswa')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-500">Informasi akun siswa</p>
        </div>

        <!-- Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <!-- Top Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-6 text-white">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center text-3xl font-bold text-indigo-600">
                        {{ strtoupper(substr($siswa->nama,0,1)) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold">{{ $siswa->nama }}</h2>
                        <p class="text-indigo-100">{{ $siswa->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-gray-500 text-sm">Username</label>
                    <p class="text-lg font-medium text-gray-800">
                        {{ $siswa->username }}
                    </p>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Role</label>
                    <p class="text-lg font-medium text-gray-800 capitalize">
                        {{ $siswa->role }}
                    </p>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Tanggal Daftar</label>
                    <p class="text-lg font-medium text-gray-800">
                        {{ $siswa->created_at->format('d M Y') }}
                    </p>
                </div>

                <div>
                    <label class="text-gray-500 text-sm">Terakhir Update</label>
                    <p class="text-lg font-medium text-gray-800">
                        {{ $siswa->updated_at->format('d M Y') }}
                    </p>
                </div>

            </div>

            <!-- Button -->
            <div class="p-6 border-t flex justify-end">
                <a href="{{ route('siswa.profile.edit') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-200">
                    Edit Profil
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
