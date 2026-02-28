@extends('layouts.siswa')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 py-10">

    <div class="w-full max-w-3xl bg-white shadow-2xl rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white p-8">
            <h1 class="text-3xl font-bold tracking-wide">Bukti Peminjaman</h1>
            <p class="text-indigo-100 text-sm mt-1">
                Perpustakaan Digital • Transaksi #{{ $data->id }}
            </p>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-slate-500">Judul Buku</p>
                    <p class="text-lg font-semibold text-slate-800">
                        {{ $data->buku->judul }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Jumlah</p>
                    <p class="text-lg font-semibold text-slate-800">
                        {{ $data->jumlah }} Buku
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Tanggal Pinjam</p>
                    <p class="text-lg font-semibold text-slate-800">
                        {{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d M Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Tanggal Kembali</p>
                    <p class="text-lg font-semibold text-slate-800">
                        {{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d M Y') }}
                    </p>
                </div>

            </div>

            <!-- Status -->
            <div class="pt-6 border-t">

                <p class="text-sm text-slate-500 mb-2">Status</p>

                @if($data->status == 'diterima')
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                        ✔ Disetujui
                    </span>
                @elseif($data->status == 'dikembalikan')
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold">
                        ✔ Dikembalikan
                    </span>
                @endif

            </div>

            @if($data->status == 'dikembalikan')

<div class="mt-8 border-t pt-6">
    <h2 class="text-lg font-semibold mb-4">Berikan Ulasan</h2>

    <form action="{{ route('siswa.ulasan.simpan') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="buku_id" value="{{ $data->buku_id }}">

        <div>
            <label class="block text-sm mb-1">Rating</label>
            <select name="rating" class="w-full border rounded-lg p-2">
                <option value="">Pilih Rating</option>
                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                <option value="4">⭐⭐⭐⭐ (4)</option>
                <option value="3">⭐⭐⭐ (3)</option>
                <option value="2">⭐⭐ (2)</option>
                <option value="1">⭐ (1)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Komentar</label>
            <textarea name="komentar"
                class="w-full border rounded-lg p-3"
                rows="3"
                placeholder="Tulis pengalaman kamu membaca buku ini..."></textarea>
        </div>

        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl transition">
            Kirim Ulasan
        </button>
    </form>
</div>

@endif

            <!-- Footer -->
            <div class="flex justify-between items-center pt-8 border-t">

                <a href="{{ route('siswa.riwayat') }}"
                   class="px-5 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-xl transition shadow-md">
                    Kembali
                </a>

                <button onclick="window.print()"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition shadow-md">
                    Cetak Bukti
                </button>

            </div>

        </div>

    </div>

</div>

@endsection
