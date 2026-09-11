<?php

namespace App\Services;

class ProdukService
{
    public function getAllProduk(): array
    {
        return [
            ['nama' => 'Indomie', 'kategori' => 'Makanan', 'harga' => 3000, 'stok' => 20],
            ['nama' => 'Aqua', 'kategori' => 'Minuman', 'harga' => 4000, 'stok' => 0],
            ['nama' => 'Teh Botol', 'kategori' => 'Minuman', 'harga' => 5000, 'stok' => 15],
            ['nama' => 'Roti Tawar', 'kategori' => 'Makanan', 'harga' => 12000, 'stok' => 8],
            ['nama' => 'Kopi Kaleng', 'kategori' => 'Minuman', 'harga' => 8000, 'stok' => 0],
        ];
    }

    
    // Filter 1: berdasarkan kategori
    public function getByKategori(string $kategori): array
    {
        return array_values(array_filter(
            $this->getAllProduk(),
            fn($item) => strtolower($item['kategori']) === strtolower($kategori)
        ));
    }
 
    // Filter 2: produk yang masih tersedia (stok > 0)
    public function getTersedia(): array
    {
        return array_values(array_filter(
            $this->getAllProduk(),
            fn($item) => $item['stok'] > 0
        ));
    }
 
    // Filter 3: harga di atas nilai tertentu
    public function getDiAtasHarga(int $nilai): array
    {
        return array_values(array_filter(
            $this->getAllProduk(),
            fn($item) => $item['harga'] > $nilai
        ));
    }
 
    // Filter 4: jumlah seluruh produk
    public function getJumlahProduk(): int
    {
        return count($this->getAllProduk());
    }
 
    // Filter 5: produk dengan stok paling banyak
    public function getStokTerbanyak(): array
    {
        $produk = $this->getAllProduk();
 
        usort($produk, fn($a, $b) => $b['stok'] <=> $a['stok']);
 
        return $produk[0]; // produk pertama setelah diurutkan = stok terbanyak
    }

}
