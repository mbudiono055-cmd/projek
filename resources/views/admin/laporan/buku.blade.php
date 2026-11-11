<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Buku - Luxurious</title>
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
            <h1>Laporan Data Buku</h1>
            <p class="subheading">Daftar koleksi buku perpustakaan</p>
        </div>
        <p class="meta">
            Dicetak: {{ now()->format('d-m-Y H:i') }}<br>
            @if($search !== '') Pencarian: {{ $search }}<br> @endif
            @if($status !== '') Status: {{ ucfirst($status) }} @endif
        </p>
    </header>
    <p class="summary">Total data: <strong>{{ $buku->count() }} buku</strong></p>
    <table>
        <thead>
            <tr>
                <th class="center">No.</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Kategori</th>
                <th class="center">Tahun</th>
                <th class="center">Stok</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buku as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td class="center">{{ $item->tahun_terbit }}</td>
                    <td class="center">{{ $item->stok }}</td>
                    <td>{{ ucfirst($item->status_validasi ?? 'disetujui') }}</td>
                </tr>
            @empty
                <tr><td class="empty" colspan="8">Tidak ada data buku untuk ditampilkan.</td></tr>
            @endforelse
        </tbody>
    </table>
</main>
</body>
</html>
