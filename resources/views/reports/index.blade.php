<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">

```
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Laporan Kas Keuangan</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
            .chart-card {
            border: none;
            border-radius: 12px;
        }

        .chart-item {
            margin-bottom: 20px;
        }

        .chart-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 7px;
            font-weight: 600;
        }

        .chart-bar {
            width: 100%;
            height: 24px;
            background-color: #e9ecef;
            border-radius: 20px;
            overflow: hidden;
        }

        .chart-fill {
            height: 100%;
            border-radius: 20px;
            min-width: 2px;
            transition: width 0.5s ease;
        }

        .chart-income {
            background-color: #198754;
        }

        .chart-expense {
            background-color: #dc3545;
        }
    @media print {

        .navbar,
        footer,
        form,
        button,
        .btn {
            display: none !important;
        }

        body {
            background: white !important;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
        }

        main {
            padding-top: 0 !important;
        }

        .table {
            width: 100%;
        }

        .badge {
            border: 1px solid #000;
            color: #000 !important;
            background: white !important;
        }
    }
</style>
```

</head>

<body>

```
<!-- =========================
     NAVBAR
========================== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            kasKu
        </a>

        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMenu"
            aria-controls="navbarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('transactions.index') }}">
                        Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active"
                        href="{{ route('reports.index') }}">
                        Laporan
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- =========================
     CONTENT
========================== -->
<main class="container py-4">


    <!-- =========================
         HEADER LAPORAN
    ========================== -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Laporan Kas
            </h2>

            <p class="text-muted mb-0">
                Laporan transaksi berdasarkan bulan
            </p>

        </div>

        <div>

            <a href="{{ route('reports.pdf', ['bulan' => $bulan]) }}"
                class="btn btn-danger">
                📄 Download PDF
            </a>

        </div>

    </div>


    <!-- =========================
         FILTER BULAN
    ========================== -->
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form action="{{ route('reports.index') }}" method="GET">

                <div class="row align-items-end">

                    <div class="col-md-5">

                        <label for="bulan"
                            class="form-label fw-semibold">
                            Pilih Bulan
                        </label>

                        <input type="month"
                            name="bulan"
                            id="bulan"
                            class="form-control"
                            value="{{ $bulan }}"
                            required>

                    </div>

                    <div class="col-md-3 mt-3 mt-md-0">

                        <button type="submit"
                            class="btn btn-primary">

                            Tampilkan Laporan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- =========================
         SUMMARY
    ========================== -->
    <div class="row g-4">


        <!-- Total Pemasukan -->
        <div class="col-md-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Total Pemasukan
                    </p>

                    <h3 class="fw-bold text-success mb-0">

                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>


        <!-- Total Pengeluaran -->
        <div class="col-md-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Total Pengeluaran
                    </p>

                    <h3 class="fw-bold text-danger mb-0">

                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>


        <!-- Saldo -->
        <div class="col-md-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Saldo Bulan Ini
                    </p>

                    <h3 class="fw-bold text-primary mb-0">

                        Rp {{ number_format($saldo, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

<!-- =========================
     GRAFIK STATISTIK
========================== -->

@php
    $totalGrafik = max($totalPemasukan, $totalPengeluaran, 1);

    $persenPemasukan = ($totalPemasukan / $totalGrafik) * 100;
    $persenPengeluaran = ($totalPengeluaran / $totalGrafik) * 100;
@endphp

<div class="card shadow-sm chart-card mt-4">

    <div class="card-body">

        <h4 class="fw-bold mb-1">
            Statistik Keuangan
        </h4>

        <p class="text-muted mb-4">
            Perbandingan pemasukan dan pengeluaran pada bulan ini
        </p>


        <!-- Pemasukan -->
        <div class="chart-item">

            <div class="chart-label">

                <span class="text-success">
                    Pemasukan
                </span>

                <span>
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </span>

            </div>

            <div class="chart-bar">

                <div class="chart-fill chart-income"
                    @style(['width' => $persenPemasukan . '%']) >
                </div>

            </div>

        </div>


        <!-- Pengeluaran -->
        <div class="chart-item mb-0">

            <div class="chart-label">

                <span class="text-danger">
                    Pengeluaran
                </span>

                <span>
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </span>

            </div>

            <div class="chart-bar">

                <div class="chart-fill chart-expense"
                    @style(['width' => $persenPengeluaran . '%']) >
                </div>

            </div>

        </div>

    </div>

</div>
    <!-- =========================
         DAFTAR TRANSAKSI
    ========================== -->
    <div class="card shadow-sm mt-4">

        <div class="card-body">


            <!-- Judul Tabel -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h4 class="fw-bold mb-1">
                        Daftar Transaksi
                    </h4>

                    <small class="text-muted">

                        Transaksi pada bulan
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->format('F Y') }}

                    </small>

                </div>


                <!-- Tombol Cetak -->
                <button onclick="window.print()"
                    class="btn btn-success">

                    🖨 Cetak Laporan

                </button>

            </div>


            <!-- =========================
                 TABLE
            ========================== -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Keterangan</th>

                            <th>Jenis</th>

                            <th>Jumlah</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($transaksi as $index => $transaction)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ $transaction->keterangan }}
                                </td>

                                <td>

                                    @if ($transaction->jenis === 'pemasukan')

                                        <span class="badge bg-success">
                                            Pemasukan
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Pengeluaran
                                        </span>

                                    @endif

                                </td>

                                <td class="fw-semibold">

                                    Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-4">

                                    Tidak ada transaksi pada bulan ini.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>


<!-- =========================
     FOOTER
========================== -->
<footer class="text-center text-muted py-4">

    <small>
        2026 Sistem Informasi Kas Keuangan
    </small>

</footer>
```

</body>

</html>
