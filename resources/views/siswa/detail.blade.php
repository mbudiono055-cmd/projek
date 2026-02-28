@extends('layouts.siswa')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Main Card Container -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden ring-1 ring-gray-900/5">

        <div class="grid md:grid-cols-12 gap-0">

            <!-- BAGIAN GAMBAR (Kiri) -->
            <div class="md:col-span-5 bg-gradient-to-br from-indigo-50 to-white p-8 flex items-center justify-center relative">

                <!-- Badge Stok Overlay -->
                <div class="absolute top-6 left-6 bg-white/80 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold shadow-sm border border-gray-100 flex items-center gap-2">
                    @if($buku->stok > 0)
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-green-700">Stok: {{ $buku->stok }}</span>
                    @else
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="text-red-700">Stok Habis</span>
                    @endif
                </div>

                <!-- Gambar Buku -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                    <img src="{{ asset('storage/' . $buku->gambar) }}"
                         class="relative w-full max-w-[280px] aspect-[2/3] object-cover rounded-lg shadow-2xl transform transition duration-500 group-hover:-translate-y-2">
                </div>
            </div>

            <!-- BAGIAN KONTEN & FORM (Kanan) -->
            <div class="md:col-span-7 p-8 md:p-12 flex flex-col justify-center">

                <!-- Kategori & Judul -->
                <div class="mb-6">
                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold tracking-wider uppercase mb-3">
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </span>
                    <h2 class="text-4xl font-extrabold text-slate-900 leading-tight mb-2">
                        {{ $buku->judul }}
                    </h2>
                </div>

                <!-- Metadata Grid -->
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 mb-8 pb-8 border-b border-gray-100 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1">penulis</p>
                        <p class="text-slate-700 font-semibold">{{ $buku->penulis }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1">Penerbit</p>
                        <p class="text-slate-700 font-semibold">{{ $buku->penerbit }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1">Tahun Terbit</p>
                        <p class="text-slate-700 font-semibold">{{ $buku->tahun_terbit }}</p>
                    </div>
                </div>

                <!-- FORM PEMINJAMAN -->
                @if($buku->stok > 0)
                <form action="{{ route('siswa.pinjam', $buku->id) }}" method="POST">
                    @csrf

                    <div class="space-y-5">
                        <!-- Input Jumlah -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Jumlah Buku
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="jumlah"
                                       min="1"
                                       max="{{ $buku->stok }}"
                                       value="1"
                                       class="w-full pl-4 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium text-slate-800"
                                       required>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 ml-1">Maksimal peminjaman: {{ $buku->stok }} buku</p>
                        </div>

                        <!-- Input Tanggal -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Tanggal Pengembalian
                            </label>
                            <input type="date"
                                   name="tanggal_kembali"
                                   class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-medium text-slate-800"
                                   required>
                        </div>

                        <!-- ========================= -->
<!-- SECTION ULASAN SISWA -->
<!-- ========================= -->

<div class="mt-16">
    <h3 class="text-2xl font-bold text-slate-800 mb-6">
        Ulasan Siswa
    </h3>

    @if($buku->ulasans->count() > 0)

        <div class="space-y-6">

            @foreach($buku->ulasans as $ulasan)
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

                <!-- Header -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                            {{ strtoupper(substr($ulasan->user->nama,0,1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ $ulasan->user->nama }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $ulasan->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center gap-1 text-yellow-400 text-sm">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $ulasan->rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                </div>

                <!-- Isi Ulasan -->
                <p class="text-slate-600 leading-relaxed">
                    {{ $ulasan->komentar }}
                </p>

            </div>
            @endforeach

        </div>

    @else

        <div class="bg-gray-50 p-6 rounded-xl text-center text-gray-400 border border-dashed">
            Belum ada ulasan untuk buku ini.
        </div>

    @endif
</div>

                        <!-- Tombol Aksi -->
                        <div class="flex gap-4 pt-2">
                            <button type="submit"
                                    class="flex-1 bg-indigo-600 text-white py-3.5 px-6 rounded-xl hover:bg-indigo-700 hover:shadow-lg transition-all duration-300 font-bold flex justify-center items-center gap-2">
                                Pinjam Buku
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>

                            <a href="{{ route('siswa.katalog') }}"
                               class="flex-1 text-center bg-white text-slate-600 border border-slate-200 py-3.5 px-6 rounded-xl hover:bg-slate-50 hover:text-slate-800 transition-all font-bold">
                                Batal
                            </a>
                        </div>
                    </div>

                </form>
                @else
                <!-- Tampilan Stok Habis (Fungsi Sama, Tampilan Lebih Baik) -->
                <button disabled
                        class="w-full bg-gray-100 text-gray-400 py-4 rounded-xl font-bold cursor-not-allowed border-2 border-dashed border-gray-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Stok Habis
                </button>
                @endif

            </div>
        </div>
    </div>

</div>

@endsection
