<table border=1>
    <p>
        <a href="/produk">Semua</a> |
        <a href="/produk?kategori=Makanan">Makanan</a> |
        <a href="/produk?kategori=Minuman">Minuman</a> |
        <a href="/produk?tersedia=1">Hanya Tersedia</a> |
        <a href="/produk?harga_min=5000">Harga di atas 5000</a>
    </p>
    <tr>
        <td colspan=5>Daftar Menu</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>Kategori</td>
        <td>Harga</td>
        <td>Stok</td>
        <td>Status</td>
    </tr>
    @foreach ($produk as $item)
    <tr>
        <td>{{ $item['nama'] }}</td>
        <td>{{ $item['kategori'] }}</td>
        <td>Rp{{ number_format($item['harga']) }}</td>
        <td>{{ $item['stok'] }}</td>
        <td> {{ $item['stok'] === 0 ? 'Habis' : 'Tersedia' }} </td>
    </tr>
    @endforeach
    <tr>
        <td colspan=5>Jumlah seluruh produk: {{ $jumlah }}</td>
    </tr>
    <tr>
        <td colspan=5>Stok paling banyak: {{ $terbanyak['nama'] }} ({{ $terbanyak['stok'] }} pcs)</td>
    </tr>
</table>

