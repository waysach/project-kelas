<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Transaksi - KasKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/">
            💰 KasKu
        </a>

        <a href="{{ route('transactions.index') }}"
           class="btn btn-light">
            Kembali
        </a>

    </div>
</nav>


<main class="container py-5">
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

        <div class="col-md-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h3 class="fw-bold">
                        Tambah Transaksi
                    </h3>

                    <p class="text-muted mb-4">
                        Masukkan data pemasukan atau pengeluaran.
                    </p>





                    <form action="{{ route('transactions.store') }}"
                          method="POST">

                        @csrf


                        <!-- Tanggal -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                class="form-control"
                                value="{{ old('tanggal') }}"
                                required
                            >

                        </div>


                        <!-- Keterangan -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Keterangan
                            </label>

                            <input
                                type="text"
                                name="keterangan"
                                class="form-control"
                                placeholder="Contoh: Uang kas"
                                value="{{ old('keterangan') }}"
                                required
                            >

                        </div>


                        <!-- Jenis -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Jenis Transaksi
                            </label>

                            <select
                                name="jenis"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis --
                                </option>

                                <option value="pemasukan">
                                    Pemasukan
                                </option>

                                <option value="pengeluaran">
                                    Pengeluaran
                                </option>

                            </select>

                        </div>


                        <!-- Jumlah -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Jumlah
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="jumlah"
                                    class="form-control"
                                    placeholder="500000"
                                    min="0"
                                    value="{{ old('jumlah') }}"
                                    required
                                >

                            </div>

                        </div>


                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('transactions.index') }}"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Simpan Transaksi
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

</body>
</html>l>