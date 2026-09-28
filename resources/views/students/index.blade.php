<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa - KasKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            💰 KasKu
        </a>

        <a href="{{ route('dashboard') }}" class="btn btn-light">
            Dashboard
        </a>

    </div>
</nav>

<main class="container py-4">

    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <strong>Berhasil!</strong>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Data Siswa
            </h2>

            <p class="text-muted mb-0">
                Daftar anggota kelas yang terdaftar.
            </p>
        </div>

        <a href="{{ route('students.create') }}"
           class="btn btn-primary">
            + Tambah Siswa
        </a>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>NIS</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($students as $student)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $student->nama }}
                                </td>

                                <td>
                                    {{ $student->kelas ?? '-' }}
                                </td>

                                <td>
                                    {{ $student->nis ?? '-' }}
                                </td>

                                <td>

                                    <a href="{{ route('students.edit', $student) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('students.destroy', $student) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="text-center py-4 text-muted">
                                    Belum ada data siswa.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

</body>

</html>