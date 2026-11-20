<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Menu Kantin Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="card shadow-sm w-100" style="max-width: 860px;">
            <div class="card-header bg-primary text-white py-3">
                <h1 class="h5 mb-0">Daftar Menu Kantin Sekolah</h1>
            </div>

            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menu as $m)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>{{ $m['nama'] }}</td>
                        <td class="text-nowrap">Rp {{ $m['harga'] }}</td>
                        <td>
                            <form action="{{ route('change', $m['id']) }}" method="POST">
                                @csrf
                                <select name="tersedia"
                                        class="form-select form-select-sm fw-semibold {{ $m['tersedia'] ? 'border-success text-success' : 'border-danger text-danger' }}"
                                        onchange="this.form.submit()">
                                    <option value="1" @selected($m['tersedia'])>Tersedia</option>
                                    <option value="0" @selected(!$m['tersedia'])>Habis</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>