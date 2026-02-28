@extends('layouts.siswa')

@section('content')

<div class="max-w-7xl mx-auto px-4">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800">
            📚 Katalog Buku
        </h2>
        <p class="text-slate-500 mt-1">
            Temukan dan pinjam buku favoritmu dengan mudah.
        </p>
    </div>

    <!-- ================= FILTER & SEARCH ================= -->
    <div class="mb-8">
        <form method="GET" action="{{ route('siswa.katalog') }}">

            <div class="flex flex-col lg:flex-row gap-3 w-full">

                <!-- Search Judul (FULL LEBAR) -->
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul buku..."
                       class="flex-1 w-full px-4 py-3 rounded-xl border border-slate-300
                              focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                <!-- Filter Kategori -->
                <select name="kategori"
                        class="w-full lg:w-60 px-4 py-3 rounded-xl border border-slate-300
                               focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                    <option value="">Semua Kategori</option>

                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}"
                            {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <!-- Button -->
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold
                               hover:bg-indigo-700 transition whitespace-nowrap">
                    Cari
                </button>

                @if(request('search') || request('kategori'))
                    <a href="{{ route('siswa.katalog') }}"
                       class="px-5 py-3 rounded-xl bg-slate-200 text-slate-700
                              hover:bg-slate-300 transition whitespace-nowrap text-center">
                        Reset
                    </a>
                @endif

            </div>

        </form>
    </div>

    <!-- ================= GRID BUKU ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($bukus as $item)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden border border-slate-100 hover:-translate-y-1">

            <!-- Gambar -->
            <div class="bg-slate-50 p-4">
                <img src="{{ asset('storage/' . $item->gambar) }}"
                     class="w-full h-72 object-contain">
            </div>

            <!-- Content -->
            <div class="p-6">

                <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2">
                    {{ $item->judul }}
                </h3>

                <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 mb-3">
                    {{ $item->kategori->nama_kategori ?? '-' }}
                </span>

                <div class="space-y-1 text-sm text-slate-600 mb-4">
                    <p><span class="font-medium">penulis:</span> {{ $item->penulis }}</p>
                    <p><span class="font-medium">Penerbit:</span> {{ $item->penerbit }}</p>
                    <p><span class="font-medium">Tahun:</span> {{ $item->tahun_terbit }}</p>
                </div>

                <div class="mb-4">
                    @if($item->stok > 0)
                        <span class="text-sm font-semibold text-emerald-600">
                            Stok tersedia ({{ $item->stok }})
                        </span>
                    @else
                        <span class="text-sm font-semibold text-rose-600">
                            Stok habis
                        </span>
                    @endif
                </div>

                <a href="{{ route('siswa.detail', $item->id) }}"
                   class="block w-full text-center py-2.5 rounded-xl font-semibold text-white
                          bg-gradient-to-r from-indigo-600 to-blue-600
                          hover:from-indigo-700 hover:to-blue-700
                          transition duration-300 shadow-md">
                    Lihat Detail
                </a>

            </div>
        </div>
        @empty
            <div class="col-span-3 text-center text-slate-400 py-12">
                Buku tidak ditemukan 📖
            </div>
        @endforelse

    </div>

</div>

@endsection
