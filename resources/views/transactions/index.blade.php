<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Transaksi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                💰 KasKu
            </a>

            <span class="text-white">
                Data Transaksi
            </span>
        </div>
    </nav>

    <main class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

<div>
    <h2 class="fw-bold mb-1">
        Data Transaksi
    </h2>

    <p class="text-muted mb-0">
        Daftar pemasukan dan pengeluaran kas.
    </p>

<form action="{{ route('transactions.index') }}" method="GET" class="mt-3">

    <div class="row g-2">

        <div class="col-md-6">

            <div class="input-group">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari keterangan transaksi..."
                    value="{{ $search ?? '' }}"
                >

                <button type="submit" class="btn btn-primary">
                    🔎 Cari
                </button>

            </div>

        </div>

        <div class="col-md-3">

            <select name="jenis" class="form-select">

                <option value="">
                    Semua Jenis
                </option>

                <option value="pemasukan"
                    {{ ($jenis ?? '') == 'pemasukan' ? 'selected' : '' }}>
                    Pemasukan
                </option>

                <option value="pengeluaran"
                    {{ ($jenis ?? '') == 'pengeluaran' ? 'selected' : '' }}>
                    Pengeluaran
                </option>

            </select>

        </div>

        <div class="col-md-3">

            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary w-100">
                    Filter
                </button>

                @if (!empty($search) || !empty($jenis))

                    <a href="{{ route('transactions.index') }}"
                       class="btn btn-secondary">
                        Reset
                    </a>

                @endif

            </div>

        </div>

    </div>

</form>


            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                    + Tambah Transaksi
            </a>

        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>
            </div>
        @endif

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($transactions as $transaction)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $transaction->tanggal->format('d-m-Y') }}
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

                                    <td>
                                 Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                    </td>

                                    <td>
    <a href="{{ route('transactions.edit', $transaction) }}"
       class="btn btn-sm btn-warning">
        Edit
    </a>

    <form action="{{ route('transactions.destroy', $transaction) }}"
          method="POST"
          class="d-inline"
          onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-sm btn-danger">
            Hapus
        </button>

    </form>
</td>

</tr>
                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada transaksi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
@if ($transactions->hasPages())

    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="text-muted small">
            Menampilkan
            {{ $transactions->firstItem() }}
            -
            {{ $transactions->lastItem() }}
            dari
            {{ $transactions->total() }}
            transaksi
        </div>

        <div>
            {{ $transactions->links() }}
        </div>

    </div>

@endif
                </div>

            </div>

        </div>

    </main>

</body>

</html>