@extends('layouts.siswa')

@section('content')

<div class="max-w-7xl mx-auto px-4">

    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800">
                ⭐ Koleksi Buku Saya
            </h2>
            <p class="text-slate-500 mt-1">
                Daftar buku favorit yang kamu simpan.
            </p>
        </div>

        <a href="{{ route('siswa.katalog') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
           📚 Lihat Katalog
        </a>
    </div>

    @if($koleksi->count() == 0)

    <!-- Jika koleksi kosong -->
    <div class="bg-white rounded-xl shadow p-10 text-center">

        <div class="text-6xl mb-4">
            📚
        </div>

        <h3 class="text-xl font-semibold text-gray-700 mb-2">
            Koleksi masih kosong
        </h3>

        <p class="text-gray-500 mb-4">
            Tambahkan buku favorit dari katalog.
        </p>

        <a href="{{ route('siswa.katalog') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
           Jelajahi Buku
        </a>

    </div>

    @else

    <!-- GRID KOLEKSI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

        @foreach($koleksi as $item)

        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 border border-slate-100 overflow-hidden">

            <!-- Cover Buku -->
            <div class="bg-slate-50 p-4">
                <img src="{{ asset('storage/'.$item->buku->gambar) }}"
                     class="w-full h-64 object-contain">
            </div>

            <!-- Content -->
            <div class="p-5">

                <h3 class="font-bold text-slate-800 text-lg line-clamp-2 mb-2">
                    {{ $item->buku->judul }}
                </h3>

                <p class="text-sm text-slate-600">
                    Penulis: {{ $item->buku->penulis }}
                </p>

                <p class="text-sm text-slate-500 mb-3">
                    {{ $item->buku->penerbit }}
                </p>

                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 mb-4">
                    ⭐ Favorit
                </span>

                <!-- Buttons -->
                <div class="flex gap-2">

                    <a href="{{ route('siswa.detail',$item->buku->id) }}"
                       class="flex-1 text-center py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                        Detail
                    </a>

                    <form action="{{ route('siswa.koleksi.hapus',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button
                        onclick="return confirm('Hapus buku dari koleksi?')"
                        class="px-3 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                        🗑
                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    @endif

</div>

@endsection
