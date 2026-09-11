<?php

class Menu {
    protected string $kode;
    public string $nama;
    protected int $harga;
    public string $kategori;
    private int $stok;

    public function __construct(string $kode, string $nama, int $harga, string $kategori, int $stok) {
        $this->kode = $kode;
        $this->nama = $nama;
        $this->harga = max(0, $harga);
        $this->kategori = $kategori;
        $this->stok = max(0, $stok);
    }

    public function tambahStok(int $jumlah): string {
        if ($jumlah < 0) {
            return "Tidak bisa menambah stok secara negatif";
        }
        $this->stok += $jumlah;
        return "Stok berhasil ditambah";
    }

    public function kurangiStok(int $jumlah): string {
        if ($jumlah < 0) {
            return "Tidak bisa mengurangi stok secara negatif";
        }
        if ($jumlah > $this->stok) {
            return "Stok tidak mencukupi";
        }
        $this->stok -= $jumlah;
        return "Stok berhasil dikurangi";
    }

    public function hitungTotalHarga(int $jumlah): string {
        $total = $jumlah * $this->harga;
        return "Total anda: Rp" . $total;
    }

    public function getData(): array {
        $kode = $this->kode;
        $nama = $this->nama;
        $harga = $this->harga;
        $kategori = $this->kategori;
        $stok = $this->stok;
        $status = $this->stok <= 0 ? "Habis" : "Tersedia";

        return compact("kode", "nama", "harga", "kategori", "stok", "status");
    }
}

class MenuMinuman extends Menu {
    public function __construct(string $kode, string $nama, int $harga, string $kategori, int $stok) {
        parent::__construct($kode, $nama, $harga, $kategori, $stok);
    }
}

class MenuMakanan extends Menu {
    public function __construct(string $kode, string $nama, int $harga, string $kategori, int $stok) {
        parent::__construct($kode, $nama, $harga, $kategori, $stok);
    }
}

//programnya di cli

$daftarMenu = [];
$daftarMenu[] = new MenuMakanan("F001", "Nasi Goreng", 15000, "Makanan", 10);
$daftarMenu[] = new MenuMakanan("F002", "Ayam Geprek", 18000, "Makanan", 8);
$daftarMenu[] = new MenuMinuman("D001", "Es Teh", 5000, "Minuman", 20);
$daftarMenu[] = new MenuMinuman("D002", "Es Jeruk", 7000, "Minuman", 15);
$daftarMenu[] = new MenuMinuman("D003", "Kopi Susu", 12000, "Minuman", 0);

function tampilkanSemuaMenu(array $daftarMenu): void {
    $kategoriList = [];
    foreach ($daftarMenu as $menu) {
        $data = $menu->getData();
        $kategoriList[$data['kategori']][] = $data;
    }

    foreach ($kategoriList as $kategori => $items) {
        echo "\n== $kategori ==\n";
        foreach ($items as $data) {
            echo "[{$data['kode']}] {$data['nama']} - Rp{$data['harga']} - Stok: {$data['stok']} - {$data['status']}\n";
        }
    }
}
function cariMenuByIndex(array $daftarMenu, string $index): ?Menu {
    if (!isset($daftarMenu[$index])) {
        return null;
    }
    return $daftarMenu[$index];
}

//ini pas nanti dirun keluarnya ini (ribet emang tapi why not)
while (true) {
    echo "\n=== Sistem CLI Kantin ===\n";
    tampilkanSemuaMenu($daftarMenu);

    echo "\n--- Nomor urut menu (untuk aksi) ---\n";
    foreach ($daftarMenu as $i => $menu) {
        $data = $menu->getData();
        echo "[$i] {$data['nama']}\n";
    }

    echo "\n1. Beli menu (kurangi stok)\n";
    echo "2. Tambah stok\n";
    echo "3. Keluar\n";
    echo "Pilih: ";
    $pilihan = trim(fgets(STDIN));

    if ($pilihan == "3") {
        break;
    }

    if (in_array($pilihan, ["1", "2"])) {
        echo "Pilih nomor menu: ";
        $index = trim(fgets(STDIN));
        $menu = cariMenuByIndex($daftarMenu, $index);

        if ($menu === null) {
            echo "Nomor menu tidak valid.\n";
            continue;
        }

        echo "Jumlah: ";
        $jumlah = (int) trim(fgets(STDIN));

        if ($pilihan == "1") {
            $hasil = $menu->kurangiStok($jumlah);
            echo $hasil . "\n";
            if ($hasil == "Stok berhasil dikurangi") {
                echo $menu->hitungTotalHarga($jumlah) . "\n";
            }
        } else {
            echo $menu->tambahStok($jumlah) . "\n";
        }
    } else {
        echo "Pilihan tidak dikenal.\n";
    }
}

echo "Program selesai.\n";