<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DigiLibrary - Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Navbar -->
<nav class="bg-gradient-to-r from-blue-700 to-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo + Nama -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/logo.png') }}"
                 alt="Logo"
                 class="w-10 h-10 rounded-full object-cover bg-white p-1 shadow-md">

            <div>
                <h1 class="text-xl font-bold tracking-wide">DigiLibrary</h1>
                <p class="text-xs text-blue-200">Perpustakaan Digital Modern</p>
            </div>
        </div>

        <!-- Menu -->
        <div class="space-x-3 hidden md:flex">

            <a href="{{ route('siswa.dashboard') }}"
               class="px-4 py-2 rounded-lg transition duration-200
               {{ request()->is('siswa/dashboard') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Dashboard
            </a>

            <a href="{{ route('siswa.katalog') }}"
               class="px-4 py-2 rounded-lg transition duration-200
               {{ request()->is('siswa/katalog*') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Katalog Buku
            </a>

            <a href="{{ route('siswa.riwayat') }}"
               class="px-4 py-2 rounded-lg transition duration-200
               {{ request()->is('siswa/riwayat') ? 'bg-white/20 backdrop-blur-sm' : 'hover:bg-white/10' }}">
                Riwayat Peminjaman
            </a>

        </div>

        <!-- User Section -->
        <div class="flex items-center gap-3">

            <!-- Icon Profile + Nama -->
            <div class="hidden md:flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full">
                <div class="w-8 h-8 bg-white text-blue-600 flex items-center justify-center rounded-full">
                    <i data-feather="user" class="w-4 h-4"></i>
                </div>
                <span class="text-sm">
                    {{ session('user_name') ?? 'Siswa' }}
                </span>
            </div>

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

<!-- Content -->
<main class="flex-1 container mx-auto px-6 pt-10">
    <div class="min-h-[60vh]">
        @yield('content')
    </div>
</main>
</body>
</html>
