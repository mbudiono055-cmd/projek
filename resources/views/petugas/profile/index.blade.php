@extends('layouts.petugas')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Akun</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Profil Petugas</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola informasi akun dan keamanan password Anda.</p>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 px-6 py-8 sm:px-10 sm:py-10">
            <div class="absolute -right-10 -top-20 h-64 w-64 rounded-full border-[40px] border-white/5"></div>
            <div class="relative flex flex-col items-center gap-5 sm:flex-row">
                @if($user->foto)
                    <img src="{{ asset('uploads/profile/'.$user->foto) }}" alt="Foto profil {{ $user->nama }}" class="h-24 w-24 rounded-3xl object-cover shadow-lg ring-4 ring-white/20">
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-3xl bg-white/15 text-3xl font-bold text-white shadow-lg ring-4 ring-white/10">{{ strtoupper(substr($user->nama ?? 'P', 0, 1)) }}</div>
                @endif
                <div class="text-center sm:text-left">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold text-blue-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                        {{ ucfirst($user->role) }}
                    </span>
                    <h2 class="mt-3 text-2xl font-bold text-white sm:text-3xl">{{ $user->nama }}</h2>
                    <p class="mt-1 text-sm text-blue-100/80">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 p-6 sm:grid-cols-2 sm:p-8">
            <form action="{{ route('petugas.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <h3 class="font-semibold text-slate-800">Informasi Akun</h3>
                    <p class="mt-1 text-sm text-slate-500">Perbarui nama, email, dan foto profil.</p>
                </div>
                <div>
                    <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">Nama</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('nama')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('email')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="foto" class="mb-2 block text-sm font-semibold text-slate-700">Foto Profil</label>
                    <input id="foto" type="file" name="foto" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-800 hover:file:bg-blue-200">
                    <p class="mt-1 text-xs text-slate-400">JPG atau PNG, maksimal 2 MB.</p>
                    @error('foto')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">
                    <i data-feather="check" class="h-4 w-4"></i>
                    Simpan Profil
                </button>
            </form>

            <form action="{{ route('petugas.profile.password') }}" method="POST" class="space-y-5 rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-6">
                @csrf
                <div>
                    <span class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800"><i data-feather="lock" class="h-5 w-5"></i></span>
                    <h3 class="font-semibold text-slate-800">Keamanan Akun</h3>
                    <p class="mt-1 text-sm text-slate-500">Gunakan password baru yang kuat dan mudah Anda ingat.</p>
                </div>
                <div>
                    <label for="password_lama" class="mb-2 block text-sm font-semibold text-slate-700">Password Lama</label>
                    <input id="password_lama" type="password" name="password_lama" autocomplete="current-password" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    @error('password_lama')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_baru" class="mb-2 block text-sm font-semibold text-slate-700">Password Baru</label>
                    <input id="password_baru" type="password" name="password_baru" autocomplete="new-password" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    @error('password_baru')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_baru_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password Baru</label>
                    <input id="password_baru_confirmation" type="password" name="password_baru_confirmation" autocomplete="new-password" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                </div>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-white px-5 py-3 text-sm font-semibold text-blue-900 transition hover:bg-blue-50">
                    <i data-feather="shield" class="h-4 w-4"></i>
                    Ganti Password
                </button>
            </form>
        </div>
    </section>
</div>
<script>feather.replace();</script>
@endsection
