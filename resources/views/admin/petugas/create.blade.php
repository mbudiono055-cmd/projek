@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Pengguna</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Tambah Petugas</h1>
        <p class="mt-1 text-sm text-slate-500">Buat akun petugas baru untuk membantu mengelola perpustakaan.</p>
    </div>

    @if($errors->any())
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <p class="mb-1 font-semibold">Periksa kembali data yang diisi.</p>
            <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 px-6 py-7 sm:px-8">
            <div class="absolute -right-6 -top-20 h-48 w-48 rounded-full border-[32px] border-white/5"></div>
            <div class="relative flex items-center gap-4">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/15">
                    <i data-feather="user-plus" class="h-7 w-7"></i>
                </span>
                <div>
                    <h2 class="text-lg font-semibold text-white">Informasi Akun</h2>
                    <p class="mt-1 text-sm text-blue-100/80">Nama, email, dan password untuk petugas.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('petugas.store') }}" method="POST" class="space-y-5 p-6 sm:p-8">
            @csrf
            <div>
                <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <i data-feather="user" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required maxlength="255" autofocus autocomplete="name"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan nama lengkap">
                </div>
                @error('nama')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <i data-feather="mail" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="nama@contoh.com">
                </div>
                @error('email')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <i data-feather="lock" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input id="password" type="password" name="password" required minlength="6" autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Minimal 6 karakter">
                </div>
                <p class="mt-1.5 text-xs text-slate-400">Gunakan password minimal 6 karakter.</p>
                @error('password')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="rounded-xl border border-blue-100 bg-blue-50/70 p-4">
                <div class="flex gap-3">
                    <i data-feather="info" class="mt-0.5 h-4 w-4 shrink-0 text-blue-700"></i>
                    <p class="text-sm leading-relaxed text-blue-900">Petugas dapat menggunakan email dan password ini untuk masuk ke sistem. Pastikan informasi login diberikan secara aman.</p>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('petugas.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Kembali</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900 hover:shadow-md">
                    <i data-feather="user-plus" class="h-4 w-4"></i>
                    Buat Akun Petugas
                </button>
            </div>
        </form>
    </section>
</div>
<script>feather.replace();</script>
@endsection
