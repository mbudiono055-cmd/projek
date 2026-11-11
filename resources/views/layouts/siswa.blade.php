<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxurious - Siswa</title>
    <script src="{{ asset('js/digilibrary-theme.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="min-h-screen bg-sky-50">
<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-gray-900/50 md:hidden"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-gradient-to-b from-blue-950 to-blue-800 text-white shadow-xl transition-transform duration-200 md:translate-x-0">
    <div class="flex items-center gap-3 border-b border-white/10 px-6 py-5">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full bg-white p-1 object-cover shadow">
        <div class="leading-tight">
            <h1 class="text-lg font-bold tracking-wide">Luxurious</h1>
            <p class="text-xs text-blue-200">Perpustakaan Digital Modern</p>
        </div>
    </div>

    <nav aria-label="Navigasi utama" class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
        <a href="{{ route('siswa.dashboard') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('siswa/dashboard') ? 'bg-white/15 text-white ring-1 ring-white/10 shadow-sm' : '' }}">Dashboard</a>
        <a href="{{ route('siswa.katalog') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('siswa/katalog*') ? 'bg-white/15 text-white ring-1 ring-white/10 shadow-sm' : '' }}">Katalog Buku</a>
        <a href="{{ route('siswa.koleksi') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white">Koleksi Buku</a>
        <a href="{{ route('siswa.riwayat') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('siswa/riwayat') ? 'bg-white/15 text-white ring-1 ring-white/10 shadow-sm' : '' }}">Riwayat Peminjaman</a>
        <a href="{{ route('siswa.asisten-ai') }}" class="block rounded-lg px-4 py-3 text-sm font-medium text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('siswa/asisten-ai*') ? 'bg-white/15 text-white ring-1 ring-white/10 shadow-sm' : '' }}">
            <span class="mr-2" aria-hidden="true">✦</span>Asisten Perpustakaan
        </a>
    </nav>

    <div class="space-y-3 border-t border-white/10 p-4">
        <a href="{{ route('siswa.profile') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 transition hover:bg-white/10">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white text-sm font-bold text-blue-600">{{ strtoupper(substr(session('user_name') ?? 'S', 0, 1)) }}</span>
            <span class="truncate text-sm font-medium">{{ session('user_name') ?? 'Siswa' }}</span>
        </a>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="group flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white/70 transition hover:bg-white/5 hover:text-white">
                <i data-feather="log-out" class="h-4 w-4 transition group-hover:-translate-x-0.5"></i>
                Keluar
            </button>
        </form>
    </div>
</aside>

<div class="flex min-h-screen flex-col md:ml-64">
    <header class="sticky top-0 z-20 flex h-14 items-center border-b border-slate-200 bg-white/90 px-4 shadow-sm backdrop-blur md:hidden">
        <button id="sidebar-toggle" type="button" aria-label="Buka navigasi" aria-controls="sidebar" aria-expanded="false" class="rounded-lg p-2 text-gray-700 hover:bg-gray-100">
            <i data-feather="menu" class="h-5 w-5"></i>
        </button>
        <span class="ml-3 font-semibold text-gray-800">Luxurious</span>
    </header>

    <main class="flex-1">
        <div class="container mx-auto px-6 py-10">
            <div class="min-h-[60vh]">
                @yield('content')
            </div>
        </div>
    </main>

    <footer class="bg-white py-4 text-center text-sm text-gray-500 shadow-inner">
        © {{ date('Y') }} Luxurious - Sistem Perpustakaan Digital
    </footer>
</div>

<script>
    feather.replace();

    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function setSidebarOpen(isOpen) {
        sidebar.classList.toggle('-translate-x-full', !isOpen);
        sidebarOverlay.classList.toggle('hidden', !isOpen);
        sidebarToggle.setAttribute('aria-expanded', String(isOpen));
    }

    sidebarToggle.addEventListener('click', () => {
        setSidebarOpen(sidebarToggle.getAttribute('aria-expanded') !== 'true');
    });
    sidebarOverlay.addEventListener('click', () => setSidebarOpen(false));
</script>
</body>
</html>
