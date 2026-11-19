<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Daftar Sekolah</h1>
        <a href="{{ route('siswa') }}" class="btn btn-primary">Daftar Siswa</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            {{ $editing ? 'Edit Sekolah' : 'Tambah Sekolah' }}
        </div>
        <div class="card-body">
            <form method="POST"
                action="{{ $editing ? route('sekolah.update', $editing) : route('sekolah.store') }}">
                @csrf
                @if ($editing) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Sekolah</label>
                        <input type="text" name="nama" class="form-control"
                            value="{{ old('nama', $editing?->nama) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                            value="{{ old('alamat', $editing?->alamat) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kuota</label>
                        <input type="number" name="kuota" class="form-control" min="0"
                            value="{{ old('kuota', $editing?->kuota) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Terisi</label>
                        <input type="number" name="terisi" class="form-control" min="0"
                            value="{{ old('terisi', $editing?->terisi ?? 0) }}" required>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $editing ? 'Simpan Perubahan' : 'Tambah' }}
                    </button>
                    @if ($editing)
                        <a href="{{ route('sekolah') }}" class="btn btn-outline-secondary">Batal</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Sekolah</th>
                    <th>Alamat Sekolah</th>
                    <th>Kuota</th>
                    <th>Terisi</th>
                    <th>Sisa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schools as $sc)
                <tr>
                    <td>{{ $schools->firstItem() + $loop->index }}</td>
                    <td>{{ $sc->nama }}</td>
                    <td>{{ $sc->alamat }}</td>
                    <td>{{ $sc->kuota }}</td>
                    <td>{{ $sc->terisi }}</td>
                    <td>{{ $sc->kuota - $sc->terisi }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('sekolah', ['edit' => $sc->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                    <form action="{{ route('sekolah.destroy', $sc) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus sekolah ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $schools->links() }}

</div>
</body>
</html>