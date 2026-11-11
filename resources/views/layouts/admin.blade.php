<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxurious - Admin</title>
    <script src="{{ asset('js/digilibrary-theme.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="min-h-screen bg-sky-50">
<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-gray-900/50 md:hidden"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-gradient-to-b from-blue-950 to-blue-800 text-white shadow-xl transition-transform duration-200 md:translate-x-0">
    <div class="flex items-center gap-3 border-b border-white/10 px-6 py-5">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full object-cover">
        <div>
            <h1 class="text-xl font-bold tracking-wide">Luxurious</h1>
            <p class="text-xs text-blue-200">Perpustakaan Digital Modern</p>
        </div>
    </div>

    <nav aria-label="Navigasi utama" class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
        <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/dashboard') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Dashboard</a>
        <a href="{{ route('buku.index') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/buku*') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Data Buku</a>
        <a href="{{ route('siswa.index') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/siswa*') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Data Siswa</a>
        <a href="{{ route('petugas.index') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/petugas*') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Petugas</a>
        <a href="{{ route('kategori.index') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/kategori*') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Kategori</a>
        <a href="{{ route('peminjaman.index') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/peminjaman*') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Riwayat</a>
        <a href="{{ route('admin.ulasan.index') }}" class="block rounded-lg px-4 py-3 text-white/80 transition duration-200 hover:translate-x-1 hover:bg-white/10 hover:text-white {{ request()->is('admin/ulasan') ? 'bg-white/15 font-semibold text-white ring-1 ring-white/10 shadow-sm' : '' }}">Ulasan</a>
    </nav>

    <div class="space-y-3 border-t border-white/10 p-4">
        <a href="{{ route('profil') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 transition hover:bg-white/10">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white font-bold text-blue-600">{{ strtoupper(substr(session('nama') ?? 'A', 0, 1)) }}</span>
            <span class="truncate text-sm">{{ session('nama') ?? 'Admin' }}</span>
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

<div class="min-h-screen md:ml-64">
    <header class="sticky top-0 z-20 flex h-14 items-center border-b border-slate-200 bg-white/90 px-4 shadow-sm backdrop-blur md:hidden">
        <button id="sidebar-toggle" type="button" aria-label="Buka navigasi" aria-controls="sidebar" aria-expanded="false" class="rounded-lg p-2 text-gray-700 hover:bg-gray-100">
            <i data-feather="menu" class="h-5 w-5"></i>
        </button>
        <span class="ml-3 font-semibold text-gray-800">Luxurious</span>
    </header>

    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>
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
