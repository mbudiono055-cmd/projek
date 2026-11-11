<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $jenis === 'pengembalian' ? 'Laporan Pengembalian' : ($jenis === 'peminjaman' ? 'Laporan Peminjaman Aktif' : 'Laporan Peminjaman dan Pengembalian') }} - Luxurious</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px; color: #172033; font: 13px Arial, sans-serif; }
        .report { max-width: 1200px; margin: 0 auto; }
        .toolbar { display: flex; justify-content: flex-end; margin-bottom: 20px; }
        .print-button { border: 0; border-radius: 8px; padding: 11px 18px; background: #173b70; color: #fff; font-weight: 700; cursor: pointer; }
        .heading { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; padding-bottom: 18px; border-bottom: 2px solid #173b70; }
        .brand { margin: 0 0 5px; color: #173b70; font-size: 15px; font-weight: 700; letter-spacing: 1px; }
        h1 { margin: 0; font-size: 23px; }
        .subheading, .meta { margin: 7px 0 0; color: #64748b; }
        .meta { text-align: right; line-height: 1.7; }
        .summary { margin: 16px 0 10px; color: #475569; }
        table { width: 100%; border-collapse: collapse; }
        thead { display: table-header-group; background: #eaf0f8; }
        th, td { border: 1px solid #cbd5e1; padding: 9px 8px; text-align: left; vertical-align: top; }
        th { color: #173b70; font-size: 11px; text-transform: uppercase; }
        td.center, th.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .empty { padding: 24px; text-align: center; color: #64748b; }
        @media print {
            @page { size: A4 landscape; margin: 12mm; }
            body { padding: 0; font-size: 10px; }
            .report { max-width: none; }
            .toolbar { display: none; }
            h1 { font-size: 19px; }
            th, td { padding: 6px; }
            tr { break-inside: avoid; }
        }
    </style>
</head>
<body>
<main class="report">
    <div class="toolbar">
        <button class="print-button" type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>
    <header class="heading">
        <div>
            <p class="brand">LUXURIOUS</p>
            <h1>{{ $jenis === 'pengembalian' ? 'Laporan Pengembalian Buku' : ($jenis === 'peminjaman' ? 'Laporan Peminjaman Aktif' : 'Laporan Peminjaman dan Pengembalian') }}</h1>
            <p class="subheading">Daftar transaksi peminjaman, status, dan pengembalian buku</p>
        </div>
        <p class="meta">
            Dicetak: {{ now()->format('d-m-Y H:i') }}<br>
            @if($search !== '') Pencarian: {{ $search }}<br> @endif
            @if($status !== '') Status: {{ ucfirst($status) }} @endif
        </p>
    </header>
    <p class="summary">Total transaksi: <strong>{{ $data->count() }}</strong></p>
    <table>
        <thead>
            <tr>
                <th class="center">No.</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>Judul Buku</th>
                <th class="center">Jumlah</th>
                <th class="center">Tanggal Pinjam</th>
                <th class="center">Batas Kembali</th>
                <th class="center">Dikembalikan Pada</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->user->nama ?? '-' }}</td>
                    <td>{{ $item->user->email ?? '-' }}</td>
                    <td>{{ $item->buku->judul ?? '-' }}</td>
                    <td class="center">{{ $item->jumlah }}</td>
                    <td class="center">{{ $item->tanggal_pinjam ? $item->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                    <td class="center">{{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d-m-Y') : '-' }}</td>
                    <td class="center">{{ $item->tanggal_dikembalikan ? $item->tanggal_dikembalikan->format('d-m-Y') : '-' }}</td>
                    <td class="center">{{ ['menunggu' => 'Menunggu', 'diterima' => 'Dipinjam', 'ditolak' => 'Ditolak', 'terlambat' => 'Terlambat', 'dikembalikan' => 'Dikembalikan'][$item->status] ?? ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr><td class="empty" colspan="9">Tidak ada transaksi untuk ditampilkan.</td></tr>
            @endforelse
        </tbody>
    </table>
</main>
</body>
</html>
