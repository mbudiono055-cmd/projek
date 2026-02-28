<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DigiLibrary - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100">

<!-- ================= NAVBAR ================= -->
<nav class="bg-gradient-to-r from-blue-700 to-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/logo.png') }}"
                 alt="Logo"
                 class="w-10 h-10 rounded-full object-cover">

            <div>
                <h1 class="text-xl font-bold tracking-wide">DigiLibrary</h1>
                <p class="text-xs text-blue-200">Perpustakaan Digital Modern</p>
            </div>
        </div>

        <!-- Menu -->
        <div class="space-x-3 hidden md:flex">

            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/dashboard') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Dashboard
            </a>

            <a href="{{ route('buku.index') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/buku*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Data Buku
            </a>

            <a href="{{ route('siswa.index') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/siswa*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Data Siswa
            </a>

            <a href="{{ route('petugas.index') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/petugas*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Petugas
            </a>

            <a href="{{ route('kategori.index') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/kategori*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Kategori
            </a>

            <a href="{{ route('peminjaman.index') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/peminjaman*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Riwayat
            </a>

            <a href="{{ route('admin.ulasan.index') }}"
               class="px-4 py-2 rounded-lg transition
               {{ request()->is('admin/ulasan') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Ulasan
            </a>

        </div>

        <!-- User Section -->
        <div class="flex items-center gap-3">

            <!-- Avatar clickable -->
            <a href="{{ route('profil') }}"
               class="hidden md:flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full hover:bg-white/20 transition">

                <div class="w-8 h-8 bg-white text-blue-600 font-bold flex items-center justify-center rounded-full">
                    {{ strtoupper(substr(session('nama') ?? 'A', 0, 1)) }}
                </div>

                <span class="text-sm">
                    {{ session('nama') ?? 'Admin' }}
                </span>
            </a>

            <!-- Logout -->
            <form action="/logout" method="POST">
                @csrf
                <button class="flex items-center gap-2 bg-red-500/90 px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    <i data-feather="log-out" class="w-4 h-4"></i>
                    Keluar
                </button>
            </form>

        </div>

    </div>
</nav>

<script>
    feather.replace()
</script>

<!-- ================= CONTENT ================= -->
<div class="container mx-auto mt-8 px-6">
    @yield('content')
</div>

</body>
</html>
