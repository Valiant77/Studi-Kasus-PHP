<!DOCTYPE html>
<html>
    <head>
        <title>Dafter Menu Kantin Sekolah</title>
    </head>
    <body>
        <h1>Dafter Menu Kantin Sekolah</h1>
        <p>--------------------------</p>
        <table>
            @foreach ($menu as $m)
            <tr>
            <td>{{ $loop->iteration }}.</td>
            <td>{{ $m['nama'] }}</td>
            <td>{{ $m['harga'] }}</td>
            <td>{{ $m['tersedia'] ? "Tersedia" : "Habis" }}</td>
            <td><a href="{{ route('change', [$m['id'], $m['tersedia']]) }}"><button>Ganti</button></a></td>
            </tr>
            @endforeach
        </table>
    </body>
</html>