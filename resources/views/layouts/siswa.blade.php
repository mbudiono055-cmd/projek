<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DigiLibrary - Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- ================= NAVBAR ================= -->
<nav class="bg-gradient-to-r from-blue-700 to-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-6">

        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/logo.png') }}"
                     alt="Logo"
                     class="w-10 h-10 rounded-full object-cover bg-white p-1 shadow">

                <div class="leading-tight">
                    <h1 class="text-lg font-bold tracking-wide">
                        DigiLibrary
                    </h1>
                    <p class="text-xs text-blue-200">
                        Perpustakaan Digital Modern
                    </p>
                </div>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex items-center gap-2">

                <a href="{{ route('siswa.dashboard') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition
                   {{ request()->is('siswa/dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    Dashboard
                </a>

                <a href="{{ route('siswa.katalog') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition
                   {{ request()->is('siswa/katalog*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    Katalog Buku
                </a>

                <a href="{{ route('siswa.koleksi') }}"
class="px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-white/10">
Koleksi Buku
</a>

                <a href="{{ route('siswa.riwayat') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition
                   {{ request()->is('siswa/riwayat') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    Riwayat Peminjaman
                </a>

            </div>

            <!-- User Section -->
            <div class="flex items-center gap-3">

                <!-- Avatar -->
                <a href="{{ route('siswa.profile') }}"
                   class="hidden md:flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-full hover:bg-white/20 transition">

                    <div class="w-8 h-8 bg-white text-blue-600 font-bold flex items-center justify-center rounded-full text-sm">
                        {{ strtoupper(substr(session('user_name') ?? 'S', 0, 1)) }}
                    </div>

                    <span class="text-sm font-medium">
                        {{ session('user_name') ?? 'Siswa' }}
                    </span>
                </a>

                <!-- Logout -->
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 bg-red-500 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition shadow-sm">
                        <i data-feather="log-out" class="w-4 h-4"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>

<!-- ================= CONTENT ================= -->
<main class="flex-1">
    <div class="container mx-auto px-6 py-10">
        <div class="min-h-[60vh]">
            @yield('content')
        </div>
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-white text-center text-sm text-gray-500 py-4 shadow-inner">
    © {{ date('Y') }} DigiLibrary - Sistem Perpustakaan Digital
</footer>

<!-- Feather Icons -->
<script>
    feather.replace()
</script>

</body>
</html>
