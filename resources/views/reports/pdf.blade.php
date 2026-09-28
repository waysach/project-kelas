<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Laporan Kas {{ $bulan }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin-top: 5px;
            font-size: 12px;
        }

        .summary {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary td {
            width: 33.33%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .summary-title {
            font-size: 11px;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
        }

        table.transactions {
            width: 100%;
            border-collapse: collapse;
        }

        table.transactions th,
        table.transactions td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        table.transactions th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .pemasukan {
            color: green;
        }

        .pengeluaran {
            color: red;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>LAPORAN KAS</h1>
        <p>Periode: {{ $bulan }}</p>
    </div>

    {{-- Ringkasan --}}
    <table class="summary">
        <tr>
            <td>
                <div class="summary-title">
                    Total Pemasukan
                </div>

                <div class="summary-value pemasukan">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    Total Pengeluaran
                </div>

                <div class="summary-value pengeluaran">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    Saldo
                </div>

                <div class="summary-value">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    {{-- Daftar transaksi --}}
    <table class="transactions">
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="18%">Tanggal</th>
                <th>Keterangan</th>
                <th width="18%">Jenis</th>
                <th width="22%">Jumlah</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($transaksi as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $item->keterangan }}
                    </td>

                    <td class="text-center">
                        @if ($item->jenis === 'pemasukan')
                            <span class="pemasukan">
                                Pemasukan
                            </span>
                        @else
                            <span class="pengeluaran">
                                Pengeluaran
                            </span>
                        @endif
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada transaksi pada bulan ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan Kas — {{ $bulan }}
    </div>

</body>
</html>