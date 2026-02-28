@extends('layouts.siswa')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- ================= 1. BANNER WELCOME ================= -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-3xl p-8 md:p-10 text-white shadow-2xl shadow-indigo-500/30">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">
                    👋 Halo, {{ session('user_name') ?? 'Siswa' }}!
                </h2>
                <p class="text-indigo-100 text-lg max-w-xl">
                    Ayo temukan buku impianmu. Berikut panduan cepat untuk meminjam.
                </p>
            </div>
            <div class="hidden md:block transform translate-y-4 hover:scale-110 transition-transform duration-500">
                <svg class="w-32 h-32 text-white opacity-90 drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
            </div>
        </div>
    </div>


    <!-- ================= 2. STATISTIK (3 KOLOM SAJA) ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card 1: Total Buku -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-full">KOLEKSI</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $totalBuku ?? 0 }}</h3>
            <p class="text-sm text-slate-500 mt-1">Total Buku Perpus</p>
        </div>

        <!-- Card 2: Sedang Dipinjam -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-full">AKTIF</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $dipinjam ?? 0 }}</h3>
            <p class="text-sm text-slate-500 mt-1">Sedang Dipinjam</p>
        </div>

        <!-- Card 3: Selesai -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-full">RIWAYAT</span>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $dikembalikan ?? 0 }}</h3>
            <p class="text-sm text-slate-500 mt-1">Sudah Dikembalikan</p>
        </div>

    </div>

    <!-- ================= 3. CARA MEMINJAM (3 LANGKAH) ================= -->
    <div class="bg-slate-900 rounded-3xl p-8 relative overflow-hidden shadow-2xl">
        <!-- Background Effect -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full opacity-10 blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full opacity-10 blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>

        <div class="relative z-10">
            <h3 class="text-2xl font-bold text-white mb-8 text-center">🚀 Cara Meminjam Buku</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border-2 border-slate-700 group-hover:border-indigo-500 group-hover:bg-indigo-600 transition-all duration-300 mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div class="bg-indigo-600 text-white font-bold text-sm px-3 py-1 rounded-full mb-3 -mt-2">Langkah 1</div>
                    <h4 class="text-white font-bold text-lg mb-2">Telusuri Buku</h4>
                    <p class="text-slate-400 text-sm">Pergi Ke Halaman katalog buku untuk meminjam buku yg anda ingin kan</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border-2 border-slate-700 group-hover:border-indigo-500 group-hover:bg-indigo-600 transition-all duration-300 mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    </div>
                    <div class="bg-indigo-600 text-white font-bold text-sm px-3 py-1 rounded-full mb-3 -mt-2">Langkah 2</div>
                    <h4 class="text-white font-bold text-lg mb-2">Klik "Lihat Detail"</h4>
                    <p class="text-slate-400 text-sm">Buka detail buku, pastikan stok tersedia.</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center group">
                    <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border-2 border-slate-700 group-hover:border-indigo-500 group-hover:bg-indigo-600 transition-all duration-300 mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div class="bg-indigo-600 text-white font-bold text-sm px-3 py-1 rounded-full mb-3 -mt-2">Langkah 3</div>
                    <h4 class="text-white font-bold text-lg mb-2">Klik "pinjam"</h4>
                    <p class="text-slate-400 text-sm">Pilih jumlah buku, pilih tanggal pengembalian lalu tekan tombol "Pinjam Buku" untuk mengajukan.</p>
                </div>

            </div>
        </div>
    </div>

</div>

<footer class="bg-gray-900 text-gray-300 mt-16 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]">
    <div class="px-6 py-8 text-center">
        <h2 class="text-lg font-semibold text-white mb-2">DigiLibrary</h2>
        <p class="text-sm mb-4">
            Sistem Perpustakaan Digital Modern berbasis Laravel
        </p>

        <div class="flex justify-center gap-6 text-sm mb-4">
            <a href="#" class="hover:text-white">Tentang Kami</a>
            <a href="#" class="hover:text-white">Kontak</a>
            <a href="#" class="hover:text-white">Bantuan</a>
        </div>

        <p class="text-xs text-gray-500">
            © {{ date('Y') }} DigiLibrary. All rights reserved.
        </p>
    </div>
</footer>

@endsection
