@extends('layouts.siswa')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Akun</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Profil Saya</h1>
        <p class="mt-1 text-sm text-slate-500">Informasi diri dan data akun perpustakaan Anda.</p>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">{{ session('error') }}</div>
    @endif

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 px-6 py-8 sm:px-10 sm:py-10">
            <div class="absolute -right-10 -top-20 h-64 w-64 rounded-full border-[40px] border-white/5"></div>
            <div class="relative flex flex-col items-center gap-5 sm:flex-row">
                @if($siswa->foto)
                    <img src="{{ asset('foto_profil/'.$siswa->foto) }}" alt="Foto profil {{ $siswa->nama }}" class="h-24 w-24 rounded-3xl object-cover shadow-lg ring-4 ring-white/20">
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-3xl bg-white/15 text-3xl font-bold text-white shadow-lg ring-4 ring-white/10">{{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}</div>
                @endif
                <div class="text-center sm:text-left">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold text-blue-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                        Siswa
                    </span>
                    <h2 class="mt-3 text-2xl font-bold text-white sm:text-3xl">{{ $siswa->nama }}</h2>
                    <p class="mt-1 text-sm text-blue-100/80">{{ optional($siswa->user)->email ?? 'Email tidak tersedia' }}</p>
                </div>
                <a href="{{ route('siswa.profile.edit') }}" class="sm:ml-auto inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-900 shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-50">
                    <i data-feather="edit-2" class="h-4 w-4"></i>
                    Edit Profil
                </a>
            </div>
        </div>

        <div class="grid gap-4 p-6 sm:grid-cols-2 sm:p-8">
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800"><i data-feather="hash" class="h-5 w-5"></i></span>
                    <div><p class="text-xs font-medium uppercase tracking-wide text-slate-400">NIS</p><p class="mt-1 font-semibold text-slate-800">{{ $siswa->nis }}</p></div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800"><i data-feather="book-open" class="h-5 w-5"></i></span>
                    <div><p class="text-xs font-medium uppercase tracking-wide text-slate-400">Kelas</p><p class="mt-1 font-semibold text-slate-800">{{ $siswa->kelas }}</p></div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800"><i data-feather="user" class="h-5 w-5"></i></span>
                    <div><p class="text-xs font-medium uppercase tracking-wide text-slate-400">Jenis Kelamin</p><p class="mt-1 font-semibold text-slate-800">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p></div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800"><i data-feather="calendar" class="h-5 w-5"></i></span>
                    <div><p class="text-xs font-medium uppercase tracking-wide text-slate-400">Bergabung</p><p class="mt-1 font-semibold text-slate-800">{{ $siswa->created_at->format('d M Y') }}</p></div>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5 sm:col-span-2">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-800"><i data-feather="map-pin" class="h-5 w-5"></i></span>
                    <div><p class="text-xs font-medium uppercase tracking-wide text-slate-400">Alamat</p><p class="mt-1 whitespace-pre-line font-medium text-slate-700">{{ $siswa->alamat ?: 'Alamat belum diisi.' }}</p></div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>feather.replace();</script>
@endsection
