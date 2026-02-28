<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Budi Perpus</title>
    
    <!-- Tailwind CSS via CDN -->
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
            
            <!-- Gambar Background -->
            <div class="absolute inset-0 z-0">
                <!-- Menggunakan helper asset() Laravel untuk background -->
                <img src="{{ asset('assets/background.png') }}" 
                     alt="Library Background" 
                     class="w-full h-full object-cover opacity-60">
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/90 to-indigo-800/70"></div>
            </div>

            <!-- Konten Teks -->
            <div class="relative z-10 text-center max-w-lg text-white px-6">
                <div class="mb-6 flex justify-center">
                    <div class="bg-white/10 backdrop-blur-md p-3 rounded-3xl border border-white/20 shadow-2xl">
                        <!-- Menggunakan helper asset() Laravel untuk logo -->
                        <img src="{{ asset('assets/logo.png') }}" 
                             alt="Logo DigiLibrary" 
                             class="w-20 h-20 rounded-full object-cover border-2 border-white/30 shadow-inner">
                    </div>
                </div>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">DigiLibrary</h1>
                <p class="text-lg text-indigo-100 leading-relaxed">
                    Bergabunglah dengan DigiLibrary. Akses ribuan koleksi buku digital, nikmati kemudahan peminjaman, dan eksplorasi pengetahuan tanpa batas.
                </p>
            </div>
            
            <!-- Dekorasi Lingkaran Blur -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>

        <!-- BAGIAN KANAN: Form Register -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 py-12 sm:px-12 lg:px-16 bg-white">
            
            <div class="mx-auto w-full max-w-md">
                
                <!-- Header Mobile -->
                <div class="lg:hidden text-center mb-8">
                    <!-- Logo Mobile -->
                    <div class="flex justify-center mb-4">
                         <img src="{{ asset('assets/logo.png') }}" 
                             alt="Logo Budi Perpus" 
                             class="w-16 h-16 rounded-full object-cover shadow-md">
                    </div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">Budi Perpus</h1>
                    <p class="text-slate-500">Buat akun baru Anda</p>
                </div>

                <!-- Header Desktop -->
                <div class="hidden lg:block mb-10">
                    <h2 class="text-3xl font-bold text-slate-900">Daftar Akun</h2>
                    <p class="text-slate-500 mt-2">Isi formulir di bawah untuk membuat akun.</p>
                </div>

                {{-- Pesan Error Umum (Session) --}}
                @if(session('error'))
                <div class="flex items-center p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 shadow-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-bold block text-red-900">Gagal Mendaftar</span>
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                <form action="/register" method="POST" class="space-y-5">
                    @csrf

                    {{-- Validasi Error Per Field --}}
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" 
                                   class="bg-slate-50 border @error('name') border-red-300 @else border-slate-200 @enderror text-slate-900 text-sm rounded-xl focus:ring-2 @error('name') focus:ring-red-500 @else focus:ring-indigo-500 @enderror focus:border-indigo-500 block w-full ps-11 p-3 outline-none transition-all shadow-sm" 
                                   placeholder="Masukkan nama lengkap" required>
                        </div>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block mb-2 text-sm font-semibold text-slate-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" 
                                   class="bg-slate-50 border @error('email') border-red-300 @else border-slate-200 @enderror text-slate-900 text-sm rounded-xl focus:ring-2 @error('email') focus:ring-red-500 @else focus:ring-indigo-500 @enderror focus:border-indigo-500 block w-full ps-11 p-3 outline-none transition-all shadow-sm" 
                                   placeholder="nama@email.com" required>
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
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
                            <input type="password" name="password" id="password" 
                                   class="bg-slate-50 border @error('password') border-red-300 @else border-slate-200 @enderror text-slate-900 text-sm rounded-xl focus:ring-2 @error('password') focus:ring-red-500 @else focus:ring-indigo-500 @enderror focus:border-indigo-500 block w-full ps-11 p-3 pr-12 outline-none transition-all shadow-sm" 
                                   placeholder="••••••••" required>
                            
                            <!-- Tombol Toggle Password -->
                            <button type="button" id="togglePassword" class="absolute inset-y-0 end-0 flex items-center pe-4 cursor-pointer text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                                <svg id="eyeIcon" class="w-5 h-5 block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-200 shadow-lg hover:shadow-xl transform active:scale-95 mt-6">
                        Register Sekarang
                    </button>
                </form>

                <div class="mt-8 text-center text-sm text-slate-600">
                    Sudah punya akun? 
                    <a href="/login" class="font-bold text-indigo-600 hover:text-indigo-500 hover:underline transition-all ml-1">
                        Login disini
                    </a>
                </div>

            </div>
            
            <!-- Footer Desktop -->
            <div class="mt-auto text-center text-xs text-slate-400 pt-8 lg:pt-0">
                &copy; 2023 Budi Perpus. Hak Cipta Dilindungi.
            </div>
        </div>
    </div>

    <!-- Script Toggle Password (Sama persis dengan Login) -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        const eyeOffIcon = document.querySelector('#eyeOffIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
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