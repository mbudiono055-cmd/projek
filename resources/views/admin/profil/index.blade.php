@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

        <!-- Foto -->
        <div class="mb-6">
            @if(isset($admin) && $admin->foto)
    <img src="{{ asset('foto_admin/' . $admin->foto) }}"
         class="w-32 h-32 rounded-full mx-auto object-cover shadow-lg">
@else
    <img src="https://ui-avatars.com/api/?name={{ $admin->nama ?? 'Admin' }}"
         class="w-32 h-32 rounded-full mx-auto shadow-lg">
@endif
        </div>

        @if($admin)
            <h2 class="text-2xl font-bold">{{ $admin->nama }}</h2>
            <p class="text-gray-500 mb-6">{{ $admin->email }}</p>
        @else
            <p class="text-red-500">Data admin tidak ditemukan</p>
        @endif

        <a href="{{ route('profil.edit') }}"
           class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
            Edit Profil
        </a>

    </div>

</div>
@endsection
