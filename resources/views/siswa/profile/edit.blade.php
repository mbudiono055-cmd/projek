@extends('layouts.siswa')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Edit Profil
        </h1>

        <div class="bg-white shadow-xl rounded-2xl p-8">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Alert --}}
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- UPDATE PROFIL -->
            <form action="{{ route('siswa.profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-gray-600 mb-2">Nama</label>
                    <input type="text" name="nama"
                        value="{{ old('nama', $siswa->nama) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-gray-600 mb-2">Username</label>
                    <input type="text" name="username"
                        value="{{ old('username', $siswa->username) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-gray-600 mb-2">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $siswa->email) }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection
