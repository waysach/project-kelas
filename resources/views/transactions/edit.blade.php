<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Transaksi - KasKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="container py-5">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan!</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>
    </div>
@endif

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card dashboard-card">

                <div class="card-body p-4">

                    <h3 class="mb-4">Edit Transaksi</h3>

                    

                    <form action="{{ route('transactions.update', $transaction) }}" method="POST">

                        @csrf
                        @method('PUT')

                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                id="tanggal"
                                class="form-control"
                                value="{{ old('tanggal', $transaction->tanggal->format('Y-m-d')) }}"
                                required
                            >
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">
                                Keterangan
                            </label>

                            <input
                                type="text"
                                name="keterangan"
                                id="keterangan"
                                class="form-control"
                                value="{{ old('keterangan', $transaction->keterangan) }}"
                                placeholder="Contoh: Pembayaran listrik"
                                required
                            >
                        </div>

                        {{-- Jenis --}}
                        <div class="mb-3">
                            <label for="jenis" class="form-label">
                                Jenis Transaksi
                            </label>

                            <select
    name="jenis"
    id="jenis"
    class="form-select"
    required
>
    <option value="pemasukan"
        {{ old('jenis', $transaction->jenis) == 'pemasukan' ? 'selected' : '' }}>
        Pemasukan
    </option>

    <option value="pengeluaran"
        {{ old('jenis', $transaction->jenis) == 'pengeluaran' ? 'selected' : '' }}>
        Pengeluaran
    </option>
</select>
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-4">
                            <label for="jumlah" class="form-label">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                name="jumlah"
                                id="jumlah"
                                class="form-control"
                                value="{{ old('jumlah', $transaction->jumlah) }}"
                                placeholder="Contoh: 50000"
                                min="0"
                                required
                            >
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('transactions.index') }}"
                               class="btn btn-secondary">
                                Batal
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>