<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Luxurious</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="{{ asset('js/digilibrary-theme.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Animasi blob background */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</head>
<body class="bg-slate-50">

    <!-- Container Utama: Flex Row (Kiri Kanan) -->
    <div class="flex min-h-screen">

        <!-- BAGIAN KIRI: Info & Background (Hidden di Mobile, Flex di Desktop) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 items-center justify-center p-12 overflow-hidden">
            
            <!-- Gambar Background dari public/assets/ dengan Overlay Gelap -->
            <div class="absolute inset-0 z-0">
                <!-- Menggunakan helper asset() Laravel -->
                <img src="{{ asset('assets/background.png') }}" 
                     alt="Library Background" 
                     class="w-full h-full object-cover opacity-60">
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/90 to-indigo-800/70"></div>
            </div>

            <!-- Konten Teks (Absolute Position di atas gambar) -->
            <div class="relative z-10 text-center max-w-lg text-white px-6">
                <div class="mb-6 flex justify-center">
                    <!-- Container Kaca (Glassmorphism) -->
                    <div class="bg-white/10 backdrop-blur-md p-3 rounded-3xl border border-white/20 shadow-2xl">
                        <!-- LOGO BULET (Menggunakan asset() Laravel) -->
                        <img src="{{ asset('assets/logo.png') }}" 
                             alt="Logo Luxurious"
                             class="w-20 h-20 rounded-full object-cover border-2 border-white/30 shadow-inner">
                    </div>
                </div>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Luxurious</h1>
                <p class="text-lg text-indigo-100 leading-relaxed">
                    Sistem peminjaman buku digital terintegrasi. Akses ribuan koleksi buku di mana saja dan kapan saja dengan mudah dan cepat.
                </p>
            </div>
            
            <!-- Dekorasi Lingkaran Blur -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>

        <!-- BAGIAN KANAN: Form Login (Wajib di semua layar) -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 py-12 sm:px-12 lg:px-16 bg-white">
            
            <div class="mx-auto w-full max-w-md">
                
                <!-- Header Mobile (Hanya muncul di layar kecil) -->
                <div class="lg:hidden text-center mb-8">
                    <!-- Logo Mobile Kecil -->
                    <div class="flex justify-center mb-4">
                         <img src="{{ asset('assets/logo.png') }}" 
                             alt="Logo Luxurious"
                             class="w-16 h-16 rounded-full object-cover shadow-md">
                    </div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">Luxurious</h1>
                    <p class="text-slate-500">Masuk untuk melanjutkan</p>
                </div>

                <!-- Header Desktop -->
                <div class="hidden lg:block mb-10">
                    <h2 class="text-3xl font-bold text-slate-900">Login Akun</h2>
                    <p class="text-slate-500 mt-2">Silakan masukkan detail akun Anda.</p>
                </div>

                {{-- Pesan error login --}}
                @if(session('error'))
                <div class="flex items-center p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-bold block text-red-900">Gagal Masuk</span>
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                {{-- Pesan sukses register --}}
                @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <div>
                        <span class="font-bold block text-green-900">Berhasil</span>
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                <form action="/login" method="POST" class="space-y-6">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-semibold text-slate-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full ps-11 p-3 outline-none transition-all shadow-sm" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full ps-11 p-3 pr-12 outline-none transition-all shadow-sm" placeholder="••••••••" required>
                            
                            <!-- Tombol Toggle Password -->
                            <button type="button" id="togglePassword" class="absolute inset-y-0 end-0 flex items-center pe-4 cursor-pointer text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                                
                                <!-- Ikon Mata Terbuka (Default Visible) -->
                                <svg id="eyeIcon" class="w-5 h-5 block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                
                                <!-- Ikon Mata Tertutup/Slash (Default Hidden) -->
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-lg hover:shadow-xl transform active:scale-95">
                        Login Sekarang
                    </button>
                </form>

                <div class="mt-8 text-center text-sm text-slate-600">
                    Belum punya akun? 
                    <a href="/register" class="font-bold text-indigo-600 hover:text-indigo-500 hover:underline transition-all ml-1">
                        Register disini
                    </a>
                </div>

            </div>
            
            <!-- Footer Desktop -->
            <div class="mt-auto text-center text-xs text-slate-400 pt-8 lg:pt-0">
                &copy; 2023 Luxurious. Hak Cipta Dilindungi.
            </div>
        </div>
    </div>

    <!-- Script Perbaikan Toggle Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');       // Ikon Mata Terbuka
        const eyeOffIcon = document.querySelector('#eyeOffIcon'); // Ikon Mata Tertutup

        togglePassword.addEventListener('click', function () {
            // Ambil tipe saat ini
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            
            // Ubah tipe input
            password.setAttribute('type', type);
            
            // Logika Tampilan Ikon:
            // Jika type 'text' (Password Terlihat), tampilkan ikon mata tertutup (eyeOffIcon)
            // Jika type 'password' (Password Tersembunyi), tampilkan ikon mata terbuka (eyeIcon)
            
            if (type === 'text') {
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        });
    </script>

</body>
</html>