<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Petugas - Luxurious</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px; background: #eff6ff; color: #172033; font: 13px Arial, sans-serif; }
        .report { max-width: 1000px; margin: 0 auto; padding: 28px; border: 1px solid #dbeafe; border-radius: 16px; background: #fff; box-shadow: 0 8px 24px #173b7012; }
        .toolbar { display: flex; justify-content: flex-end; margin-bottom: 20px; }
        .print-button { border: 0; border-radius: 8px; padding: 11px 18px; background: #173b70; color: #fff; font-weight: 700; cursor: pointer; }
        .heading { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; padding-bottom: 18px; border-bottom: 2px solid #173b70; }
        .brand { margin: 0 0 5px; color: #173b70; font-size: 15px; font-weight: 700; letter-spacing: 1px; }
        h1 { margin: 0; font-size: 23px; }
        .subheading, .meta { margin: 7px 0 0; color: #64748b; }
        .meta { text-align: right; line-height: 1.7; }
        .summary { margin: 16px 0 10px; color: #475569; }
        table { width: 100%; border-collapse: collapse; }
        thead { display: table-header-group; background: #dbeafe; }
        th, td { border: 1px solid #bfdbfe; padding: 10px; text-align: left; vertical-align: top; }
        th { color: #173b70; font-size: 11px; text-transform: uppercase; }
        td.center, th.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f8fbff; }
        .empty { padding: 24px; text-align: center; color: #64748b; }
        @media print {
            @page { size: A4 portrait; margin: 14mm; }
            body { padding: 0; background: #fff; font-size: 10px; }
            .report { max-width: none; padding: 0; border: 0; border-radius: 0; box-shadow: none; }
            .toolbar { display: none; }
            h1 { font-size: 19px; }
            th, td { padding: 7px; }
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
            <h1>Laporan Data Petugas</h1>
            <p class="subheading">Daftar akun petugas perpustakaan</p>
        </div>
        <p class="meta">
            Dicetak: {{ now()->format('d-m-Y H:i') }}<br>
            @if($search !== '') Pencarian: {{ $search }} @endif
        </p>
    </header>
    <p class="summary">Total data: <strong>{{ $petugas->count() }} petugas</strong></p>
    <table>
        <thead>
            <tr>
                <th class="center">No.</th>
                <th>Nama Petugas</th>
                <th>Email</th>
                <th class="center">Tanggal Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $data)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->email }}</td>
                    <td class="center">{{ $data->created_at ? $data->created_at->format('d-m-Y') : '-' }}</td>
                </tr>
            @empty
                <tr><td class="empty" colspan="4">Tidak ada data petugas untuk ditampilkan.</td></tr>
            @endforelse
        </tbody>
    </table>
</main>
</body>
</html>
