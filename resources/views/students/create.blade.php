<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Siswa - KasKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <nav class="navbar navbar-dark bg-primary shadow-sm">

        <div class="container">

            <a class="navbar-brand fw-bold"
               href="{{ route('dashboard') }}">
                💰 KasKu
            </a>

            <a href="{{ route('students.index') }}"
               class="btn btn-light">
                Kembali
            </a>

        </div>

    </nav>


    <main class="container py-5">

        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible fade show"
                 role="alert">

                <strong>Terjadi kesalahan!</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <div class="row justify-content-center">

            <div class="col-md-7">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h3 class="fw-bold">
                            Tambah Siswa
                        </h3>

                        <p class="text-muted mb-4">
                            Masukkan data anggota kelas.
                        </p>


                        <form action="{{ route('students.store') }}"
                              method="POST">

                            @csrf


                            {{-- Nama --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Nama Siswa
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    class="form-control"
                                    placeholder="Contoh: Ahmad"
                                    value="{{ old('nama') }}"
                                    required
                                >

                            </div>


                            {{-- Kelas --}}

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Kelas
                                </label>

                                <input
                                    type="text"
                                    name="kelas"
                                    class="form-control"
                                    placeholder="Contoh: XII RPL"
                                    value="{{ old('kelas') }}"
                                >

                            </div>


                            {{-- NIS --}}

                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    NIS
                                </label>

                                <input
                                    type="text"
                                    name="nis"
                                    class="form-control"
                                    placeholder="Contoh: 12345"
                                    value="{{ old('nis') }}"
                                >

                            </div>


                            <div class="d-flex gap-2">

                                <a href="{{ route('students.index') }}"
                                   class="btn btn-secondary">

                                    Batal

                                </a>

                                <button type="submit"
                                        class="btn btn-primary">

                                    Simpan Siswa

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>

</html>