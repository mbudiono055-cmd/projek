@extends('layouts.siswa')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Akun</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">Edit Profil</h1>
        <p class="mt-1 text-sm text-slate-500">Pastikan data diri Anda selalu akurat dan terbaru.</p>
    </div>

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50/80 px-6 py-5 sm:px-8">
            <h2 class="font-semibold text-slate-800">Informasi Siswa</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui data yang ingin ditampilkan pada profil Anda.</p>
        </div>

        <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 p-6 sm:p-8">
            @csrf

            @if(session('success'))
                <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                    <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="flex flex-col gap-4 rounded-2xl bg-slate-50 p-4 sm:flex-row sm:items-center">
                @if($siswa->foto)
                    <img src="{{ asset('foto_profil/'.$siswa->foto) }}" alt="Foto profil saat ini" class="h-16 w-16 rounded-2xl object-cover ring-2 ring-white">
                @else
                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100 text-xl font-bold text-blue-800">{{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}</span>
                @endif
                <div class="flex-1">
                    <label for="foto" class="mb-1 block text-sm font-semibold text-slate-700">Foto Profil <span class="font-normal text-slate-400">(opsional)</span></label>
                    <input id="foto" type="file" name="foto" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-800 hover:file:bg-blue-200">
                    <p class="mt-1 text-xs text-slate-400">JPG atau PNG, maksimal 2 MB.</p>
                    @error('foto')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="nis" class="mb-2 block text-sm font-semibold text-slate-700">NIS</label>
                    <input id="nis" type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('nis')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('nama')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kelas" class="mb-2 block text-sm font-semibold text-slate-700">Kelas</label>
                    <input id="kelas" type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('kelas')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="jenis_kelamin" class="mb-2 block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'L')>Laki-laki</option>
                        <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'P')>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="alamat" class="mb-2 block text-sm font-semibold text-slate-700">Alamat <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea id="alamat" name="alamat" rows="4" class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" placeholder="Masukkan alamat Anda">{{ old('alamat', $siswa->alamat) }}</textarea>
                    @error('alamat')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('siswa.profile') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">
                    <i data-feather="check" class="h-4 w-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
</div>
<script>feather.replace();</script>
@endsection
