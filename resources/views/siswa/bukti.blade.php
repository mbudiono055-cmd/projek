@extends('layouts.siswa')

@section('content')
@php
    $isReturned = $data->status === 'dikembalikan';
    $isOverdue = $data->status === 'terlambat';
    $receiptTitle = $isReturned ? 'Bukti Pengembalian Buku' : 'Bukti Peminjaman Buku';
@endphp

<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 18mm;
        }

        body * {
            visibility: hidden !important;
        }

        #printable-receipt,
        #printable-receipt * {
            visibility: visible !important;
        }

        #printable-receipt {
            position: absolute;
            inset: 0;
            width: 100%;
            max-width: none !important;
            margin: 0 !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        .receipt-print-color {
            color: #172033 !important;
            background: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<div class="mx-auto max-w-3xl space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3 print:hidden">
        <a href="{{ route('siswa.riwayat') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"/></svg>
            Kembali ke riwayat
        </a>
        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-blue-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-950 focus:outline-none focus:ring-4 focus:ring-blue-200">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5h-2M6 14h12v8H6z"/></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    <article id="printable-receipt" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <header class="receipt-print-color border-b border-blue-100 bg-gradient-to-r from-blue-950 to-blue-800 px-6 py-7 text-white sm:px-9">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-start">
                <div>
                    <p class="text-xs font-bold tracking-[0.2em] text-blue-200">LUXURIOUS</p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">{{ $receiptTitle }}</h1>
                    <p class="mt-2 text-sm text-blue-100">Dokumen transaksi peminjaman perpustakaan</p>
                </div>
                <div class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 sm:text-right">
                    <p class="text-xs text-blue-100">Nomor transaksi</p>
                    <p class="mt-1 font-mono text-lg font-bold">#{{ str_pad($data->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </header>

        <div class="space-y-7 p-6 sm:p-9">
            <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border px-4 py-3 {{ $isReturned ? 'border-emerald-200 bg-emerald-50' : ($isOverdue ? 'border-rose-200 bg-rose-50' : 'border-blue-200 bg-blue-50') }}">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full {{ $isReturned ? 'bg-emerald-100 text-emerald-700' : ($isOverdue ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700') }}">
                        @if($isReturned)
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/></svg>
                        @else
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="M12 7v5l3 2"/></svg>
                        @endif
                    </span>
                    <div>
                        <p class="text-sm font-bold {{ $isReturned ? 'text-emerald-900' : ($isOverdue ? 'text-rose-900' : 'text-blue-900') }}">
                            {{ $isReturned ? 'Pengembalian telah dikonfirmasi' : ($isOverdue ? 'Pinjaman melewati batas pengembalian' : 'Peminjaman telah disetujui') }}
                        </p>
                        <p class="mt-0.5 text-xs text-slate-600">Status: {{ $isReturned ? 'Dikembalikan' : ($isOverdue ? 'Terlambat' : 'Dipinjam') }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">Dicetak {{ now()->format('d M Y, H:i') }}</p>
            </div>

            <section>
                <h2 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Informasi peminjam</h2>
                <dl class="mt-3 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <dt class="text-xs text-slate-500">Nama</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $data->user->nama ?? 'Siswa' }}</dd>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <dt class="text-xs text-slate-500">Email</dt>
                        <dd class="mt-1 break-all font-semibold text-slate-900">{{ $data->user->email ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section>
                <h2 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Informasi buku</h2>
                <div class="mt-3 overflow-hidden rounded-xl border border-slate-200">
                    <dl class="divide-y divide-slate-100">
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-[12rem_1fr] sm:gap-4">
                            <dt class="text-sm text-slate-500">Judul buku</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $data->buku->judul ?? 'Buku tidak tersedia' }}</dd>
                        </div>
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-[12rem_1fr] sm:gap-4">
                            <dt class="text-sm text-slate-500">Penulis</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $data->buku->penulis ?? '-' }}</dd>
                        </div>
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-[12rem_1fr] sm:gap-4">
                            <dt class="text-sm text-slate-500">Jumlah</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $data->jumlah }} buku</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <section>
                <h2 class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Tanggal transaksi</h2>
                <dl class="mt-3 grid gap-3 sm:grid-cols-{{ $isReturned ? '3' : '2' }}">
                    <div class="rounded-xl border border-slate-200 p-4">
                        <dt class="text-xs text-slate-500">Tanggal pinjam</dt>
                        <dd class="mt-1.5 font-semibold text-slate-900">{{ $data->tanggal_pinjam->format('d M Y') }}</dd>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-4">
                        <dt class="text-xs text-slate-500">Batas pengembalian</dt>
                        <dd class="mt-1.5 font-semibold text-slate-900">{{ $data->tanggal_kembali->format('d M Y') }}</dd>
                    </div>
                    @if($isReturned)
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50/60 p-4">
                            <dt class="text-xs text-emerald-800">Diterima kembali pada</dt>
                            <dd class="mt-1.5 font-semibold text-emerald-950">{{ $data->tanggal_dikembalikan ? $data->tanggal_dikembalikan->format('d M Y') : 'Tidak tercatat' }}</dd>
                        </div>
                    @endif
                </dl>
            </section>

            <div class="rounded-xl border border-dashed border-slate-300 px-4 py-3 text-xs leading-5 text-slate-600">
                {{ $isReturned
                    ? 'Simpan bukti ini sebagai catatan bahwa buku di atas telah diterima kembali oleh perpustakaan.'
                    : 'Simpan bukti ini dan kembalikan buku paling lambat pada tanggal batas pengembalian yang tertera.' }}
            </div>

            <div class="hidden grid-cols-2 gap-10 pt-2 sm:grid print:grid">
                <div class="text-center text-xs text-slate-600">
                    <p>{{ $isReturned ? 'Yang menyerahkan' : 'Peminjam' }}</p>
                    <div class="mx-auto mt-16 max-w-48 border-t border-slate-400 pt-2">{{ $data->user->nama ?? 'Siswa' }}</div>
                </div>
                <div class="text-center text-xs text-slate-600">
                    <p>Petugas perpustakaan</p>
                    <div class="mx-auto mt-16 max-w-48 border-t border-slate-400 pt-2">Tanda tangan / stempel</div>
                </div>
            </div>
        </div>
    </article>

    @if($isReturned)
        <section class="print:hidden rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">
            <h2 class="font-bold text-slate-900">Bagikan ulasan buku</h2>
            <p class="mt-1 text-sm text-slate-500">Bantu pembaca lain dengan membagikan pendapatmu.</p>
            <form action="{{ route('siswa.ulasan.simpan') }}" method="POST" class="mt-4 grid gap-4 sm:grid-cols-[12rem_1fr_auto] sm:items-end">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $data->buku_id }}">
                <div>
                    <label for="rating" class="mb-1.5 block text-xs font-semibold text-slate-700">Rating</label>
                    <select id="rating" name="rating" required class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <option value="">Pilih rating</option>
                        @for($rating = 5; $rating >= 1; $rating--)
                            <option value="{{ $rating }}" @selected(old('rating') == $rating)>{{ $rating }} dari 5</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="komentar" class="mb-1.5 block text-xs font-semibold text-slate-700">Komentar</label>
                    <textarea id="komentar" name="komentar" rows="2" required class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" placeholder="Ceritakan kesanmu membaca buku ini...">{{ old('komentar') }}</textarea>
                </div>
                <button type="submit" class="rounded-xl bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-950">Kirim ulasan</button>
            </form>
        </section>
    @endif
</div>
@endsection
