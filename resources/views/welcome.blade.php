<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Kas Keuangan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

        <div class="container">

            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                kasKu
            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link active"
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

                </ul>

            </div>

        </div>

    </nav>


    <!-- Content -->
    <main class="container py-4">

        <!-- Header -->
        <div class="mb-4">

    <h2 class="fw-bold">
        Dashboard
    </h2>

    <p class="text-muted mb-3">
        Selamat datang di Sistem Informasi Kas Keuangan
    </p>

    <!-- Filter Bulan -->
    <form action="{{ route('dashboard') }}" method="GET">

        <div class="row align-items-end">

            <div class="col-md-4">

                <label for="bulan" class="form-label fw-semibold">
                    Pilih Bulan
                </label>

                <input type="month"
                    name="bulan"
                    id="bulan"
                    class="form-control"
                    value="{{ $bulanDipilih }}"
                    required>

            </div>

            <div class="col-md-3 mt-3 mt-md-0">

                <button type="submit" class="btn btn-primary">
                    Tampilkan
                </button>

            </div>

        </div>

    </form>
        

    <p class="text-muted mt-3 mb-0">
        Menampilkan data periode:
        <strong>
            {{ \Carbon\Carbon::createFromFormat('Y-m', $bulanDipilih)->translatedFormat('F Y') }}
        </strong>
    </p>

</div>


        <!-- Summary Cards -->
        <div class="row g-4">


            <!-- Saldo -->
            <div class="col-md-4">

                <div class="card dashboard-card h-100 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Saldo Saat Ini
                                </p>

                                <h3 class="fw-bold text-primary">

                                    Rp {{ number_format($saldo, 0, ',', '.') }}

                                </h3>

                            </div>

                            <div class="fs-1">
                                💰
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Pemasukan -->
            <div class="col-md-4">

                <div class="card dashboard-card h-100 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Pemasukan
                                </p>

                                <h3 class="fw-bold text-success">

                                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}

                                </h3>

                            </div>

                            <div class="fs-1">
                                📈
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Pengeluaran -->
            <div class="col-md-4">

                <div class="card dashboard-card h-100 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Pengeluaran
                                </p>

                                <h3 class="fw-bold text-danger">

                                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}

                                </h3>

                            </div>

                            <div class="fs-1">
                                📉
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Grafik Keuangan -->
        <div class="card mt-4 shadow-sm">

            <div class="card-body">

                <h4 class="fw-bold mb-1">
                    Grafik Keuangan
                </h4>

                <p class="text-muted mb-4">
                    Perbandingan pemasukan dan pengeluaran 6 bulan terakhir
                </p>

                <div style="height: 350px;">
                    <canvas id="keuanganChart"></canvas>
                </div>

            </div>

        </div>


        <!-- Transaksi Terbaru -->
        <div class="card table-card mt-4 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Transaksi Terbaru
                        </h4>

                        <small class="text-muted">
                            Daftar transaksi kasKu
                        </small>

                    </div>

                    <div class="d-flex gap-2">

    <a href="{{ route('transactions.index') }}"
        class="btn btn-outline-primary">
        Lihat Semua
    </a>

    <a href="{{ route('transactions.create') }}"
        class="btn btn-primary">
        + Tambah Transaksi
    </a>

</div>


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

                            @forelse ($transaksiTerbaru as $index => $transaction)

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

                                        Belum ada transaksi.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>


    <!-- Footer -->
    <footer class="text-center text-muted py-4">

        <small>
            2026 Sistem Informasi Kas Keuangan
        </small>

    </footer>
<script type="application/json" id="bulanData">
    @json($bulan)
</script>

<script type="application/json" id="pemasukanData">
    @json($pemasukanBulanan)
</script>

<script type="application/json" id="pengeluaranData">
    @json($pengeluaranBulanan)
</script>

<!-- Script Grafik -->
<script>
    const ctx = document.getElementById('keuanganChart');

    new Chart(ctx, {
        type: 'bar',

        data: {
            labels: JSON.parse(
                document.getElementById('bulanData').textContent
            ),

            datasets: [
                {
                    label: 'Pemasukan',

                    data: JSON.parse(
                        document.getElementById('pemasukanData').textContent
                    ),

                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderRadius: 6
                },

                {
                    label: 'Pengeluaran',

                    data: JSON.parse(
                        document.getElementById('pengeluaranData').textContent
                    ),

                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderRadius: 6
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                mode: 'index',
                intersect: false
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },

            plugins: {
                legend: {
                    position: 'top'
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {

                            let value = context.raw;

                            return context.dataset.label +
                                ': Rp ' +
                                value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>


</body>

</html>