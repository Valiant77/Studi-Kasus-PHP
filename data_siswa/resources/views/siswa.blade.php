<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daftar Siswa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-white">
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Daftar Siswa</h1>
            <a href="{{ route('sekolah') }}" class="btn btn-primary">Daftar Sekolah</a>
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
                {{ $editing ? 'Edit Siswa' : 'Tambah Siswa' }}
            </div>
            <div class="card-body">
                <form method="POST"
                    action="{{ $editing ? route('siswa.update', $editing) : route('siswa.store') }}">
                    @csrf
                    @if ($editing) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control"
                                inputmode="numeric" pattern="[0-9]+" maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/\D/g, '')"
                                value="{{ old('nis', $editing?->nis) }}" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                pattern="[\p{L}\s.'\-]+" maxlength="255"
                                oninput="this.value = this.value.replace(/[^\p{L}\s.'\-]/gu, '')"
                                value="{{ old('nama', $editing?->nama) }}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-select" required></select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-select" required></select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Sekolah</label>
                            <select name="sekolah_id" class="form-select" required>
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        @selected(old('school_id', $editing?->sekolah_id) == $school->id)>
                                        {{ $school->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tgl_masuk" class="form-control"
                                value="{{ old('tgl_masuk', $editing?->tgl_masuk) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                @foreach (['laki-laki', 'perempuan'] as $jk)
                                    <option value="{{ $jk }}" @selected(old('jenis_kelamin', $editing?->jenis_kelamin) === $jk)>
                                        {{ ucfirst($jk) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            {{ $editing ? 'Simpan Perubahan' : 'Tambah' }}
                        </button>
                        @if ($editing)
                            <a href="{{ route('siswa') }}" class="btn btn-outline-secondary">Batal</a>
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
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Sekolah</th>
                        <th>Tanggal Masuk</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $st)
                    <tr>
                        <td>{{ $students->firstItem() + $loop->index }}</td>
                        <td>{{ $st->nis }}</td>
                        <td>{{ $st->nama }}</td>
                        <td>{{ $st->kelas }}</td>
                        <td>{{ $st->jurusan }}</td>
                        <td>{{ $st->school->nama }}</td>
                        <td>{{ $st->tgl_masuk }}</td>
                        <td>{{ ucfirst($st->jenis_kelamin) }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('siswa', ['edit' => $st->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                            <form action="{{ route('siswa.destroy', $st) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus siswa ini?')">
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

        {{ $students->links() }}

    </div>
    </body>
    <script>
        const schoolData = @json($schools->mapWithKeys(fn ($s) => [$s->id => ['kelas' => $s->kelasList(), 'jurusan' => $s->jurusan]]));
        const selected = {
            kelas:   @json(old('kelas', $editing?->kelas)),
            jurusan: @json(old('jurusan', $editing?->jurusan)),
        };

        const schoolEl = document.getElementById('school');

        function fill(id, items) {
            const el = document.getElementById(id);
            el.innerHTML = '';
            items.forEach(v => el.add(new Option(v, v, false, v === selected[id])));
        }

        function refresh() {
            const d = schoolData[schoolEl.value] ?? { kelas: [], jurusan: [] };
            fill('kelas', d.kelas);
            fill('jurusan', d.jurusan);
            selected.kelas = selected.jurusan = null; // preselect only on first load
        }

        schoolEl.addEventListener('change', refresh);
        refresh();
    </script>
</html>